<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php if($this->session->userdata('level') == 'Anggota'){ redirect(base_url('transaksi'));}?>
    <div class="content-wrapper">
        <section class="content-header">
        <h1>
        Dashboard
        </h1>
    </section>
    <!-- Main content -->
        <section class="content">
			<div class="container">
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Anggota Perpustakaan</h6>
                    <h2 class="text-right"><i class="fa fa-user f-left"></i><span><?= $count_pengguna;?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Jenis Buku</h6>
                    <h2 class="text-right"><i class="fa fa-book f-left"></i><span><?= $count_buku;?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Peminjam</h6>
                    <h2 class="text-right"><i class="fa fa-shopping-cart f-left"></i><span><?= $count_pinjam;?></span></h2>
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Pengembalian</h6>
                    <h2 class="text-right"><i class="fa fa-refresh f-left"></i><span><?= $count_kembali;?></span></h2>
                    
                </div>
            </div>
        </div>
	</div>
</div>
        </section>
    </div>
    <!-- /.content -->
