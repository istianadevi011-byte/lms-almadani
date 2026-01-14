<?php
session_start();
include 'config/koneksi.php';

if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    header("location:dashboard.php");
}

if(isset($_POST['login'])){
    // AMBIL INPUT EMAIL SEKARANG
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek Data berdasarkan EMAIL
    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE email='$email' AND password='$pass'");
    
    if(mysqli_num_rows($cek) > 0){
        $data = mysqli_fetch_assoc($cek);
        $_SESSION['id_siswa'] = $data['id_siswa'];
        $_SESSION['nama'] = $data['nama_siswa'];
        $_SESSION['nis'] = $data['nis'];
        $_SESSION['status'] = "login";
        
        echo "<script>alert('Login Berhasil! Selamat Datang, ".$data['nama_siswa']."'); window.location='dashboard.php';</script>";
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script> tailwind.config = { theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } } } </script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        
        <div class="w-full md:w-1/2 bg-gradient-to-br from-schoolOrange to-orange-600 p-10 text-white flex flex-col justify-center relative">
            <i class="fas fa-shapes absolute top-10 left-10 text-6xl opacity-20 animate-pulse"></i>
            <div class="relative z-10 text-center md:text-left">
                <div class="bg-white/20 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto md:mx-0 backdrop-blur-md">
                    <i class="fas fa-school text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang!</h2>
                <p class="text-orange-100 text-sm leading-relaxed">
                    Silakan login menggunakan Email yang terdaftar untuk mengakses materi pembelajaran.
                </p>
                <div class="mt-8 hidden md:block">
                    <a href="https://smkalmadanigarut.sch.id" target="_blank" class="border border-white text-white px-6 py-2 rounded-full text-sm hover:bg-white hover:text-schoolOrange transition">
                        Kunjungi Website Sekolah
                    </a>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 md:p-14">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Login Siswa</h3>
                <p class="text-gray-400 text-sm">Masuk dengan Email & Password</p>
            </div>

            <?php if(isset($error)) { ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm rounded">
                    <p class="font-bold">Gagal Masuk</p>
                    <p>Email atau Password salah.</p>
                </div>
            <?php } ?>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm ml-1">Email Siswa</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" required placeholder="nama@email.com" 
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-schoolOrange focus:ring-2 focus:ring-orange-200 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2 text-sm ml-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" required placeholder="Masukkan kata sandi" 
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-schoolOrange focus:ring-2 focus:ring-orange-200 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <button type="submit" name="login" class="w-full bg-schoolBlue hover:bg-blue-900 text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    MASUK SEKARANG <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            <div class="mt-8 text-center pt-6 border-t border-gray-100">
                <p class="text-gray-500 text-sm mb-3">Belum punya akun siswa?</p>
                <a href="daftar.php" class="inline-block text-schoolOrange font-bold hover:text-orange-600 hover:underline transition">
                    Daftar Akun Baru di Sini
                </a>
            </div>

            <div class="mt-4 text-center">
                <a href="index.php" class="text-gray-400 hover:text-gray-600 text-xs flex items-center justify-center gap-1">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>