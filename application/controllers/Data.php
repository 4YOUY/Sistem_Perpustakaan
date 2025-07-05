<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
     $this->data['CI'] =& get_instance();
     $this->load->helper(array('form', 'url'));
     $this->load->library('upload'); // Tambahkan ini
     $this->load->model('M_Admin');
		if($this->session->userdata('masuk_sistem_rekam') != TRUE){
				$url=base_url('login');
				redirect($url);
		}
	}

	public function index()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['buku'] = $this->db->query("
	SELECT 
		MIN(id_buku) as id_buku,
		isbn,
		title,
		penerbit,
		thn_buku,
		tgl_masuk,
		sampul,
		COUNT(*) as jml,
		-- Hitung jumlah yang dipinjam
		(SELECT COUNT(*) FROM tbl_pinjam tp 
		 JOIN tbl_buku tb ON tb.buku_id = tp.buku_id 
		 WHERE tb.isbn = tbl_buku.isbn AND tp.status = 'Dipinjam') as dipinjam,
		-- Hitung stok tersedia
		(COUNT(*) - (SELECT COUNT(*) FROM tbl_pinjam tp 
					 JOIN tbl_buku tb ON tb.buku_id = tp.buku_id 
					 WHERE tb.isbn = tbl_buku.isbn AND tp.status = 'Dipinjam')) as stok_tersedia
	FROM tbl_buku 
	GROUP BY isbn
	ORDER BY id_buku DESC
");

        $this->data['title_web'] = 'Data Buku';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('buku/buku_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function bukudetail()
{
    $this->data['idbo'] = $this->session->userdata('ses_id');
    $count = $this->M_Admin->CountTableId('tbl_buku','id_buku',$this->uri->segment('3'));
    
    if($count > 0)
    {
        $id_buku = $this->uri->segment('3');
        $buku = $this->M_Admin->get_tableid_edit('tbl_buku', 'id_buku', $id_buku);
        $isbn = $buku->isbn;

        $this->data['buku'] = $buku;

        // Ambil jumlah stok dan jumlah pinjam berdasarkan ISBN
        $this->data['jumlah_buku'] = $this->db->where('isbn', $isbn)->count_all_results('tbl_buku');
        
        // Hitung jumlah yang dipinjam berdasarkan ISBN
        $this->db->from('tbl_pinjam');
        $this->db->join('tbl_buku', 'tbl_buku.buku_id = tbl_pinjam.buku_id');
        $this->db->where('tbl_buku.isbn', $isbn);
        $this->db->where('tbl_pinjam.status', 'Dipinjam');
        $this->data['jumlah_pinjam'] = $this->db->count_all_results();

        // Hitung stok tersedia
        $this->data['stok_tersedia'] = $this->data['jumlah_buku'] - $this->data['jumlah_pinjam'];

        $this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
        $this->data['rakbuku'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC")->result_array();

        // Tambahkan URL kembali berdasarkan level user
        $this->data['back_url'] = $this->get_back_url();

    } else {
        // Perbaiki redirect berdasarkan level user
        echo '<script>alert("BUKU TIDAK DITEMUKAN");window.location="'.$this->get_back_url().'"</script>';
        return;
    }

    $this->data['title_web'] = 'Data Buku Detail';
    $this->load->view('header_view',$this->data);
    $this->load->view('sidebar_view',$this->data);
    $this->load->view('buku/detail',$this->data);
    $this->load->view('footer_view',$this->data);
}

// Tambahkan method helper ini
private function get_back_url() 
{
    $level = $this->session->userdata('level'); // Sesuaikan dengan nama session level Anda
    
    switch($level) {
        case 'Anggota':
            return base_url('dashboard/anggota'); // Sesuaikan dengan route dashboard anggota
        case 'petugas':
            return base_url('data');
    }
}

	public function bukuedit($id)
	{
	    $this->data['idbo'] = $this->session->userdata('ses_id');

	    $query = $this->db->get_where('tbl_buku', ['id_buku' => $id]);
	    if ($query->num_rows() == 0) {
	        redirect('data');
	    }

	    $row = $query->row();
	    $isbn = $row->isbn;

	    // ✅ Ambil total jumlah buku berdasarkan ISBN
	    $total_stok = $this->db->query("SELECT COUNT(*) AS total FROM tbl_buku WHERE isbn = ?", [$isbn])->row();

	    // ✅ Tambahkan total stok ke dalam $row (objek buku)
	    $row->jml = $total_stok->total;

	    // ✅ Tambahkan data buku ke view
	    $this->data['buku'] = $row;

	    // Tambahkan juga data rak & kategori
	    $this->data['rakbuku'] = $this->M_Admin->get_table('tbl_rak');
	    $this->data['kats'] = $this->M_Admin->get_table('tbl_kategori');

	    // Tambahkan data user buat header
	    $this->data['user'] = $this->db->get_where('tbl_login', ['id_login' => $this->data['idbo']])->row();

	    $this->data['title_web'] = 'Edit Buku';

	    // Load view
	    $this->load->view('header_view', $this->data);
	    $this->load->view('sidebar_view', $this->data);
	    $this->load->view('buku/edit_view', $this->data);
	    $this->load->view('footer_view', $this->data);
	}

	public function bukutambah()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');

		$this->data['kats'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC")->result_array();
		$this->data['rakbuku'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC")->result_array();

        $this->data['title_web'] = 'Tambah Buku';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('buku/tambah_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

    public function prosesbuku()
    {
        if (!empty($this->input->post('tambah'))) {
            $post = $this->input->post();
    
            $config['upload_path'] = './assets_style/image/buku/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
    
            $this->load->library('upload', $config);
    
            $sampul_name = '';
            $lampiran_name = '';
    
            // Upload sampul
            if (!empty($_FILES['gambar']['name'])) {
                $this->upload->initialize($config);
                if ($this->upload->do_upload('gambar')) {
                    $file = $this->upload->data();
                    $sampul_name = $file['file_name'];
                } else {
                    echo $this->upload->display_errors(); exit;
                }
            }
    
            // Upload lampiran
            if (!empty($_FILES['lampiran']['name'])) {
                $config['allowed_types'] = 'pdf|doc|docx';
                $this->upload->initialize($config);
                if ($this->upload->do_upload('lampiran')) {
                    $file = $this->upload->data();
                    $lampiran_name = $file['file_name'];
                } else {
                    echo $this->upload->display_errors(); exit;
                }
            }
    
            // Ambil input kode awal dan jumlah
            $kode_awal = strtoupper(trim(htmlentities($post['kode_buku_awal']))); // MJ-0001
            $jumlah = (int) htmlentities($post['jml']); // 23
    
            // Pisahkan prefix & nomor awal
            preg_match('/([A-Z]+)-?(\d+)/', $kode_awal, $match);
            $prefix = isset($match[1]) ? $match[1] : 'BK';
            $start_num = isset($match[2]) ? (int)$match[2] : 1;
    
            $data_insert = [];
    
            for ($i = 0; $i < $jumlah; $i++) {
                $kode_buku = $prefix . '-' . str_pad($start_num + $i, 4, '0', STR_PAD_LEFT);
    
                $data_insert[] = array(
                    'buku_id' => $kode_buku,
                    'id_kategori' => htmlentities($post['kategori']),
                    'id_rak' => htmlentities($post['rak']),
                    'isbn' => htmlentities($post['isbn']),
                    'sampul' => $sampul_name,
                    'lampiran' => $lampiran_name,
                    'title' => htmlentities($post['title']),
                    'tgl_masuk' => date('Y-m-d H:i:s'),
                    'pengarang' => htmlentities($post['pengarang']),
                    'penerbit' => htmlentities($post['penerbit']),
                    'thn_buku' => htmlentities($post['thn']),
                    'isi' => $this->input->post('ket'),
                    'jml' => 1
                );
            }
    
            $this->db->insert_batch('tbl_buku', $data_insert);
    
            $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
            <p>Tambah Buku Berhasil!</p></div></div>');
            redirect(base_url('data'));
        } else {
            // EDIT
            $post = $this->input->post();
    
            $id_buku = htmlentities($post['edit']);
            $jumlah_baru = (int) htmlentities($post['jml']);
            $sampul_name = $post['gmbr'];
            $lampiran_name = $post['lamp'];
    
            // Cek apakah user upload gambar baru
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path'] = './assets_style/image/buku/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
    
                $this->upload->initialize($config);
                if ($this->upload->do_upload('gambar')) {
                    $file = $this->upload->data();
                    $sampul_name = $file['file_name'];
                }
            }
    
            // Upload lampiran baru jika ada
            if (!empty($_FILES['lampiran']['name'])) {
                $config['upload_path'] = './assets_style/image/buku/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['encrypt_name'] = TRUE;
    
                $this->upload->initialize($config);
                if ($this->upload->do_upload('lampiran')) {
                    $file = $this->upload->data();
                    $lampiran_name = $file['file_name'];
                }
            }
    
            // Ambil data buku yang akan diedit
            $buku = $this->db->get_where('tbl_buku', ['id_buku' => $id_buku])->row();
            $isbn = $buku->isbn;
    
            // Hitung jumlah stok saat ini
            $total_stok = $this->db->where('isbn', $isbn)->count_all_results('tbl_buku');
    
            // Jika stok baru lebih besar, tambah entri baru
            if ($jumlah_baru > $total_stok) {
                $selisih = $jumlah_baru - $total_stok;
                
                // Ambil data template dari buku yang diedit
                $template = $this->db->get_where('tbl_buku', ['id_buku' => $id_buku])->row();
                
                // Generate kode buku baru
                preg_match('/([A-Z]+)-?(\d+)/', $template->buku_id, $match);
                $prefix = isset($match[1]) ? $match[1] : 'BK';
                
                // Cari nomor terakhir untuk prefix ini
                $last_book = $this->db->query("SELECT buku_id FROM tbl_buku WHERE buku_id LIKE '$prefix-%' ORDER BY buku_id DESC LIMIT 1")->row();
                if ($last_book) {
                    preg_match('/([A-Z]+)-?(\d+)/', $last_book->buku_id, $last_match);
                    $start_num = isset($last_match[2]) ? (int)$last_match[2] + 1 : 1;
                } else {
                    $start_num = 1;
                }
                
                $data_insert = [];
                for ($i = 0; $i < $selisih; $i++) {
                    $kode_buku = $prefix . '-' . str_pad($start_num + $i, 4, '0', STR_PAD_LEFT);
                    
                    $data_insert[] = array(
                        'buku_id' => $kode_buku,
                        'id_kategori' => htmlentities($post['kategori']),
                        'id_rak' => htmlentities($post['rak']),
                        'isbn' => htmlentities($post['isbn']),
                        'sampul' => $sampul_name,
                        'lampiran' => $lampiran_name,
                        'title' => htmlentities($post['title']),
                        'tgl_masuk' => date('Y-m-d H:i:s'),
                        'pengarang' => htmlentities($post['pengarang']),
                        'penerbit' => htmlentities($post['penerbit']),
                        'thn_buku' => htmlentities($post['thn']),
                        'isi' => $this->input->post('ket'),
                        'jml' => 1
                    );
                }
                
                $this->db->insert_batch('tbl_buku', $data_insert);
            }
            // Jika stok baru lebih kecil, hapus entri terakhir
            elseif ($jumlah_baru < $total_stok) {
                $selisih = $total_stok - $jumlah_baru;
    
                $this->db->where('isbn', $isbn);
                $this->db->order_by('id_buku', 'DESC');
                $this->db->limit($selisih);
                $to_delete = $this->db->get('tbl_buku')->result();
    
                foreach ($to_delete as $row) {
                    $this->db->delete('tbl_buku', ['id_buku' => $row->id_buku]);
                }
            }
    
            // Update semua entri dengan ISBN yang sama
            $this->db->where('isbn', $isbn);
            $this->db->update('tbl_buku', array(
                'id_kategori' => htmlentities($post['kategori']),
                'id_rak' => htmlentities($post['rak']),
                'isbn' => htmlentities($post['isbn']),
                'sampul' => $sampul_name,
                'lampiran' => $lampiran_name,
                'title' => htmlentities($post['title']),
                'pengarang' => htmlentities($post['pengarang']),
                'penerbit' => htmlentities($post['penerbit']),
                'thn_buku' => htmlentities($post['thn']),
                'isi' => $this->input->post('ket'),
            ));
    
            $this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
            <p>Edit Buku Berhasil!</p></div></div>');
            redirect(base_url('data'));
        }
    }
    
    public function hapusbuku($id_buku = null)
	{
	    if ($id_buku == null) {
	        $this->session->set_flashdata('error', 'ID Buku tidak ditemukan.');
	        redirect('data/buku');
	    }

	    // Ambil data buku pertama
	    $buku = $this->db->get_where('tbl_buku', ['id_buku' => $id_buku])->row();
	    if (!$buku) {
	        $this->session->set_flashdata('error', 'Data buku tidak ditemukan.');
	        redirect('data/buku');
	    }

	    $isbn = $buku->isbn;

	    // Hapus semua file sampul
	    $bukus = $this->db->get_where('tbl_buku', ['isbn' => $isbn])->result();
	    foreach ($bukus as $b) {
	        if (!empty($b->sampul) && $b->sampul != '0') {
	            $path = './assets_style/image/buku/' . $b->sampul;
	            if (file_exists($path)) {
	                unlink($path);
	            }
	        }
	    }

	    // Hapus semua eksemplar buku berdasarkan ISBN
	    $this->db->where('isbn', $isbn);
	    $this->db->delete('tbl_buku');

	    $this->session->set_flashdata('pesan', '<div class="alert alert-success">Semua data buku berhasil dihapus.</div>');
	    redirect('data');
	}
	
	public function kategori()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['kategori'] =  $this->db->query("SELECT * FROM tbl_kategori ORDER BY id_kategori DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_kategori','id_kategori',$id);
			if($count > 0)
			{			
				$this->data['kat'] = $this->db->query("SELECT *FROM tbl_kategori WHERE id_kategori='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/kategori').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Kategori ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('kategori/kat_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function katproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);

			$this->db->insert('tbl_kategori', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_kategori'=>htmlentities($post['kategori']),
			);
			$this->db->where('id_kategori',htmlentities($post['edit']));
			$this->db->update('tbl_kategori', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 		
		}

		if(!empty($this->input->get('kat_id')))
		{
			$this->db->where('id_kategori',$this->input->get('kat_id'));
			$this->db->delete('tbl_kategori');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Kategori Sukses !</p>
			</div></div>');
			redirect(base_url('data/kategori')); 
		}
	}

	public function rak()
	{
		
        $this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['rakbuku'] =  $this->db->query("SELECT * FROM tbl_rak ORDER BY id_rak DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_rak','id_rak',$id);
			if($count > 0)
			{	
				$this->data['rak'] = $this->db->query("SELECT *FROM tbl_rak WHERE id_rak='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('data/rak').'"</script>';
			}
		}

        $this->data['title_web'] = 'Data Rak Buku ';
        $this->load->view('header_view',$this->data);
        $this->load->view('sidebar_view',$this->data);
        $this->load->view('rak/rak_view',$this->data);
        $this->load->view('footer_view',$this->data);
	}

	public function rakproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_rak'=>htmlentities($post['rak']),
			);

			$this->db->insert('tbl_rak', $data);

			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Rak Buku Sukses !</p>
			</div></div>');
			redirect(base_url('data/rak'));  
		}

		if(!empty($this->input->post('edit')))
		{
			$post= $this->input->post();
			$data = array(
				'nama_rak'=>htmlentities($post['rak']),
			);
			$this->db->where('id_rak',htmlentities($post['edit']));
			$this->db->update('tbl_rak', $data);


			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Rak Sukses !</p>
			</div></div>');
			redirect(base_url('data/rak')); 		
		}

		if(!empty($this->input->get('rak_id')))
		{
			$this->db->where('id_rak',$this->input->get('rak_id'));
			$this->db->delete('tbl_rak');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Rak Buku Sukses !</p>
			</div></div>');
			redirect(base_url('data/rak')); 
		}
	}
}