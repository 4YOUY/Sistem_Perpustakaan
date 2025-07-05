<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <?php if($this->session->userdata('level') == 'Petugas'){?>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <li class="header">Menu</li>
            <li class="<?php if($this->uri->uri_string() == 'dashboard'){ echo 'active';}?>">
                <a href="<?php echo base_url('dashboard');?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php if($this->uri->uri_string() == 'user'){ echo 'active';}?>
                <?php if($this->uri->uri_string() == 'user/tambah'){ echo 'active';}?>
                <?php if($this->uri->uri_string() == 'user/edit/'.$this->uri->segment('3')){ echo 'active';}?>">
                <a href="<?php echo base_url('user');?>" class="cursor">
                    <i class="fa fa-user"></i> <span>Pengguna</span>
                </a>
            </li>
            <li class="treeview <?php 
                if($this->uri->uri_string() == 'data/kategori' || 
                   $this->uri->uri_string() == 'data/rak' || 
                   $this->uri->uri_string() == 'data' || 
                   $this->uri->uri_string() == 'data/bukutambah' || 
                   strpos($this->uri->uri_string(), 'data/bukudetail/') !== false || 
                   strpos($this->uri->uri_string(), 'data/bukuedit/') !== false) { 
                    echo 'active menu-open'; 
                }?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-pencil-square"></i>
                    <span>Bibliografi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if($this->uri->uri_string() == 'data'){ echo 'active';}?>
                        <?php if($this->uri->uri_string() == 'data/bukutambah'){ echo 'active';}?>
                        <?php if($this->uri->uri_string() == 'data/bukudetail/'.$this->uri->segment('3')){ echo 'active';}?>
                        <?php if($this->uri->uri_string() == 'data/bukuedit/'.$this->uri->segment('3')){ echo 'active';}?>">
                        <a href="<?php echo base_url("data");?>" class="cursor">
                            <span class="fa fa-book"></span> Data Buku
                        </a>
                    </li>
                    <li class="<?php if($this->uri->uri_string() == 'data/kategori'){ echo 'active';}?>">
                        <a href="<?php echo base_url("data/kategori");?>" class="cursor">
                            <span class="fa fa-tags"></span> Kategori
                        </a>
                    </li>
                    <li class="<?php if($this->uri->uri_string() == 'data/rak'){ echo 'active';}?>">
                        <a href="<?php echo base_url("data/rak");?>" class="cursor">
                            <span class="fa fa-list"></span> Rak
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php 
                if($this->uri->uri_string() == 'transaksi' || 
                   $this->uri->uri_string() == 'transaksi/kembali' || 
                   $this->uri->uri_string() == 'transaksi/pinjam' || 
                   strpos($this->uri->uri_string(), 'transaksi/detailpinjam/') !== false || 
                   strpos($this->uri->uri_string(), 'transaksi/kembalipinjam/') !== false) { 
                    echo 'active menu-open'; 
                }?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-exchange"></i>
                    <span>Transaksi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if($this->uri->uri_string() == 'transaksi'){ echo 'active';}?>
                        <?php if($this->uri->uri_string() == 'transaksi/pinjam'){ echo 'active';}?>
                        <?php if($this->uri->uri_string() == 'transaksi/kembalipinjam/'.$this->uri->segment('3')){ echo 'active';}?>">
                        <a href="<?php echo base_url("transaksi");?>" class="cursor">
                            <span class="fa fa-upload"></span> Peminjaman
                        </a>
                    </li>
                    <li class="<?php if($this->uri->uri_string() == 'transaksi/kembali'){ echo 'active';}?>">
                        <a href="<?php echo base_url("transaksi/kembali");?>" class="cursor">
                            <span class="fa fa-download"></span> Pengembalian
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php if($this->uri->uri_string() == 'transaksi/denda'){ echo 'active';}?>">
                <a href="<?php echo base_url("transaksi/denda");?>" class="cursor">
                    <i class="fa fa-money"></i> <span>Denda</span>
                </a>
            </li>
            
            <?php }?>
            <?php if($this->session->userdata('level') == 'Anggota'){?>
            <li class="<?php if($this->uri->uri_string() == 'dashboard/anggota'){ echo 'active';}?>">
                <a href="<?php echo base_url("dashboard/anggota");?>" class="cursor">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php if($this->uri->uri_string() == 'transaksi'){ echo 'active';}?>">
                <a href="<?php echo base_url("transaksi");?>" class="cursor">
                    <i class="fa fa-upload"></i> <span>Peminjaman </span>
                </a>
            </li>
            <li class="<?php if($this->uri->uri_string() == 'transaksi/kembali'){ echo 'active';}?>">
                <a href="<?php echo base_url("transaksi/kembali");?>" class="cursor">
                    <i class="fa fa-download"></i> <span>Histori Pengembalian</span>
                </a>
            </li>
            <?php }?>
        </ul>
        <div class="clearfix"></div>
        <br/>
        <br/>
    </section>
</aside>