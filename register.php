<?php

include 'koneksi.php';

error_reporting(0);

session_start();

if (isset($_SESSION['telepon'])) {
    header("Location: login.php");
}

if (isset($_POST['submit'])) {
	$nama = $_POST['nama'];
	$telepon = $_POST['telepon'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {
		$sql = "SELECT * FROM tb_login_user WHERE telepon='$telepon'";
		$result = mysqli_query($koneksi, $sql);
		if (!$result->num_rows > 0) {
			$sql = "INSERT INTO tb_login_user (nama, telepon, email, password)
					VALUES ('$nama','$telepon', '$email', '$password')";
			$result = mysqli_query($koneksi, $sql);
			if ($result) {
				echo "<script>alert('Wow! User Registration Completed.')</script>";
				$nama = "";
				$telepon = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}
		} else {
			echo "<script>alert('Woops! Email Already Exists.')</script>";
		}

	} else {
		echo "<script>alert('Password Not Matched.')</script>";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style-regist.css">
    <title>Daftar Akun</title>
</head>
<body>
    <header>
        <nav class="head-co">
            <div class="container flex">
                <a href="index.html"><img src="assets/cek-ongkir/arrow-left.png" alt=""></a>
                <h1>Daftar</h1>
            </div>
        </nav>
    </header>
    <main>
        <section class="container">
            <form action="" method="post">
                <img src="assets/cek-ongkir/Ninja Xpress Logo .png" alt="">
                <div class="biodata">
                    <input type="text" placeholder="Nama Lengkap" name="nama" value="<?php echo $nama; ?>" required>
                    <input type="text" placeholder="Telepon" name="telepon" value="<?php echo $telepon; ?>" required>
                    <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                    <input type="password" placeholder="Kata Sandi" name="password" value="<?php echo $_POST['password']; ?>" required>
                    <input type="password" placeholder="Konfirmasi Kata Sandi" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
                </div>
                <div class="btn">
                    <button type="submit" name="submit">Selanjutnya</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>