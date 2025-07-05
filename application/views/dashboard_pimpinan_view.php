<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- Content Wrapper Full Screen -->
<div class="content-wrapper" style="margin-left: 0; background-color: #ecf0f1;">
    <!-- Content Header -->
    <section class="content-header" style="padding: 15px;">
        <h1>
            Report Library LP3I
            <small>Laporan Perpustakaan Pimpinan</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content" style="padding: 15px;">
        <div class="container-fluid">
            
            <!-- Filter Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan</h3>
                        </div>
                        <div class="box-body">
                            <form method="post" action="<?= base_url('dashboard/pimpinan'); ?>" id="filterForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jenis Laporan</label>
                                            <select class="form-control" name="jenis_laporan" id="jenisLaporan">
                                                <option value="harian" <?= (isset($jenis_laporan) && $jenis_laporan == 'harian') ? 'selected' : ''; ?>>Harian</option>
                                                <option value="mingguan" <?= (isset($jenis_laporan) && $jenis_laporan == 'mingguan') ? 'selected' : ''; ?>>Mingguan</option>
                                                <option value="bulanan" <?= (isset($jenis_laporan) && $jenis_laporan == 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="tanggalSection">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal" value="<?= isset($tanggal) ? $tanggal : date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="bulanSection" style="display:none;">
                                        <div class="form-group">
                                            <label>Bulan</label>
                                            <input type="month" class="form-control" name="bulan" value="<?= isset($bulan) ? $bulan : date('Y-m'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Tampilkan
                                            </button>
                                            <button type="button" class="btn btn-success" onclick="printReport()">
                                                <i class="fa fa-print"></i> Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-bar-chart"></i> Statistik Peminjaman dan Pengembalian</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="peminjamanChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-pie-chart"></i> Status Buku</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="statusChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?= isset($total_peminjaman) ? $total_peminjaman : 0; ?></h3>
                            <p>Total Peminjaman</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?= isset($total_pengembalian) ? $total_pengembalian : 0; ?></h3>
                            <p>Total Pengembalian</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?= isset($total_denda) ? 'Rp ' . number_format($total_denda, 0, ',', '.') : 'Rp 0'; ?></h3>
                            <p>Total Denda</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?= isset($total_terlambat) ? $total_terlambat : 0; ?></h3>
                            <p>Buku Terlambat</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Reports -->
            <div class="row" id="printableArea">
                <div class="col-md-12">
                    <div class="print-header" style="display:none;">
                        <div class="text-center">
                            <div class="mt-4">
                                <h2>LAPORAN PERPUSTAKAAN</h2>
                                <h3><?= strtoupper(isset($jenis_laporan) ? $jenis_laporan : 'HARIAN'); ?></h3>
                                <p>Periode: <?= isset($periode_display) ? $periode_display : date('d-m-Y'); ?></p>
                            </div>
                        </div>
                        <div class="text-left" style="margin-left: 30px; margin-top: 10px;">
                            <?php if (isset($total_denda)): ?>
                                <p><strong>Total Denda: </strong>Rp <?= number_format($total_denda, 0, ',', '.'); ?></p>
                            <?php endif; ?>
                            <?php if (isset($total_anggota)): ?>
                                <p><strong>Total User: </strong><?= $total_anggota ?> user</p>
                            <?php endif; ?>
                            <?php if (isset($total_buku)): ?>
                                <p><strong>Total Buku: </strong><?= $total_buku ?> buku</p>
                            <?php endif; ?>
                            <?php if (isset($total_judul_buku)): ?>
                                <p><strong>Total Judul Buku: </strong><?= $total_judul_buku ?> buku</p>
                            <?php endif; ?>
                        </div>
                        <hr>
                    </div>
                </div>

                <!-- Detail Laporan Peminjaman -->
                <div class="col-md-6">
                    <div class="box box-info print-section">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-list"></i> Detail Peminjaman</h3>
                        </div>
                        <div class="box-body">
                            <?php if(isset($data_peminjaman) && !empty($data_peminjaman)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Peminjam</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach($data_peminjaman as $pinjam): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $pinjam->nama_peminjam; ?></td>
                                            <td><?= $pinjam->title; ?></td>
                                            <td><?= date('d-m-Y', strtotime($pinjam->tgl_pinjam)); ?></td>
                                            <td>
                                                <?php if($pinjam->status == 'Dipinjam'): ?>
                                                    <span class="label label-warning">Dipinjam</span>
                                                <?php else: ?>
                                                    <span class="label label-success">Di Kembalikan</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <p class="text-center text-muted">Tidak ada data peminjaman pada periode ini.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Detail Laporan Pengembalian -->
                <div class="col-md-6">
                    <div class="box box-info print-section">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-list-alt"></i> Detail Pengembalian</h3>
                        </div>
                        <div class="box-body">
                            <?php if(isset($data_pengembalian) && !empty($data_pengembalian)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Peminjam</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Denda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach($data_pengembalian as $kembali): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kembali->nama_peminjam; ?></td>
                                            <td><?= $kembali->title; ?></td>
                                            <td><?= date('d-m-Y', strtotime($kembali->tgl_kembali)); ?></td>
                                            <td>Rp <?= number_format($kembali->denda, 0, ',', '.'); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <p class="text-center text-muted">Tidak ada data pengembalian pada periode ini.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Statistik Buku Terpopuler -->
                <div class="col-md-12">
                    <div class="box box-info print-section">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-trophy"></i> Buku Terpopuler</h3>
                        </div>
                        <div class="box-body">
                            <?php if(isset($buku_populer) && !empty($buku_populer)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Pengarang</th>
                                            <th>Jumlah Dipinjam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach($buku_populer as $buku): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $buku->title; ?></td>
                                            <td><?= $buku->pengarang; ?></td>
                                            <td><span class="badge bg-blue"><?= $buku->jumlah_dipinjam; ?> kali</span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <p class="text-center text-muted">Tidak ada data buku populer pada periode ini.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Buku Tersedia Section -->
                <div class="col-md-12">
                    <div class="box box-info print-section">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-book"></i> Buku Tersedia</h3>
                        </div>
                        <div class="box-body">
                            <?php if(isset($buku_tersedia) && !empty($buku_tersedia)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Buku</th>
                                            <th>Pengarang</th>
                                            <th>Jumlah Buku</th>
                                            <th>Tanggal Masuk Terakhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($buku_tersedia as $bt): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $bt->title ?></td>
                                            <td><?= $bt->pengarang ?></td>
                                            <td><?= $bt->jumlah_buku ?></td>
                                            <td><?= date('d-m-Y', strtotime($bt->tgl_masuk)) ?></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <p class="text-center text-muted">Tidak ada data buku tersedia.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
body {
    background-color: #ecf0f1 !important;
}

.content-wrapper {
    margin-left: 0 !important;
    background-color: #ecf0f1 !important;
}
/* Fix untuk empty state agar tetap center */
.empty-state {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100px;
    width: 100%;
}

.empty-state p {
    margin: 0;
    font-size: 14px;
    color: #999;
    font-style: italic;
}

/* Ensure box-body has consistent styling */
.box-body {
    padding: 15px;
    min-height: 120px;
    display: flex;
    flex-direction: column;
}

/* When there's content, table takes full space */
.table-responsive {
    flex: 1;
}

/* When empty, center the message */
.box-body:has(.empty-state) {
    justify-content: center;
    align-items: center;
}

@media print {
    .no-print { 
        display: none !important; 
    }
    .print-header { 
        display: block !important; 
    }
    body { 
        padding: 0; 
        margin: 0; 
        background: white !important;
    }
    .empty-state {
        min-height: 60px;
    }
}
</style>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
// Chart untuk Peminjaman vs Pengembalian
var ctx1 = document.getElementById('peminjamanChart').getContext('2d');
var peminjamanChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Peminjaman', 'Pengembalian'],
        datasets: [{
            label: 'Jumlah',
            data: [
                <?= isset($total_peminjaman) ? $total_peminjaman : 0; ?>,
                <?= isset($total_pengembalian) ? $total_pengembalian : 0; ?>
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Chart untuk Status Buku dengan data yang benar
var ctx2 = document.getElementById('statusChart').getContext('2d');

// Hitung buku yang masih dipinjam
var bukuDipinjam = <?= isset($total_peminjaman) ? $total_peminjaman : 0; ?>;
var bukuDikembalikan = <?= isset($total_pengembalian) ? $total_pengembalian : 0; ?>;
var bukuTerlambat = <?= isset($total_terlambat) ? $total_terlambat : 0; ?>;

// Pastikan data tidak negatif
if (bukuDipinjam < 0) bukuDipinjam = 0;
if (bukuDikembalikan < 0) bukuDikembalikan = 0;
if (bukuTerlambat < 0) bukuTerlambat = 0;

var statusChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Dipinjam', 'Dikembalikan', 'Terlambat'],
        datasets: [{
            data: [bukuDipinjam, bukuDikembalikan, bukuTerlambat],
            backgroundColor: [
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.parsed + ' buku';
                    }
                }
            }
        }
    }
});

// Inisialisasi tampilan form saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    var jenisLaporan = document.getElementById('jenisLaporan').value;
    var tanggalSection = document.getElementById('tanggalSection');
    var bulanSection = document.getElementById('bulanSection');
    
    if (jenisLaporan === 'bulanan') {
        tanggalSection.style.display = 'none';
        bulanSection.style.display = 'block';
    } else {
        tanggalSection.style.display = 'block';
        bulanSection.style.display = 'none';
    }
});

// Function untuk print
function printReport() {
    var printContents = document.getElementById("printableArea").innerHTML;
    var originalContents = document.body.innerHTML;

    // Tambahkan CSS untuk print
    var printCSS = `
        <style>
            @media print {
                body { margin: 0; padding: 20px; }
                .print-header { display: block !important; }
                .table { font-size: 12px; }
                .box { border: 1px solid #ddd; margin-bottom: 20px; }
                .box-header { background-color: #f4f4f4; padding: 10px; border-bottom: 1px solid #ddd; }
                .box-body { padding: 10px; }
                .empty-state { min-height: 60px; }
            }
        </style>
    `;

    document.body.innerHTML = printCSS + printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

// Debug info (hapus setelah testing)
console.log('Data Debug:');
console.log('Total Peminjaman:', <?= isset($total_peminjaman) ? $total_peminjaman : 0; ?>);
console.log('Total Pengembalian:', <?= isset($total_pengembalian) ? $total_pengembalian : 0; ?>);
console.log('Total Denda:', <?= isset($total_denda) ? $total_denda : 0; ?>);
console.log('Total Terlambat:', <?= isset($total_terlambat) ? $total_terlambat : 0; ?>);
</script>