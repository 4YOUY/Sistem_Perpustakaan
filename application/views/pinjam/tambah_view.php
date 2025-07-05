<?php if(! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $old = $this->session->flashdata('old_input'); ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-plus" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-plus"></i>&nbsp;  <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <div class="box-body">
				<?php if($this->session->flashdata('error')): ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
					<?= $this->session->flashdata('error'); ?>
				</div>
				<?php endif; ?>
                <form action="<?php echo base_url('transaksi/prosespinjam');?>" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-5">
							<table class="table table-striped">
								<tr style="background:yellowgreen">
									<td colspan="3">Data Transaksi</td>
								</tr>
								<tr>
									<td>No Peminjaman</td>
									<td>:</td>
									<td>
										<input type="text" name="nopinjam" value="<?= $nop;?>" readonly class="form-control">
									</td>
								</tr>
								<tr>
									<td>Tgl Peminjaman</td>
									<td>:</td>
									<td>
										<input type="date" value="<?= isset($old['tgl']) ? $old['tgl'] : date('Y-m-d'); ?>" name="tgl" class="form-control">
									</td>
								</tr>
								<tr>
									<td>ID Anggota</td>
									<td>:</td>
									<td>
										<div class="input-group">
											<input type="text" class="form-control" required autocomplete="off" name="anggota_id" id="search-box"
												placeholder="Contoh ID Anggota : AG001"
												value="<?= isset($old['anggota_id']) ? $old['anggota_id'] : '' ?>">
											<span class="input-group-btn">
												<a data-toggle="modal" data-target="#TableAnggota" class="btn btn-primary"><i class="fa fa-search"></i></a>
											</span>
										</div>
									</td>
								</tr>
								<tr>
									<td>Biodata</td>
									<td>:</td>
									<td>
										<div id="result_tunggu"> <p style="color:red">* Belum Ada Hasil</p></div>
										<div id="result"></div>
									</td>
								</tr>
								<tr>
									<td>Lama Peminjaman</td>
									<td>:</td>
									<td>
										<input type="number" required placeholder="Lama Pinjam Contoh : 2 Hari (2)" name="lama" class="form-control"
											value="<?= isset($old['lama']) ? $old['lama'] : '' ?>">
									</td>
								</tr>
							</table>
						</div>
						<div class="col-sm-7">
							<table class="table table-striped">
								<tr style="background:yellowgreen">
									<td colspan="3">Pinjam Buku</td>
								</tr>
								<tr>
									<td>Kode Buku</td>
									<td>:</td>
									<td>
										<div class="input-group">
										<input type="text" class="form-control" autocomplete="off" id="buku-search"
											placeholder="Cari Judul atau ISBN">
										<input type="hidden" name="isbn" id="isbn-hidden" value="">
											<span class="input-group-btn">
												<a data-toggle="modal" data-target="#TableBuku" class="btn btn-primary"><i class="fa fa-search"></i></a>
											</span>
										</div>
									</td>
								</tr>
								<tr>
	<td>Data Buku</td>
	<td>:</td>
	<td>
	<div id="result_buku">
  <p style="color:red">* Belum Ada Hasil</p>
</div>

	</td>
</tr>

							</table>
						</div>
					</div>
                    <div class="pull-right">
						<input type="hidden" name="tambah" value="tambah">
                        <button type="submit" class="btn btn-primary btn-md">Submit</button> 
                </form>
						<a href="<?= base_url('transaksi');?>" class="btn btn-danger btn-md">Kembali</a>
					</div>
		    </div>
	    </div>
	</div>
</section>
</div>

<!-- Modal Buku -->
<div class="modal fade" id="TableBuku">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Buku</h4>
			</div>
			<div class="modal-body fileSelection1">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th><th>ISBN</th><th>Title</th><th>Penerbit</th><th>Tahun Buku</th><th>Stok Buku</th><th>Tanggal Masuk</th><th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1;foreach($buku->result_array() as $isi){?>
							<tr>
								<td><?= $no++;?></td>
								<td><?= $isi['isbn'];?></td>
								<td><?= $isi['title'];?></td>
								<td><?= $isi['penerbit'];?></td>
								<td><?= $isi['thn_buku'];?></td>
								<td><?= $isi['jml'];?></td>
								<td><?= $isi['tgl_masuk'];?></td>
								<td style="width:17%">
								<button class="btn btn-primary" id="Select_File2"
								data_id="<?= $isi['buku_id'];?>"
								data_id_buku="<?= $isi['id_buku'];?>"
								data_isbn="<?= $isi['isbn'];?>">
								<i class="fa fa-check"> </i> Pilih
							</button>

									<a href="<?= base_url('data/bukudetail/'.$isi['id_buku']);?>" target="_blank">
										<button class="btn btn-success"><i class="fa fa-sign-in"></i> Detail</button>
									</a>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer"><button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button></div>
		</div>
	</div>
</div>

<!-- Modal Anggota -->
<div class="modal fade" id="TableAnggota">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Anggota</h4>
			</div>
			<div class="modal-body fileSelection1">
				<table id="example3" class="table table-bordered table-striped">
					<thead>
						<tr><th>No</th><th>ID</th><th>Nama</th><th>Jenkel</th><th>Telepon</th><th>Level</th><th>Aksi</th></tr>
					</thead>
					<tbody>
						<?php $no=1;foreach($user as $isi){ if($isi['level'] == 'Anggota'){ ?>
							<tr>
								<td><?= $no++;?></td>
								<td><?= $isi['anggota_id'];?></td>
								<td><?= $isi['nama'];?></td>
								<td><?= $isi['jenkel'];?></td>
								<td><?= $isi['telepon'];?></td>
								<td><?= $isi['level'];?></td>
								<td style="width:20%;">
									<button class="btn btn-primary" id="Select_File1" data_id="<?= $isi['anggota_id'];?>"><i class="fa fa-check"> </i> Pilih</button>
								</td>
							</tr>
						<?php }}?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer"><button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button></div>
		</div>
	</div>
</div>

<script>
$(".fileSelection1 #Select_File1").click(function () {
	document.getElementsByName('anggota_id')[0].value = $(this).attr("data_id");
	$('#TableAnggota').modal('hide');
	$.post("<?= base_url('transaksi/result');?>", {kode_anggota: $(this).attr("data_id")}, function(html){
		$("#result").html(html);
		$("#result_tunggu").html('');
	});
});
// Gunakan event delegation supaya tombol yang muncul setelah modal tampil tetap bisa diklik
$(document).on('click', '#Select_File2', function () {
	const buku_id = $(this).attr("data_id");

	$.post("<?= base_url('transaksi/buku'); ?>", 
		{ kode_buku: buku_id }, 
		function (res) {
			// Masukkan langsung hasil response ke div hasil buku
			$("#result_buku").html(res);
			$("#result_tunggu_buku").html('');
	});

	$('#TableBuku').modal('hide'); // Tutup modal setelah pilih buku
});

</script>
