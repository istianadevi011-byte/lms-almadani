<?php
session_start();
if(!isset($_SESSION['nilai_ujian'])){ header("location:semester.php"); exit; }
$nama = $_SESSION['nama'];
$nilai = floor($_SESSION['nilai_ujian']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sertifikat Kelulusan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl p-10 border-[20px] border-double border-schoolOrange shadow-2xl text-center relative">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>

        <i class="fas fa-award text-8xl text-yellow-400 mb-6 drop-shadow-md"></i>
        
        <h1 class="text-5xl font-serif text-gray-800 font-bold mb-2">SERTIFIKAT KELULUSAN</h1>
        <p class="text-xl text-gray-500 mb-8 font-serif italic">Diberikan kepada:</p>
        
        <h2 class="text-4xl font-bold text-schoolBlue mb-6 underline decoration-schoolOrange decoration-4 underline-offset-8">
            <?php echo $nama; ?>
        </h2>
        
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
            Telah berhasil menyelesaikan seluruh materi pembelajaran dan lulus Ujian Evaluasi Akhir Semester dengan predikat <strong>SANGAT BAIK</strong>.
        </p>

        <div class="flex justify-center gap-12 mb-10">
            <div class="text-center">
                <p class="text-gray-400 text-sm">Nilai Akhir</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo $nilai; ?>/100</p>
            </div>
            <div class="text-center">
                <p class="text-gray-400 text-sm">Tanggal</p>
                <p class="text-xl font-bold text-gray-800"><?php echo date('d F Y'); ?></p>
            </div>
        </div>

        <div class="border-t pt-4 w-64 mx-auto">
            <img src="https://upload.wikimedia.org/wikipedia/commons/f/f8/Signatur_sample.svg" class="h-10 mx-auto opacity-50 mb-2" alt="TTD">
            <p class="font-bold text-gray-800">Kepala Sekolah</p>
            <p class="text-xs text-gray-500">SMK Al Madani Garut</p>
        </div>
    </div>

    <div class="mt-8 flex gap-4 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-full font-bold shadow hover:bg-blue-700 transition">
            <i class="fas fa-print mr-2"></i> Cetak PDF
        </button>
        <a href="dashboard.php" class="bg-gray-500 text-white px-6 py-3 rounded-full font-bold shadow hover:bg-gray-600 transition">
            Kembali ke Dashboard
        </a>
    </div>

    <script>
        tailwind.config = { theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } } }
    </script>
</body>
</html>