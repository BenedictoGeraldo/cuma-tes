<?php
$name = $_POST['name'];
$email = $_POST['email'];
$field = $_POST['field'];
$date = $_POST['date'];
$time = $_POST['time'];
$keterangan = $_POST['keterangan']; // Ambil keterangan dari form
$field = $_GET['field']; // Ambil informasi lapangan dari URL

// Gunakan informasi lapangan sesuai kebutuhan, misalnya untuk menampilkan nama lapangan
echo "<h2>Form Pemesanan Lapangan $field</h2>";

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_lapangan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// SQL untuk memeriksa apakah ada booking yang bentrok
$sql_check = "SELECT * FROM bookings WHERE field = '$field' AND date = '$date' AND time = '$time'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // Ada bentrokan booking
    echo "Lapangan sudah dibooking pada tanggal dan waktu yang dipilih. Silakan pilih tanggal atau waktu lain.";
} else {
    // Tidak ada bentrokan, masukkan data booking
    $sql_insert = "INSERT INTO bookings (name, email, field, date, time, keterangan) 
                   VALUES ('$name', '$email', '$field', '$date', '$time', '$keterangan')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Pemesanan berhasil!";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>