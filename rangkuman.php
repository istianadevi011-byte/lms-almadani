<?php
session_start();
include 'config/koneksi.php';

// Cek Login
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){ 
    header("location:index.php"); 
    exit; 
}

$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '11';
$sem   = isset($_GET['sem']) ? $_GET['sem'] : '1';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangkuman Materi - Semester <?php echo $sem; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans min-h-screen pb-20">

    <nav class="bg-schoolBlue text-white shadow-md sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="daftar_materi.php?semester=<?php echo $sem; ?>&kelas=<?php echo $kelas; ?>" class="font-bold hover:text-orange-300 transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <span class="bg-white/10 px-3 py-1 rounded text-sm font-bold">Rangkuman Semester <?php echo $sem; ?></span>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Rangkuman Materi Belajar</h1>
            <p class="text-gray-500 mt-2">Pelajari ringkasan ini sebelum mengerjakan Ujian Evaluasi Akhir.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border-l-8 border-schoolOrange">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-orange-100 p-2 rounded-lg text-schoolOrange"><i class="fas fa-code text-xl"></i></div>
                    <h2 class="text-2xl font-bold text-gray-800">Materi 1: Pengenalan HTML</h2>
                </div>
                <div class="prose max-w-none text-gray-600 text-justify leading-relaxed">
                    <p>
                        Materi ini membahas pengenalan HTML (Hypertext Markup Language) sebagai bahasa markup dasar yang digunakan untuk membangun dan menampilkan halaman web di browser. HTML diciptakan oleh Sir Tim Berners-Lee pada awal 1990-an dan terus berkembang hingga versi HTML5 yang digunakan saat ini.
                    </p>
                    <p class="mt-2">
                        HTML memiliki banyak kelebihan, seperti bersifat open source, mudah dipelajari oleh pemula, didukung semua browser, serta dapat diintegrasikan dengan berbagai bahasa pemrograman lain. Namun, HTML juga memiliki keterbatasan karena hanya digunakan untuk membuat halaman web statis dan tidak mendukung logika pemrograman secara langsung.
                    </p>
                    <p class="mt-2">
                        Materi ini juga menjelaskan struktur dasar HTML yang terdiri dari doctype, tag &lt;html&gt;, &lt;head&gt;, dan &lt;body&gt;, serta fungsi masing-masing bagian. Selain itu, diperkenalkan berbagai tag HTML umum seperti heading, paragraf, link, gambar, daftar, form, tabel, dan elemen pengelompokan yang berfungsi untuk menyusun dan menampilkan konten web secara terstruktur dan mudah dipahami.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border-l-8 border-blue-600">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-600"><i class="fas fa-layer-group text-xl"></i></div>
                    <h2 class="text-2xl font-bold text-gray-800">Materi 2: Tag Semantik</h2>
                </div>
                <div class="prose max-w-none text-gray-600 text-justify leading-relaxed">
                    <p>
                        Materi ini membahas pengertian tag semantik sebagai elemen HTML yang memiliki makna jelas terhadap struktur dan isi halaman web, sehingga dapat dipahami dengan baik oleh browser, developer, maupun mesin pencari.
                    </p>
                    <p class="mt-2">
                        Tag semantik berfungsi untuk membuat struktur halaman web lebih rapi, memudahkan pengelolaan kode, meningkatkan optimasi mesin pencari (SEO), serta mendukung aksesibilitas bagi pengguna, termasuk pengguna screen reader.
                    </p>
                    <p class="mt-2">
                        Dalam materi ini juga dijelaskan berbagai jenis tag semantik seperti &lt;header&gt;, &lt;nav&gt;, &lt;main&gt;, &lt;section&gt;, &lt;article&gt;, &lt;aside&gt;, dan &lt;footer&gt; beserta fungsinya masing-masing dalam menyusun halaman web secara terstruktur, logis, dan mudah dipahami.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-10 border-l-8 border-green-500">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-green-100 p-2 rounded-lg text-green-600"><i class="fas fa-laptop-code text-xl"></i></div>
                    <h2 class="text-2xl font-bold text-gray-800">Materi 3: Dasar Penggunaan HTML</h2>
                </div>
                <div class="prose max-w-none text-gray-600 text-justify leading-relaxed">
                    <p>
                        Materi ini membahas dasar-dasar penggunaan HTML sebagai bahasa utama dalam pembuatan halaman web. Pembahasan dimulai dari pengertian HTML dan fungsinya dalam menyusun struktur halaman agar teks, gambar, dan elemen lainnya dapat ditampilkan dengan baik di browser.
                    </p>
                    <p class="mt-2">
                        Materi ini juga menjelaskan struktur dasar HTML yang terdiri dari doctype, tag &lt;html&gt;, &lt;head&gt;, dan &lt;body&gt;, serta penggunaan elemen teks seperti judul dan paragraf. Selain itu, dijelaskan cara menampilkan gambar, membuat link, dan menyusun informasi menggunakan daftar (list).
                    </p>
                    <p class="mt-2">
                        Secara keseluruhan, materi ini menekankan bahwa penguasaan HTML dasar merupakan langkah awal yang penting sebelum mempelajari CSS dan JavaScript untuk pengembangan web lebih lanjut.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center sticky bottom-6 z-40">
            <a href="evaluasi.php?kelas=<?php echo $kelas; ?>&sem=<?php echo $sem; ?>" class="bg-gradient-to-r from-schoolOrange to-orange-600 text-white font-bold py-4 px-10 rounded-full shadow-2xl hover:scale-105 transform transition flex items-center justify-center gap-3 w-full md:w-auto mx-auto border-4 border-white">
                <i class="fas fa-edit text-2xl"></i>
                <span class="text-xl">SAYA SIAP UJIAN SEKARANG</span>
            </a>
        </div>

    </div>
</body>
</html>