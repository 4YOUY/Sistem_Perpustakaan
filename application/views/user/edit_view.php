<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-edit" style="color:green"> </i>  Update User - <?= $user->nama;?>
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-edit"></i>&nbsp; Update User - <?= $user->nama;?></li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">	
			<?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>

	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form id="userEditForm" action="<?php echo base_url('user/upd');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Pengguna</label>
                                    <input type="text" class="form-control" value="<?= $user->nama;?>" name="nama" required="required" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="lahir" value="<?= $user->tempat_lahir;?>" required="required" placeholder="Contoh : Bekasi">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir_edit" value="<?= $user->tgl_lahir;?>" required="required" placeholder="Contoh : 1999-05-18" max="2025-12-31">
                                    <div id="tgl_lahir_error_edit" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
                                        <i class="fa fa-exclamation-circle"></i> Tahun lahir tidak boleh lebih dari tahun 2025
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" readonly value="<?= $user->user;?>"  name="user" required="required" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password (opsional)</label>
                                    <input type="password" class="form-control" name="pass" placeholder="Isi Password Jika di Perlukan Ganti">
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" required="required">
									<?php if($this->session->userdata('level') == 'Petugas'){?>
										<option <?php if($user->level == 'Petugas'){ echo 'selected';}?>>Petugas</option>
										<option <?php if($user->level == 'Anggota'){ echo 'selected';}?>>Anggota</option>
                                        <option <?php if($user->level == 'Pimpinan'){ echo 'selected';}?>>Pimpinan</option>
									<?php }elseif($this->session->userdata('level') == 'Anggota'){?>
                                        <option <?php if($user->level == 'Anggota'){ echo 'selected';}?>>Anggota</option>
                                    <?php }elseif($this->session->userdata('level') == 'Pimpinan'){?>
									<?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <br/>
                                    <input type="radio" name="jenkel" <?php if($user->jenkel == 'Laki-Laki'){ echo 'checked';}?> value="Laki-Laki" required="required"> Laki-Laki
                                    <br/>
                                    <input type="radio" name="jenkel" <?php if($user->jenkel == 'Perempuan'){ echo 'checked';}?> value="Perempuan" required="required"> Perempuan
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input id="uintTextBox" class="form-control" value="<?= $user->telepon;?>" name="telepon" required="required" placeholder="Contoh : 089618173609">
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email"  value="<?= $user->email;?>" readonly class="form-control" name="email" required="required" placeholder="Contoh : fauzan1892@codekop.com">
                                </div>
                                <div class="form-group">
                                    <label>Pas Foto</label>
                                    <input type="file" accept="image/*" name="gambar">
                                    
                                    <br/>
                                    <img src="<?= base_url('assets_style/image/'.$user->foto);?>" class="img-responsive" alt="#">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat"  required="required"><?= $user->alamat;?></textarea>
                                    <input type="hidden" class="form-control" value="<?= $user->id_login;?>" name="id_login">
                                    <input type="hidden" class="form-control" value="<?= $user->foto;?>" name="foto">
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-md" id="submitEditBtn">Edit Data</button> 
						</form>
						<?php if($this->session->userdata('level') == 'Petugas'){?>
							<a href="<?= base_url('user');?>" class="btn btn-danger btn-md">Kembali</a>
						<?php }elseif($this->session->userdata('level') == 'Anggota'){?>
							<a href="<?= base_url('dashboard');?>" class="btn btn-danger btn-md">Kembali</a>
						<?php }?>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>

<script>
    // Validasi tanggal lahir untuk halaman edit
    $('#tgl_lahir_edit').on('change', function() {
        var selectedDate = new Date($(this).val());
        var currentYear = new Date().getFullYear();
        var selectedYear = selectedDate.getFullYear();
        
        if (selectedYear > 2025) {
            $('#tgl_lahir_error_edit').show();
            $(this).addClass('is-invalid');
            $('#submitEditBtn').prop('disabled', true);
        } else {
            $('#tgl_lahir_error_edit').hide();
            $(this).removeClass('is-invalid');
            $('#submitEditBtn').prop('disabled', false);
        }
    });

    // Validasi saat halaman dimuat untuk data yang sudah ada
    $(document).ready(function() {
        var currentDate = $('#tgl_lahir_edit').val();
        if (currentDate) {
            var selectedDate = new Date(currentDate);
            var selectedYear = selectedDate.getFullYear();
            
            if (selectedYear > 2025) {
                $('#tgl_lahir_error_edit').show();
                $('#tgl_lahir_edit').addClass('is-invalid');
                $('#submitEditBtn').prop('disabled', true);
            }
        }
    });

    // Prevent form submission jika validasi gagal
    $('#userEditForm').on('submit', function(e) {
        var selectedDate = new Date($('#tgl_lahir_edit').val());
        var selectedYear = selectedDate.getFullYear();
        
        if (selectedYear > 2025) {
            e.preventDefault();
            $('#tgl_lahir_error_edit').show();
            $('#tgl_lahir_edit').addClass('is-invalid');
            alert('Tahun lahir tidak boleh lebih dari tahun 2025!');
            return false;
        }
    });
</script>