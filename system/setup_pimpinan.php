<?php
// File: setup_pimpinan.php
// Jalankan sekali untuk setup level pimpinan

// Koneksi database (sesuaikan dengan config Anda)
$host = 'localhost';
$username = 'root'; // sesuaikan
$password = ''; // sesuaikan
$database = 'perpus'; // sesuaikan dengan nama database Anda

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "Mulai setup level pimpinan...<br>";

// Cek apakah user pimpinan sudah ada
$check = $conn->query("SELECT * FROM tbl_login WHERE level = 'Pimpinan'");
if ($check->num_rows > 0) {
    echo "⚠️ User pimpinan sudah ada!<br>";
} else {
    // Tambah user pimpinan baru
    $sql = "INSERT INTO tbl_login (anggota_id, user, pass, level, nama, tempat_lahir, tgl_lahir, jenkel, alamat, telepon, email, tgl_bergabung, foto) 
            VALUES ('AG003', 'pimpinan', MD5('123456'), 'Pimpinan', 'Kepala Perpustakaan', 'Jakarta', '1980-01-01', 'Laki-Laki', 'Jl. Perpustakaan No. 1', '081234567890', 'pimpinan@perpus.com', '2024-06-08', 'user_default.png')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ User pimpinan berhasil ditambahkan!<br>";
        echo "<strong>Username:</strong> pimpinan<br>";
        echo "<strong>Password:</strong> 123456<br>";
        echo "<strong>Level:</strong> Pimpinan<br>";
    } else {
        echo "❌ Error menambah user: " . $conn->error . "<br>";
    }
}

$conn->close();
echo "<br>Setup selesai! Silakan hapus file ini setelah selesai.";
?>