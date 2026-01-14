<?php
session_start();
if($_SESSION['status'] != "login"){ header("location:index.php"); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script> tailwind.config = { theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } } } </script>
</head>
<body class="bg-orange-50 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] font-sans min-h-screen flex flex-col">

    <nav class="bg-schoolOrange shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center text-white">
                <div class="flex items-center gap-2">
                    <i class="fas fa-school text-white text-xl"></i>
                    <span class="font-bold tracking-wide">LMS AL MADANI</span>
                </div>
                <a href="logout.php" class="text-sm hover:text-blue-900 bg-white/20 px-3 py-1 rounded transition"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="bg-schoolOrange pb-32 pt-10 px-4 shadow-lg rounded-b-[3rem]">
        <div class="max-w-6xl mx-auto text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Halo, <?php echo $_SESSION['nama']; ?>! 👋</h1>
            <p class="text-orange-100 text-lg">Selamat datang di portal pembelajaran online.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 -mt-20 mb-10">
        
        <a href="semester.php?kelas=11" class="block bg-white p-10 rounded-3xl shadow-2xl border-t-8 border-schoolBlue text-center transform transition hover:-translate-y-2 hover:scale-[1.01] relative overflow-hidden group cursor-pointer">
            
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-100 rounded-full opacity-50 group-hover:scale-150 transition duration-500"></div>

            <div class="relative z-10">
                <div class="inline-block bg-orange-100 p-6 rounded-full mb-6 text-schoolOrange group-hover:bg-schoolOrange group-hover:text-white transition shadow-sm">
                    <i class="fas fa-book-open text-5xl"></i>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Mulai Belajar</h2>
                <p class="text-gray-500 mb-8 max-w-lg mx-auto">Akses modul pembelajaran, video materi, dan kuis evaluasi di sini.</p>
                
                <span class="bg-schoolOrange text-white px-8 py-3 rounded-full text-lg font-bold shadow-lg group-hover:bg-orange-600 transition">
                    MASUK KE MATERI <i class="fas fa-arrow-right ml-2"></i>
                </span>
            </div>
        </a>

    </div>

    <footer class="bg-schoolOrange text-white text-center py-6 mt-auto">
        <p class="text-sm">&copy; <?php echo date('Y'); ?> SMK Al Madani Garut.</p>
    </footer>

</body>
</html>