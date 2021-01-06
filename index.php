<!DOCTYPE html>
<html>
<head>
	<title>Simple Presensi</title>
</head>
<body>

<?php 
// atur timezone server
date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['submit'])) {
	// sesuaikan dengan hostname, username, password dan database-mu sendiri
	$db = mysqli_connect('localhost', 'root', '', 'absensi_db');

	// tangkap variabel id
	$id = $_POST['id'];

	// sql utk cek apakah karyawan sudah lakukan absen
	$sql= "SELECT * FROM absensi WHERE tanggal = date(NOW()) AND id = '$id'";

	// jalankan query
	$query = mysqli_query($db, $sql) or die(mysqli_error($sql));

	// jika belum lakukan absen
	if (mysqli_num_rows($query) == 0) {

		// simpan data absensi (jam masuk dan keluar disamakan dulu)
		$absen = "INSERT INTO absensi VALUES ('$id', date(NOW()), time(NOW()), time(NOW()))";

	} 
	// sudah absen, maka update jam pulangnya saja
	else {
		$absen = "UPDATE absensi SET pulang = time(NOW()) WHERE id = '$id'";
	}

	// jalankan query utk absensi
	$simpan = mysqli_query($db, $absen) or die(mysqli_error($db));

	// jika berhasil absen
	if ($simpan) {
		echo "Berhasil lakukan absensi";
	} else {
		echo "Gagal lakukan absensi";
	}
	echo "<meta http-equiv='refresh' content='2;url=index.php'/>";
}
?>


<form method="post" action="">
	<label>Masukkan ID karyawan untuk mulai absensi</label><br/>
	<input type="text" name="id"/>
	<input type="submit" name="submit" value="Lakukan Absensi"/>
</form>

</body>
</html>