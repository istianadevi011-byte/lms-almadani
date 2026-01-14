<?php
session_start();
include 'config/koneksi.php';

// Cek Login
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){ 
    header("location:index.php"); 
    exit; 
}

$nama_siswa = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Materi Belajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <nav class="bg-schoolOrange text-white shadow-md sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="dashboard.php" class="font-bold hover:text-blue-900 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium hidden md:block">Halo, <?php echo $nama_siswa; ?></span>
                <div class="bg-white text-schoolOrange w-8 h-8 rounded-full flex items-center justify-center font-bold">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-lg">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Mulai Belajar</h1>
                <p class="text-gray-500 mt-2">Atur filter di bawah untuk mencari materi yang Anda butuhkan.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-8 border-schoolBlue">
                
                <form action="daftar_materi.php" method="GET" class="p-8 space-y-6">
                    
                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                            <i class="fas fa-graduation-cap text-schoolOrange mr-1"></i> Tingkat Kelas
                        </label>
                        <div class="relative">
                            <select name="kelas" class="w-full p-4 pl-10 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-schoolOrange appearance-none font-medium text-gray-700 cursor-pointer transition hover:bg-white">
                                <option value="10">Kelas 10 (X)</option>
                                <option value="11" selected>Kelas 11 (XI)</option>
                                <option value="12">Kelas 12 (XII)</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                            <i class="fas fa-book text-schoolOrange mr-1"></i> Mata Pelajaran
                        </label>
                        <div class="relative">
                            <select name="mapel" class="w-full p-4 pl-10 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-schoolOrange appearance-none font-medium text-gray-700 cursor-pointer transition hover:bg-white">
                                <option value="pwpb">Informatika</option>
                                <option value="pbo">Pemrograman Berorientasi Objek</option>
                                <option value="basdat">Basis Data</option>
                                <option value="pkk">Produk Kreatif & Kewirausahaan</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                            <i class="fas fa-calendar-alt text-schoolOrange mr-1"></i> Semester
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="semester" value="1" class="peer sr-only" checked>
                                <div class="p-4 rounded-xl border-2 border-gray-200 bg-gray-50 text-center peer-checked:border-schoolOrange peer-checked:bg-orange-50 peer-checked:text-schoolOrange transition hover:bg-white">
                                    <div class="font-bold">Ganjil</div>
                                    <div class="text-xs text-gray-500">Semester 1</div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="semester" value="2" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 bg-gray-50 text-center peer-checked:border-schoolBlue peer-checked:bg-blue-50 peer-checked:text-schoolBlue transition hover:bg-white">
                                    <div class="font-bold">Genap</div>
                                    <div class="text-xs text-gray-500">Semester 2</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                            <i class="fas fa-list-ol text-schoolOrange mr-1"></i> Pertemuan (Opsional)
                        </label>
                        <div class="relative">
                            <select name="urutan" class="w-full p-4 pl-10 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-schoolOrange appearance-none font-medium text-gray-700 cursor-pointer transition hover:bg-white">
                                <option value="">Tampilkan Semua Pertemuan</option>
                                <option value="1">Pertemuan 1</option>
                                <option value="2">Pertemuan 2</option>
                                <option value="3">Pertemuan 3</option>
                                <option value="4">Pertemuan 4</option>
                                <option value="5">Pertemuan 5</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-schoolOrange hover:bg-orange-600 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex justify-center items-center gap-2 mt-4">
                        LANJUT KE MATERI <i class="fas fa-arrow-right"></i>
                    </button>

                </form>
            </div>
            
            <p class="text-center text-gray-400 text-sm mt-6">
                Pastikan pilihan kelas dan semester sudah sesuai.
            </p>

        </div>
    </div>

</body>
</html>