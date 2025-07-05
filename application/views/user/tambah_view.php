<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <i class="fa fa-plus" style="color:green"> </i>  Tambah User
    </h1>
    <ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
			<li class="active"><i class="fa fa-plus"></i>&nbsp; Tambah User</li>
    </ol>
  </section>
  <section class="content">
	<div class="row">
	    <div class="col-md-12">
	        <div class="box box-primary">
                <div class="box-header with-border">
                </div>
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form id="userForm" action="<?php echo base_url('user/add');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Pengguna</label>
                                    <input type="text" class="form-control" name="nama" id="nama" required="required" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="lahir" id="lahir" required="required" placeholder="Contoh : Bekasi">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required="required" placeholder="Contoh : 1999-05-18" max="2025-12-31">
                                    <div id="tgl_lahir_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
                                        <i class="fa fa-exclamation-circle"></i> Tahun lahir tidak boleh lebih dari tahun 2025
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="user" id="username" required="required" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="pass" id="password" required="required" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" required="required">
                                    <option>Petugas</option>
                                    <option>Anggota</option>
                                    <option>Pimpinan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <br/>
                                    <input type="radio" name="jenkel" value="Laki-Laki" required="required"> Laki-Laki
                                    <br/>
                                    <input type="radio" name="jenkel" value="Perempuan" required="required"> Perempuan
                                </div>
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input id="uintTextBox" class="form-control" name="telepon" required="required" placeholder="Contoh : 089618173609">
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email" required="required" placeholder="Contoh : fauzan1892@codekop.com">
                                </div>
                                <div class="form-group">
                                    <label>Pas Foto</label>
                                    <input type="file" accept="image/*" name="gambar" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-md" id="submitBtn">Submit</button> 
                            <a href="<?= base_url('user');?>" class="btn btn-danger btn-md">Kembali</a>
                        </div>
                    </form>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>

<script>

    // Validasi tanggal lahir
    $('#tgl_lahir').on('change', function() {
        var selectedDate = new Date($(this).val());
        var currentYear = new Date().getFullYear();
        var selectedYear = selectedDate.getFullYear();
        
        if (selectedYear > 2025) {
            $('#tgl_lahir_error').show();
            $(this).addClass('is-invalid');
        } else {
            $('#tgl_lahir_error').hide();
            $(this).removeClass('is-invalid');
        }
    });
    function togglePassword() {
    var passwordField = document.getElementById('pass');
    var toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.className = 'fa fa-eye-slash';
    } else {
        passwordField.type = 'password';
        toggleIcon.className = 'fa fa-eye';
    }
}
</script>