<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
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
			    <!-- /.box-header -->
			    <div class="box-body">
                    <form id="formTambahBuku" action="<?php echo base_url('data/prosesbuku');?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
								<div class="form-group">
									<label>Kategori </label>
									<select class="form-control select2" name="kategori" id="kategori">
										<option disabled selected value=""> -- Pilih Kategori -- </option>
										<?php foreach($kats as $isi){?>
											<option value="<?= $isi['id_kategori'];?>"><?= $isi['nama_kategori'];?></option>
										<?php }?>
									</select>
									<div id="kategori_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
										<i class="fa fa-exclamation-circle"></i> Kategori harus dipilih
									</div>
								</div>
                                <div class="form-group">
                                    <label>Rak / Lokasi </label>
                                    <select name="rak" id="rak" class="form-control select2">
										<option disabled selected value=""> -- Pilih Rak / Lokasi -- </option>
										<?php foreach($rakbuku as $isi){?>
											<option value="<?= $isi['id_rak'];?>"><?= $isi['nama_rak'];?></option>
										<?php }?>
                                    </select>
									<div id="rak_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
										<i class="fa fa-exclamation-circle"></i> Rak / Lokasi harus dipilih
									</div>
                                </div>
                                <div class="form-group">
                                    <label>ISBN </label>
                                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Contoh ISBN : 978-602-8123-35-8">
									<div id="isbn_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
										<i class="fa fa-exclamation-circle"></i> ISBN harus diisi
									</div>
                                </div>
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Contoh : Cara Cepat Belajar Pemrograman Web">
									<div id="title_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
										<i class="fa fa-exclamation-circle"></i> Judul buku harus diisi
									</div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Pengarang </label>
                                    <input type="text" class="form-control" name="pengarang" id="pengarang" placeholder="Nama Pengarang">
									<div id="pengarang_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
										<i class="fa fa-exclamation-circle"></i> Nama pengarang harus diisi
									</div>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Penerbit </label>
                                    <input type="text" class="form-control" name="penerbit" id="penerbit" placeholder="Nama Penerbit">
									<div id="penerbit_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
										<i class="fa fa-exclamation-circle"></i> Penerbit harus diisi
									</div> -->
                                </div>
                                <div class="form-group">
                                    <label>Tahun Buku </label>
                                    <input type="number" class="form-control" name="thn" id="thn" placeholder="Tahun Buku : 2019">
                                    <div id="thn_buku_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
                                        <i class="fa fa-exclamation-circle"></i> <span id="thn_error_message">Tahun buku harus diisi</span>
                                    </div>
                                </div>
                            </div>
                                            <div class="col-sm-6">
    <!-- Kode Buku Awal -->
                            <div class="form-group">
                                <label for="kode_buku_awal">Kode Eksemplar <small>(misal: MJ-0001)</small></label>
                                <input type="text" class="form-control" name="kode_buku_awal" id="kode_buku_awal" placeholder="Contoh: MJ-0001">
                                <div id="kode_buku_awal_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
                                    <i class="fa fa-exclamation-circle"></i> Kode buku awal harus diisi
                                </div>
                            </div>

    <!-- Jumlah Buku -->
    <div class="form-group">
        <label>Jumlah Buku </label>
        <input type="number" class="form-control" name="jml" id="jml" placeholder="Jumlah buku : 12">
        <div id="jml_error" class="text-danger" style="font-size: 12px; margin-top: 5px; display: none;">
            <i class="fa fa-exclamation-circle"></i> Jumlah buku harus diisi
        </div>
    </div>

    <!-- Sampul -->
    <div class="form-group">
        <label>Sampul <small style="color:green">(gambar) * opsional</small></label>
        <input type="file" accept="image/*" name="gambar">
    </div>

    <!-- Lampiran -->
    <div class="form-group">
        <label>Lampiran Buku <small style="color:green">(pdf) * opsional</small></label>
        <input type="file" name="lampiran">
    </div>

    <!-- Keterangan -->
    <div class="form-group">
        <label>Keterangan Lainnya <small style="color:green">* opsional</small></label>
        <textarea class="form-control" name="ket" id="summernotehal" style="height:120px"></textarea>
    </div>
</div>

                            </div>
                        </div>
                        <div class="pull-right">
							<input type="hidden" name="tambah" value="tambah">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-md">Submit</button> 
                    </form>
                            <a href="<?= base_url('data');?>" class="btn btn-danger btn-md">Kembali</a>
                        </div>
		        </div>
	        </div>
	    </div>
    </div>
</section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formTambahBuku');
    const submitBtn = document.getElementById('submitBtn');
    
    // Fungsi untuk menampilkan error
    function showError(fieldId, show = true) {
        const errorDiv = document.getElementById(fieldId + '_error');
        if (errorDiv) {
            errorDiv.style.display = show ? 'block' : 'none';
        }
    }
    
    // Fungsi untuk validasi field kosong
    function validateRequired(fieldId) {
        const field = document.getElementById(fieldId);
        const value = field.value.trim();
        
        if (value === '' || value === null) {
            showError(fieldId, true);
            return false;
        } else {
            showError(fieldId, false);
            return true;
        }
    }
    
    // Fungsi untuk validasi tahun
    function validateYear() {
        const thnField = document.getElementById('thn');
        const value = parseInt(thnField.value);
        const errorMessage = document.getElementById('thn_error_message');
        
        if (!thnField.value.trim()) {
            errorMessage.textContent = 'Tahun buku harus diisi';
            showError('thn_buku', true);
            return false;
        } else if (value > 2025) {
            errorMessage.textContent = 'Tahun buku tidak boleh lebih dari tahun 2025';
            showError('thn_buku', true);
            return false;
        } else {
            showError('thn_buku', false);
            return true;
        }
    }
    
    // Validasi real-time untuk setiap field
    const requiredFields = ['kategori', 'rak', 'isbn', 'title', 'pengarang', 'penerbit', 'jml', 'kode_buku_awal'];
    
    requiredFields.forEach(function(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', function() {
                validateRequired(fieldId);
            });
            
            field.addEventListener('input', function() {
                if (field.value.trim() !== '') {
                    showError(fieldId, false);
                }
            });
            
            // Untuk select2, tambahkan event change
            if (field.classList.contains('select2')) {
                field.addEventListener('change', function() {
                    validateRequired(fieldId);
                });
            }
        }
    });
    
    // Validasi khusus untuk tahun
    const thnField = document.getElementById('thn');
    if (thnField) {
        thnField.addEventListener('blur', validateYear);
        thnField.addEventListener('input', function() {
            if (thnField.value.trim() !== '') {
                validateYear();
            }
        });
    }
    
    // Validasi saat form disubmit
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validasi semua field required
        requiredFields.forEach(function(fieldId) {
            if (!validateRequired(fieldId)) {
                isValid = false;
            }
        });
        
        // Validasi tahun
        if (!validateYear()) {
            isValid = false;
        }
        
        // Jika ada error, prevent submit dan scroll ke error pertama
        if (!isValid) {
            e.preventDefault();
            
            // Scroll ke error pertama yang terlihat
            const firstError = document.querySelector('[id$="_error"][style*="block"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            // Tampilkan alert
            alert('Mohon lengkapi semua field yang wajib diisi!');
        }
    });
    
    // Fungsi untuk reset semua error saat form direset
    form.addEventListener('reset', function() {
        const errorDivs = document.querySelectorAll('[id$="_error"]');
        errorDivs.forEach(function(errorDiv) {
            errorDiv.style.display = 'none';
        });
    });
});
</script>

<style>


/* Style untuk error message */
.text-danger {
    font-size: 12px !important;
}

/* Animasi untuk error message */
[id$="_error"] {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Style untuk field yang error */
.form-control.error {
    border-color: #d73925;
    box-shadow: 0 0 0 0.2rem rgba(215, 57, 37, 0.25);
}

/* Hover effect untuk submit button */
#submitBtn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
}
</style>