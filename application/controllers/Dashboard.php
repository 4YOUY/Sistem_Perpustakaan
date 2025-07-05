<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		// Validasi jika user belum login
		$this->data['CI'] =& get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		if($this->session->userdata('masuk_sistem_rekam') != TRUE){
			redirect(base_url('login'));
		}
	}

	public function index()
	{	
		$level = $this->session->userdata('level');

		// Redirect berdasarkan level user
		if ($level == 'Pimpinan') {
			redirect(base_url('dashboard/pimpinan'));
		} elseif ($level == 'Anggota') {
			redirect(base_url('dashboard/anggota'));
		}

		// Jika level adalah Admin/Petugas, tampilkan dashboard admin
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['title_web'] = 'Dashboard Admin';
		$this->data['count_pengguna'] = $this->db->query("SELECT * FROM tbl_login")->num_rows();
		$this->data['count_buku'] = $this->db->query("SELECT * FROM tbl_buku")->num_rows();
		$this->data['count_pinjam'] = $this->db->query("SELECT * FROM tbl_pinjam WHERE status = 'Dipinjam'")->num_rows();
		$this->data['count_kembali'] = $this->db->query("SELECT * FROM tbl_pinjam WHERE status = 'Di Kembalikan'")->num_rows();

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('dashboard_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}

    public function pimpinan()
    {
        if($this->session->userdata('masuk_sistem_rekam') != TRUE){
            redirect(base_url('login'));
        }

        $this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['title_web'] = 'Laporan Perpustakaan';

        $jenis_laporan = $this->input->post('jenis_laporan') ? $this->input->post('jenis_laporan') : 'harian';
        $tanggal = $this->input->post('tanggal') ? $this->input->post('tanggal') : date('Y-m-d');
        $bulan = $this->input->post('bulan') ? $this->input->post('bulan') : date('Y-m');

        $this->data['jenis_laporan'] = $jenis_laporan;
        $this->data['tanggal'] = $tanggal;
        $this->data['bulan'] = $bulan;

        $where_condition = '';
        $where_condition_kembali = '';
        $periode_display = '';

        switch($jenis_laporan) {
            case 'harian':
                $where_condition = "DATE(p.tgl_pinjam) = '$tanggal'";
                $where_condition_kembali = "DATE(p.tgl_kembali) = '$tanggal'";
                $periode_display = date('d F Y', strtotime($tanggal));
                break;
            case 'mingguan':
                $start_week = date('Y-m-d', strtotime('monday this week', strtotime($tanggal)));
                $end_week = date('Y-m-d', strtotime('sunday this week', strtotime($tanggal)));
                $where_condition = "DATE(p.tgl_pinjam) BETWEEN '$start_week' AND '$end_week'";
                $where_condition_kembali = "DATE(p.tgl_kembali) BETWEEN '$start_week' AND '$end_week'";
                $periode_display = date('d F Y', strtotime($start_week)) . ' - ' . date('d F Y', strtotime($end_week));
                break;
            case 'bulanan':
                $where_condition = "DATE_FORMAT(p.tgl_pinjam, '%Y-%m') = '$bulan'";
                $where_condition_kembali = "DATE_FORMAT(p.tgl_kembali, '%Y-%m') = '$bulan'";
                $periode_display = date('F Y', strtotime($bulan . '-01'));
                break;
        }

        $this->data['periode_display'] = $periode_display;
        $this->data['total_anggota'] = $this->db->query("SELECT * FROM tbl_login")->num_rows();
		$this->data['total_judul_buku'] = $this->db->query("SELECT * FROM tbl_buku")->num_rows();
        $this->data['total_buku'] = $this->db->query("SELECT SUM(jml) AS total FROM tbl_buku")->row()->total;

        $query_peminjaman = $this->db->query("
            SELECT p.*, l.nama as nama_peminjam, b.title 
            FROM tbl_pinjam p 
            LEFT JOIN tbl_login l ON p.anggota_id = l.anggota_id 
            LEFT JOIN tbl_buku b ON p.buku_id = b.buku_id 
            WHERE $where_condition
            ORDER BY p.tgl_pinjam DESC
        ");
        $this->data['data_peminjaman'] = $query_peminjaman->result();
        $this->data['total_peminjaman'] = $query_peminjaman->num_rows();

        $query_pengembalian = $this->db->query("
            SELECT p.*, l.nama as nama_peminjam, b.title, COALESCE(d.denda, 0) as denda
            FROM tbl_pinjam p 
            LEFT JOIN tbl_login l ON p.anggota_id = l.anggota_id 
            LEFT JOIN tbl_buku b ON p.buku_id = b.buku_id 
            LEFT JOIN tbl_denda d ON p.pinjam_id = d.pinjam_id
            WHERE p.status = 'Di Kembalikan' AND $where_condition_kembali
            ORDER BY p.tgl_kembali DESC
        ");
        $this->data['data_pengembalian'] = $query_pengembalian->result();
        $this->data['total_pengembalian'] = $query_pengembalian->num_rows();

        $query_total_denda = $this->db->query("
            SELECT COALESCE(SUM(d.denda), 0) as total_denda
            FROM tbl_pinjam p 
            LEFT JOIN tbl_denda d ON p.pinjam_id = d.pinjam_id
            WHERE p.status = 'Di Kembalikan' AND $where_condition_kembali
        ");
        $total_denda_result = $query_total_denda->row();
        $this->data['total_denda'] = $total_denda_result ? $total_denda_result->total_denda : 0;

        $query_terlambat = $this->db->query("
            SELECT COUNT(*) as total_terlambat
            FROM tbl_pinjam p 
            LEFT JOIN tbl_denda d ON p.pinjam_id = d.pinjam_id
            WHERE p.status = 'Di Kembalikan' AND d.denda > 0 AND $where_condition_kembali
        ");
        $terlambat_result = $query_terlambat->row();
        $this->data['total_terlambat'] = $terlambat_result ? $terlambat_result->total_terlambat : 0;

        $this->data['chart_data'] = array(
            'dipinjam' => $this->data['total_peminjaman'],
            'dikembalikan' => $this->data['total_pengembalian'],
            'terlambat' => $this->data['total_terlambat']
        );

        $this->data['buku_populer'] = $this->db->query("
			SELECT b.title, b.pengarang, COUNT(p.buku_id) as jumlah_dipinjam
			FROM tbl_pinjam p
			LEFT JOIN tbl_buku b ON p.buku_id = b.buku_id
			WHERE $where_condition
			GROUP BY b.title
			ORDER BY jumlah_dipinjam DESC
			LIMIT 10
		")->result();

        $query_buku_tersedia = $this->db->query("
        SELECT 
            b.title, 
            b.pengarang, 
            SUM(b.jml) as jumlah_buku, 
            MAX(b.tgl_masuk) as tgl_masuk
        FROM tbl_buku b
        WHERE b.jml > 0
        GROUP BY b.title, b.pengarang
        ORDER BY MAX(b.tgl_masuk) DESC
        LIMIT 10
");
        $this->data['buku_tersedia'] = $query_buku_tersedia->result();
        
        $this->data['buku_terbaru'] = $this->db->query("
            SELECT 
                title, 
                pengarang, 
                MAX(tgl_masuk) as tgl_masuk, 
                SUM(jml) as jml
            FROM tbl_buku
            GROUP BY title, pengarang
            ORDER BY MAX(tgl_masuk) DESC
            LIMIT 5
        ")->result();
        
        $this->load->view('header_view', $this->data);
        $this->load->view('dashboard_pimpinan_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function anggota() {
        // Validasi jika user belum login
        if($this->session->userdata('masuk_sistem_rekam') != TRUE){
            redirect(base_url('login'));
        }

        $this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['title_web'] = 'Dashboard Anggota';

        // Ambil data buku terpopuler berdasarkan jumlah dipinjam
        $query_populer = $this->db->query("
            SELECT 
                b.isbn,
                b.title, 
                b.pengarang, 
                b.sampul,
                COUNT(p.buku_id) as jumlah_dipinjam
            FROM tbl_pinjam p
            LEFT JOIN tbl_buku b ON p.buku_id = b.buku_id
            WHERE p.status = 'Dipinjam' OR p.status = 'Di Kembalikan'
            GROUP BY b.isbn, b.title, b.pengarang, b.sampul
            ORDER BY jumlah_dipinjam DESC
            LIMIT 6
        ");
        $this->data['buku_populer'] = $query_populer->result();

        // Ambil semua list buku yang tersedia
        $this->data['list_buku'] = $this->db->query("
            SELECT 
                MIN(id_buku) as id_buku,
                isbn,
                title,
                pengarang,
                penerbit,
                thn_buku,
                sampul,
                COUNT(*) as total_stok,
                -- Hitung jumlah yang dipinjam
                (SELECT COUNT(*) FROM tbl_pinjam tp 
                 JOIN tbl_buku tb ON tb.buku_id = tp.buku_id 
                 WHERE tb.isbn = tbl_buku.isbn AND tp.status = 'Dipinjam') as dipinjam,
                -- Hitung stok tersedia
                (COUNT(*) - (SELECT COUNT(*) FROM tbl_pinjam tp 
                             JOIN tbl_buku tb ON tb.buku_id = tp.buku_id 
                             WHERE tb.isbn = tbl_buku.isbn AND tp.status = 'Dipinjam')) as stok_tersedia
            FROM tbl_buku 
            GROUP BY isbn, title, pengarang, penerbit, thn_buku, sampul
            ORDER BY title ASC
        ")->result();

        // Load views
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('dashboard_anggota_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function user() {
        // Logika dashboard untuk user
    }
}
?>