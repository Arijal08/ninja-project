<?php

//unutk penghubung dengan file koneksi
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $username = $_POST['telepon'];
    $password = $_POST['password'];



    //ambil data dari database tabel login dengan username dan passsowrd
    $data = mysqli_query($koneksi, "SELECT * FROM tb_login_user WHERE telepon='$username' AND password='$password'");
    if (mysqli_num_rows($data)) {
        // $_SESSION["login"] = true;
        echo "Login berhasil";
        header("Location:index.php");
    } else {
        echo "<script>
			alert('Maaf kamu gagal login!');
			document.location.href='login.php';
			</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/style-login.css">
    <title>Login</title>
</head>

<body>
    <header>
        <nav class="head-co">
            <div class="container flex">
                <a href="index.html"><img src="assets/cek-ongkir/arrow-left.png" alt=""></a>
                <h1>Masuk</h1>
            </div>
        </nav>
        <section class="container">
            <form action="index.html" method="POST">
                <img src="assets/cek-ongkir/Ninja Xpress Logo .png" alt="">
                <div class="biodata">
                    <input type="text" placeholder="Telepon (+628xxxxxxxx)" name="telepon">
                    <input type="password" placeholder="Kata Sandi" name="password">
                </div>
                <div class="forget-pw">
                    <a href="#">Lupa Kata Sandi?</a>
                </div>
                <div class="btn-submit">
                    <input type="submit" name="submit" value="Masuk">
                </div>
                <div class="create">
                    <a href="register.html">Daftar</a>
                </div>
            </form>
        </section>
    </header>
</body>

</html>