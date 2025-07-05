<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<?php
	$idkat = $buku->id_kategori;
	$idrak = $buku->id_rak;

	$kat = $this->M_Admin->get_tableid_edit('tbl_kategori','id_kategori',$idkat);
	$rak = $this->M_Admin->get_tableid_edit('tbl_rak','id_rak',$idrak);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-book" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-book"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border text-center">
					<h3><b><?= $buku->title;?></b></h3>
                </div>
			    <div class="box-body">
					<div style="display: flex; justify-content: center;">
						<div style="width: 300px; margin-bottom: 20px;">
						<?php if(!empty($buku->sampul) && $buku->sampul !== "0" && $buku->sampul !== ""){?>
							<img src="<?= base_url('assets_style/image/buku/'.$buku->sampul);?>" style="width:100%; height:auto; border:1px solid #ccc;">
						<?php } else { ?>
							<div style="width:100%; height:400px; border:2px dashed #ddd; display:flex; flex-direction:column; align-items:center; justify-content:center; background-color:#f9f9f9; border-radius:8px;">
								<i class="fa fa-book" style="font-size:80px; color:#bbb; margin-bottom:15px;"></i>
								<p style="color:#888; text-align:center; margin:0; font-size:16px; font-weight:500;">Sampul Tidak Tersedia</p>
								<p style="color:#bbb; text-align:center; margin:5px 0 0 0; font-size:12px;">No Cover Available</p>
							</div>
						<?php } ?>
						</div>
					</div>
					<table class="table table-bordered">
						<tbody>
						<tr><th style="width:25%">ISBN</th><td><?= $buku->isbn;?></td></tr>
						<tr><th>Judul Buku</th><td><?= $buku->title;?></td></tr>
						<tr><th>Kategori</th><td><?= $kat->nama_kategori;?></td></tr>
						<tr><th>Penerbit</th><td><?= $buku->penerbit;?></td></tr>
						<tr><th>Pengarang</th><td><?= $buku->pengarang;?></td></tr>
						<tr><th>Tahun Terbit</th><td><?= $buku->thn_buku;?></td></tr>
						<?php if ($this->session->userdata('level') == 'Petugas') : ?>
						<tr><th>Total Stok</th><td><?= $jumlah_buku;?></td></tr>
						<tr><th>Sedang Dipinjam</th><td><?= $jumlah_pinjam;?></td></tr>
						<?php endif; ?>
						<tr><th>Stok Tersedia</th><td><?= $stok_tersedia;?></td></tr>
						<?php if ($this->session->userdata('level') == 'Petugas') : ?>
						<tr>
							<th>Detail Peminjam</th>
							<td>
								<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary btn-xs">
									<i class="fa fa-sign-in"></i> Lihat Peminjam (<?= $jumlah_pinjam;?>)
								</a>
							</td>
						</tr>
						<?php endif; ?>
						<tr><th>Keterangan Lainnya</th><td><?= $buku->isi;?></td></tr>
						<tr><th>Rak / Lokasi</th><td><?= $rak->nama_rak;?></td></tr>
						<tr>
							<th>Lampiran</th>
							<td>
							<?php if(!empty($buku->lampiran) && $buku->lampiran !== "0"){ ?>
							<a href="<?= base_url('assets_style/image/buku/'.$buku->lampiran);?>" class="btn btn-info btn-sm" target="_blank">
								<i class="fa fa-download"></i> Sample Buku
							</a>
							<?php } else { ?>
							<button onclick="noLampiran()" class="btn btn-info btn-sm">
								<i class="fa fa-download"></i> Sample Buku
							</button>
							<?php } ?>
							</td>
						</tr>
						</tbody>
					</table>
					<div class="text-right">
					<div class="text-right">
    <?php 
    $user_level = $this->session->userdata('level');
    
    switch($user_level) {
        case 'Anggota':
            $back_link = base_url('dashboard/anggota');
            break;
        case 'Petugas':
            $back_link = base_url('data');
    }
    ?>
    <a href="<?= $back_link; ?>" class="btn" style="background-color:red; color:white;">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
</div>
	        </div>
	        </div>
	    </div>
    </div>
</section>
</div>
<!-- modal -->
<div class="modal fade" id="TableAnggota">
<div class="modal-dialog" style="width:70%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"> Anggota Yang Sedang Pinjam</h4>
</div>
<div id="modal_body" class="modal-body fileSelection1">
<table id="example1" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>ID</th>
			<th>Nama</th>
			<th>Jenkel</th>
			<th>Telepon</th>
			<th>Tgl Pinjam</th>
			<th>Lama Pinjam</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$no = 1;
	$bukuid = $buku->buku_id;
	$isbn = $buku->isbn;
	// Ambil semua peminjam berdasarkan ISBN, bukan hanya satu buku_id
	$pin = $this->db->query("SELECT tp.*, tb.buku_id FROM tbl_pinjam tp 
							JOIN tbl_buku tb ON tb.buku_id = tp.buku_id 
							WHERE tb.isbn = '$isbn' AND tp.status = 'Dipinjam'")->result_array();
	foreach($pin as $si)
	{
		$isi = $this->M_Admin->get_tableid_edit('tbl_login','anggota_id',$si['anggota_id']);
		if($isi->level == 'Anggota'){
	?>
	<tr>
		<td><?= $no;?></td>
		<td><?= $isi->anggota_id;?></td>
		<td><?= $isi->nama;?></td>
		<td><?= $isi->jenkel;?></td>
		<td><?= $isi->telepon;?></td>
		<td><?= $si['tgl_pinjam'];?></td>
		<td><?= $si['lama_pinjam'];?> Hari</td>
	</tr>
	<?php $no++;}}?>	
	</tbody>
</table>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function noLampiran() {
	Swal.fire({
	icon: 'warning',
	title: 'Lampiran tidak tersedia!',
	text: 'Buku ini tidak memiliki file sample.',
	toast: true,
	timer: 3000,
	showConfirmButton: false,
	position: 'top-end'
	});
}
</script>