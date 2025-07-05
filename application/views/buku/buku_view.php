<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  <?= $title_web;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web;?></li>
    </ol>
  </section>
  <section class="content">
	<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
					<?php if($this->session->userdata('level') == 'Petugas'){?>
                    <a href="data/bukutambah"><button class="btn btn-primary">
						<i class="fa fa-plus"> </i> Tambah Buku</button></a>
					<?php }?>
                </div>
				<div class="box-body">
                    <br/>
					<div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sampul</th>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Penerbit</th>
                                <th>Tahun Buku</th>
                                <th>Total Buku</th>
                                <th>Dipinjam</th>
                                <th>Stok Tersedia</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1;foreach($buku->result_array() as $isi){?>
                            <tr>
                                <td><?= $no;?></td>
                                <td>
                                    <center>
                                        <?php if(!empty($isi['sampul'] !== "0") && !empty($isi['sampul'])){?>
                                        <img src="<?php echo base_url();?>assets_style/image/buku/<?php echo $isi['sampul'];?>" alt="#" 
                                        class="img-responsive" style="height:auto;width:100px;"/>
                                        <?php }else{?>
											<i class="fa fa-book fa-3x" style="color:#333;"></i> <br/><br/>
											Tidak Ada Sampul
                                        <?php }?>
                                    </center>
                                </td>
                                <td><?= $isi['isbn'];?></td>
                                <td><?= $isi['title'];?></td>
                                <td><?= $isi['penerbit'];?></td>
                                <td><?= $isi['thn_buku'];?></td>
                                <td>
                                    <!-- Total Stok -->
                                    <?= $isi['jml']; ?>
                                </td>
                                <td>
                                    <!-- Jumlah Dipinjam -->
                                    <?= $isi['dipinjam']; ?>
                                </td>
                                <td>
                                    <!-- Stok Tersedia -->
                                    <?= $isi['stok_tersedia']; ?>
                                </td>
                                <td><?= date('d-m-Y H:i', strtotime($isi['tgl_masuk']));?></td>

								<!-- AKSI -->
								<td <?php if($this->session->userdata('level') == 'Petugas'){?>style="width:17%;"<?php }?>>
									<?php
										// Ambil satu id_buku dari ISBN untuk aksi
										$id_buku_sample = $this->db->query("SELECT id_buku FROM tbl_buku WHERE isbn = '{$isi['isbn']}' LIMIT 1")->row()->id_buku;
									?>
									
									<!-- Detail Button - Selalu tampil -->
									<a href="<?= base_url('data/bukudetail/'.$id_buku_sample);?>" title="Detail Buku">
										<button class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
									</a>
									
									<?php if($this->session->userdata('level') == 'Petugas'){?>
										<!-- Edit Button -->
										<a href="<?= base_url('data/bukuedit/'.$id_buku_sample);?>" title="Edit Buku">
											<button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
										</a>
										
										<!-- Delete Button -->
										<a href="<?= base_url('data/hapusbuku/'.$id_buku_sample);?>" 
										   onclick="return confirm('Yakin ingin menghapus semua eksemplar buku ini? Jumlah: <?= $isi['jml']; ?> eksemplar')" 
										   title="Hapus Semua Eksemplar">
											<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
										</a>
									<?php } ?>
								</td>
                            </tr>
                        <?php $no++;}?>
                        </tbody>
                    </table>
					</div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<style>
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
    
    .btn-sm {
        padding: 2px 6px;
        font-size: 10px;
    }
}