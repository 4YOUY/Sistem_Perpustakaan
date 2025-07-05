<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
		$this->data['CI'] =& get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		$this->load->library(array('cart'));
		if($this->session->userdata('masuk_sistem_rekam') != TRUE){
			$url=base_url('login');
			redirect($url);
		}
	 }

	public function index()
	{	
		$this->data['title_web'] = 'Data Pinjam Buku ';
		$this->data['idbo'] = $this->session->userdata('ses_id');
		
		if($this->session->userdata('level') == 'Anggota'){
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `anggota_id`, 
				`status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` 
				FROM tbl_pinjam WHERE status = 'Dipinjam' 
				AND anggota_id = ? ORDER BY pinjam_id DESC", 
				array($this->session->userdata('anggota_id')));
		}else{
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `anggota_id`, 
				`status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` 
				FROM tbl_pinjam WHERE status = 'Dipinjam' ORDER BY pinjam_id DESC");
		}
		
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('pinjam/pinjam_view',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function proseskembali($id = null)
	{
		if ($this->session->userdata('masuk_sistem_rekam') != TRUE) {
			redirect(base_url('login'));
		}
	
		if ($id == null) {
			$id = $this->input->post('pinjam_id');
		}
	
		$check_pinjam = $this->db->get_where('tbl_pinjam', ['pinjam_id' => $id, 'status' => 'Dipinjam'])->num_rows();
		if ($check_pinjam == 0) {
			$this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan atau sudah dikembalikan!');
			redirect(base_url('transaksi'));
			return;
		}
	
		$pinjam = $this->db->get_where('tbl_pinjam', ['pinjam_id' => $id])->row();
		$tgl_kembali = date('Y-m-d');
	
		$tgl_balik = strtotime($pinjam->tgl_balik);
		$hari_ini = strtotime($tgl_kembali);
		$selisih = ceil(($hari_ini - $tgl_balik) / (60 * 60 * 24));
	
		$denda_info = $this->db->get_where('tbl_biaya_denda', ['stat' => 'Aktif'])->row();
		$tarif_perhari = $denda_info ? $denda_info->harga_denda : 0;
		$total_denda = ($selisih > 0) ? $tarif_perhari * $selisih : 0;
	
		// Update status dan tanggal kembali
		$this->db->update('tbl_pinjam', [
			'tgl_kembali' => $tgl_kembali,
			'status' => 'Di Kembalikan'
		], ['pinjam_id' => $id]);
	
		// Tambah stok bukunya
		$this->db->query("UPDATE tbl_buku SET jml = jml + 1 WHERE buku_id = ?", [$pinjam->buku_id]);
	
		if ($total_denda > 0) {
			$this->db->insert('tbl_denda', [
				'pinjam_id' => $id,
				'denda' => $total_denda,
				'tgl_denda' => $tgl_kembali
			]);
		}
	
		$this->session->set_flashdata('pesan', '<div class="alert alert-success">Buku berhasil dikembalikan! Denda: ' . $this->M_Admin->rp($total_denda) . '</div>');
		redirect(base_url('transaksi'));
	}
	

public function kembali()
{    
    $this->data['title_web'] = 'Data Pengembalian Buku ';
    $this->data['idbo'] = $this->session->userdata('ses_id');

    if($this->session->userdata('level') == 'Anggota'){
        $this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `anggota_id`, 
            `status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` 
            FROM tbl_pinjam WHERE anggota_id = ? AND status = 'Di Kembalikan' 
            ORDER BY pinjam_id DESC",array($this->session->userdata('anggota_id')));
    }else{
        $this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `anggota_id`, 
            `status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` 
            FROM tbl_pinjam WHERE status = 'Di Kembalikan' ORDER BY pinjam_id DESC");
    }
    
    $this->load->view('header_view',$this->data);
    $this->load->view('sidebar_view',$this->data);
    $this->load->view('kembali/home',$this->data);
    $this->load->view('footer_view',$this->data);
}

public function pinjam()
{	
	$this->session->unset_userdata('cart'); 
	$this->data['nop'] = $this->M_Admin->buat_kode('tbl_pinjam','PJ','id_pinjam','ORDER BY id_pinjam DESC LIMIT 1'); 
	$this->data['idbo'] = $this->session->userdata('ses_id');
	$this->data['user'] = $this->M_Admin->get_table('tbl_login');
	$this->data['buku'] = $this->db->query("
    SELECT 
        MIN(b.buku_id) AS buku_id,
        MIN(b.id_buku) AS id_buku,
        b.isbn,
        b.title,
        b.penerbit,
        b.thn_buku,
        COUNT(*) AS jml,
        MAX(b.tgl_masuk) AS tgl_masuk
    FROM tbl_buku b
    LEFT JOIN tbl_pinjam p ON b.buku_id = p.buku_id AND p.status = 'Dipinjam'
    WHERE p.buku_id IS NULL
    GROUP BY b.isbn, b.title, b.penerbit, b.thn_buku
");

	$this->data['title_web'] = 'Tambah Pinjam Buku ';

	$this->load->view('header_view',$this->data);
	$this->load->view('sidebar_view',$this->data);
	$this->load->view('pinjam/tambah_view',$this->data);
	$this->load->view('footer_view',$this->data);
}
	public function detailpinjam()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');		
		$id = $this->uri->segment('3');
		if($this->session->userdata('level') == 'Anggota'){
			$count = $this->db->get_where('tbl_pinjam',[
				'pinjam_id' => $id, 
				'anggota_id' => $this->session->userdata('anggota_id')
			])->num_rows();
			if($count > 0)
			{
				$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
				`anggota_id`, `status`, 
				`tgl_pinjam`, `lama_pinjam`, 
				`tgl_balik`, `tgl_kembali` 
				FROM tbl_pinjam WHERE pinjam_id = ? 
				AND anggota_id =?", 
				array($id,$this->session->userdata('anggota_id')))->row();
			}else{
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="'.base_url('transaksi').'"</script>';
			}
		}else{
			$count = $this->M_Admin->CountTableId('tbl_pinjam','pinjam_id',$id);
			if($count > 0)
			{
				$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
				`anggota_id`, `status`, 
				`tgl_pinjam`, `lama_pinjam`, 
				`tgl_balik`, `tgl_kembali` 
				FROM tbl_pinjam WHERE pinjam_id = '$id'")->row();
			}else{
				echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="'.base_url('transaksi').'"</script>';
			}
		}
		$this->data['sidebar'] = 'kembali';
		$this->data['title_web'] = 'Detail Pinjam Buku ';
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('pinjam/detail',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function kembalipinjam()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');		
		$id = $this->uri->segment('3');
		$count = $this->M_Admin->CountTableId('tbl_pinjam','pinjam_id',$id);
		if($count > 0)
		{
			$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, 
			`anggota_id`, `status`, 
			`tgl_pinjam`, `lama_pinjam`, 
			`tgl_balik`, `tgl_kembali` 
			FROM tbl_pinjam WHERE pinjam_id = '$id'")->row();
		}else{
			echo '<script>alert("DETAIL TIDAK DITEMUKAN");window.location="'.base_url('transaksi').'"</script>';
		}

		$this->data['title_web'] = 'Kembali Pinjam Buku ';
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('pinjam/kembali',$this->data);
		$this->load->view('footer_view',$this->data);
	}
	public function prosespinjam()
{
    $post = $this->input->post();
    $nop = strip_tags($post['nopinjam']);
    $tgl = strip_tags($post['tgl']);
    $id_anggota = strip_tags($post['anggota_id']);
    $lama = strip_tags($post['lama']);
    $tgl_kembali = date('Y-m-d', strtotime("+$lama days", strtotime($tgl)));

    $cart_raw = $this->session->userdata('cart');
    $cart = $cart_raw ? unserialize($cart_raw) : [];

    if (empty($cart)) {
        $this->session->set_flashdata('error', 'Tidak ada buku yang dipilih!');
        redirect(base_url('transaksi/pinjam'));
        return;
    }

    foreach ($cart as $item) {
        $isbn = $item['options']['isbn'];

        $buku_q = $this->db->query("
            SELECT * FROM tbl_buku 
            WHERE isbn = ? 
            AND buku_id NOT IN (
                SELECT buku_id FROM tbl_pinjam WHERE status = 'Dipinjam'
            )
            ORDER BY buku_id ASC LIMIT 1
        ", [$isbn]);

        if ($buku_q->num_rows() == 0) {
            $this->session->set_flashdata('error', 'Stok buku untuk ISBN '.$isbn.' tidak tersedia!');
            redirect(base_url('transaksi/pinjam'));
            return;
        }

        $buku = $buku_q->row();

        $data = [
            'pinjam_id' => $nop,
            'anggota_id' => $id_anggota,
            'buku_id' => $buku->buku_id,
            'tgl_pinjam' => $tgl,
            'lama_pinjam' => $lama,
            'tgl_balik' => $tgl_kembali,
            'tgl_kembali' => '',
            'status' => 'Dipinjam',
        ];
		    // CEK APAKAH ANGGOTA SUDAH PINJAM BUKU DENGAN JUDUL SAMA
			$cek_judul = $this->db->query("
			SELECT * FROM tbl_pinjam p
			JOIN tbl_buku b ON p.buku_id = b.buku_id
			WHERE p.anggota_id = ? AND b.title = ? AND p.status = 'Dipinjam'
		", [$id_anggota, $buku->title]);
	
		if ($cek_judul->num_rows() > 0) {
			$this->session->set_flashdata('error', 'Anggota sudah meminjam buku dengan judul: '.$buku->title);
			redirect(base_url('transaksi/pinjam'));
			return;
		}
	

        $this->db->insert('tbl_pinjam', $data);

        // Update jumlah stok
        $this->M_Admin->update_table('tbl_buku', 'buku_id', $buku->buku_id, [
            'jml' => $buku->jml - 1
        ]);
    }

    // Kosongkan cart setelah sukses
    $this->session->unset_userdata('cart');

    $this->session->set_flashdata('success', 'Data peminjaman berhasil disimpan!');
    redirect(base_url('transaksi'));
}

public function hapuskembali($id)
{
    $this->M_Admin->delete_table('tbl_pinjam', 'pinjam_id', $id);
    $this->db->delete('tbl_denda', ['pinjam_id' => $id]); // optional: hapus denda juga
    $this->session->set_flashdata('message', 'Data pengembalian berhasil dihapus.');
    redirect(base_url('transaksi/kembali'));
}




	public function denda()
	{
		$this->data['idbo'] = $this->session->userdata('ses_id');	
		$this->data['denda'] =  $this->db->query("SELECT * FROM tbl_biaya_denda ORDER BY id_biaya_denda DESC");

		if(!empty($this->input->get('id'))){
			$id = $this->input->get('id');
			$count = $this->M_Admin->CountTableId('tbl_biaya_denda','id_biaya_denda',$id);
			if($count > 0)
			{			
				$this->data['den'] = $this->db->query("SELECT *FROM tbl_biaya_denda WHERE id_biaya_denda='$id'")->row();
			}else{
				echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="'.base_url('transaksi/denda').'"</script>';
			}
		}

		$this->data['title_web'] = ' Denda ';
		$this->load->view('header_view',$this->data);
		$this->load->view('sidebar_view',$this->data);
		$this->load->view('denda/denda_view',$this->data);
		$this->load->view('footer_view',$this->data);
	}

	public function dendaproses()
	{
		if(!empty($this->input->post('tambah')))
		{
			$post = $this->input->post();
			
			$data = array(
				'harga_denda' => htmlentities($post['harga']),
				'stat' => 'Tidak Aktif',
				'tgl_tetap' => date('Y-m-d')
			);

			$this->db->insert('tbl_biaya_denda', $data);
			
			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah  Harga Denda  Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi/denda')); 
		}

		if(!empty($this->input->post('edit')))
		{
			$dd = $this->M_Admin->get_tableid('tbl_biaya_denda','stat','Aktif');
			foreach($dd as $isi)
			{
				$data1 = array(
					'stat'=>'Tidak Aktif',
				);
				$this->db->where('id_biaya_denda',$isi['id_biaya_denda']);
				$this->db->update('tbl_biaya_denda', $data1);
			}

			$post = $this->input->post();
			
			$data = array(
				'harga_denda' => htmlentities($post['harga']),
				'stat' => $post['status'],
				'tgl_tetap' => date('Y-m-d')
			);

			$this->db->where('id_biaya_denda',$post['edit']);
			$this->db->update('tbl_biaya_denda', $data);

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Harga Denda  Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi/denda')); 	
		}

		if(!empty($this->input->get('denda_id')))
		{
			$this->db->where('id_biaya_denda',$this->input->get('denda_id'));
			$this->db->delete('tbl_biaya_denda');

			$this->session->set_flashdata('pesan','<div id="notifikasi"><div class="alert alert-warning">
			<p> Hapus Harga Denda Sukses !</p>
			</div></div>');
			redirect(base_url('transaksi/denda')); 
		}
	}
	public function hapuspinjam($id)
	{
		if ($this->session->userdata('level') != 'Petugas') {
			redirect(base_url('404'));
		}
	
		// Ambil data peminjaman
		$pinjam = $this->M_Admin->get_tableid_edit('tbl_pinjam', 'pinjam_id', $id);
	
		if ($pinjam) {
			// Tambahkan kembali stok buku
			$this->db->query("UPDATE tbl_buku SET jml = jml + 1 WHERE buku_id = ?", [$pinjam->buku_id]);
	
			// Hapus data pinjam
			$this->M_Admin->delete_table('tbl_pinjam', 'pinjam_id', $id);
	
			// Hapus juga data denda (jika ada)
			$this->db->delete('tbl_denda', ['pinjam_id' => $id]);
	
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">Peminjaman berhasil dihapus dan stok buku dikembalikan.</div>');
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data peminjaman tidak ditemukan.</div>');
		}
	
		redirect(base_url('transaksi'));
	}
	

	public function result()
    {	
		$user = $this->M_Admin->get_tableid_edit('tbl_login','anggota_id',$this->input->post('kode_anggota'));
		error_reporting(0);
		if($user->nama != null)
		{
			echo '<table class="table table-striped">
						<tr>
							<td>Nama Anggota</td>
							<td>:</td>
							<td>'.$user->nama.'</td>
						</tr>
						<tr>
							<td>Telepon</td>
							<td>:</td>
							<td>'.$user->telepon.'</td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td>:</td>
							<td>'.$user->email.'</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td>'.$user->alamat.'</td>
						</tr>
						<tr>
							<td>Level</td>
							<td>:</td>
							<td>'.$user->level.'</td>
						</tr>
					</table>';
		}else{
			echo 'Anggota Tidak Ditemukan !';
		}
	}

	public function buku()
{
    $id = $this->input->post('kode_buku');

    // Cek apakah buku_id ini valid
    $info_buku = $this->db->get_where('tbl_buku', ['buku_id' => $id])->row();
    if (!$info_buku) {
        echo '<p style="color:red">Data buku tidak ditemukan.</p>';
        return;
    }

    // Cek apakah anggota sudah pinjam buku dengan judul yang sama
    $anggota_id = $this->session->userdata('anggota_id');
    $cek_duplikat = $this->db->query("
        SELECT * FROM tbl_pinjam p
        JOIN tbl_buku b ON p.buku_id = b.buku_id
        WHERE p.anggota_id = ? AND b.title = ? AND p.status = 'Dipinjam'
    ", [$anggota_id, $info_buku->title]);

    if ($cek_duplikat->num_rows() > 0) {
        echo '<p style="color:red">Anda sudah meminjam buku dengan judul ini!</p>';
        return;
    }

    // ... lanjutkan kode seperti biasa


    // Ambil info buku
    $row = $this->db->query("SELECT * FROM tbl_buku WHERE buku_id ='$id'");
    if ($row->num_rows() > 0) {
        $tes = $row->row();

        $item = array(
            'id'      => $id,
            'qty'     => 1,
            'name'    => $tes->title,
            'options' => array(
                'isbn' => $tes->isbn,
                'thn' => $tes->thn_buku,
                'penerbit' => $tes->penerbit,
                'stok' => 1
            )
        );

        $cart = $this->session->userdata('cart') ? @unserialize($this->session->userdata('cart')) : [];
        $exists = false;
        foreach ($cart as $c) {
            if ($c['id'] == $id) $exists = true;
        }

        if (!$exists) {
            $cart[] = $item;
            $this->session->set_userdata('cart', serialize($cart));
        }

        // Tampilkan cart
        echo '<table class="table table-bordered">';
        echo '<tr><th>No</th><th>Title</th><th>Penerbit</th><th>Tahun</th><th>Aksi</th></tr>';
        $no = 1;
        foreach ($cart as $b) {
            echo '<tr>';
            echo '<td>'.$no++.'</td>';
            echo '<td>'.$b['name'].'</td>';
            echo '<td>'.$b['options']['penerbit'].'</td>';
            echo '<td>'.$b['options']['thn'].'</td>';
            echo '<td><a href="'.base_url('transaksi/removebuku/'.$b['id']).'" class="btn btn-danger btn-xs">Hapus</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}

public function buku_list()
{
    $cart_raw = $this->session->userdata('cart');
    $cart_items = [];

    if ($cart_raw !== FALSE) {
        $unserialized = @unserialize($cart_raw);
        if (is_array($unserialized)) {
            $cart_items = array_values($unserialized);
        }
    }

    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no = 1;
        foreach($cart_items as $items): 
            $stok = isset($items['options']['stok']) ? $items['options']['stok'] : 'N/A';
            $penerbit = isset($items['options']['penerbit']) ? $items['options']['penerbit'] : '-';
            $tahun = isset($items['options']['thn']) ? $items['options']['thn'] : '-';
        ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $items['name']; ?></td>
                <td><?= $penerbit; ?></td>
                <td><?= $tahun; ?></td>
                <td><?= $stok; ?></td>
                <td>
                    <a href="javascript:void(0)" id="delete_buku<?= $no; ?>" data-id="<?= $items['id']; ?>" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            <script>
                $(document).ready(function(){
                    $("#delete_buku<?= $no; ?>").click(function () {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('transaksi/del_cart'); ?>",
                            data: { buku_id: $(this).attr("data-id") },
                            success: function(html){
                                $("#result_buku").html(html);
                            }
                        });
                    });
                });
            </script>
        <?php 
        $no++;
        endforeach; 
        ?>
        </tbody>
    </table>
    <?php
}

	public function del_cart()
    {
		error_reporting(0);
        $id = $this->input->post('buku_id');
        $index = $this->exists($id);
        $cart = array_values(unserialize($this->session->userdata('cart')));
        unset($cart[$index]);
        $this->session->set_userdata('cart', serialize($cart));
		echo '<script>$("#result_buku").load("'.base_url('transaksi/buku_list').'");</script>';
    }

    private function exists($id)
    {
        $cart = array_values(unserialize($this->session->userdata('cart')));
        for ($i = 0; $i < count($cart); $i ++) {
            if ($cart[$i]['id'] == $id) {
                return $i;
            }
        }
        return -1;
    }
}