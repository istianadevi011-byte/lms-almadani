<?php
session_start();
include 'config/koneksi.php';

// CEK LOGIN
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){ 
    header("location:index.php"); 
    exit;
}

// CEK ID MATERI
if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "<script>alert('Pilih materi dulu!'); window.location='dashboard.php';</script>";
    exit; 
}

$id_materi = $_GET['id'];
$id_siswa = $_SESSION['id_siswa'];

// AMBIL INFO JUDUL MATERI
$q_materi = mysqli_query($conn, "SELECT * FROM materi WHERE id_materi='$id_materi'");
$materi = mysqli_fetch_array($q_materi);

// --- LOGIKA BARU: BACA SOAL DARI FILE PHP ---
$file_soal = "assets/soal/" . $id_materi . ".php";
$data_soal = []; // Siapkan array kosong

if(file_exists($file_soal)){
    include $file_soal; // Load file soal (akan memunculkan variabel $data_soal)
} else {
    echo "<script>alert('Soal untuk materi ini belum dibuat oleh Admin.'); window.location='materi_belajar.php?id=$id_materi';</script>";
    exit;
}
// --------------------------------------------

// HITUNG NILAI (JIKA TOMBOL DIKIRIM)
$nilai_akhir = null;
if(isset($_POST['kirim_jawaban'])){
    $benar = 0;
    $total_soal = count($data_soal);
    
    // Loop pengecekan jawaban
    foreach($data_soal as $index => $soal){
        $jawaban_user = isset($_POST['jawaban_'.$index]) ? $_POST['jawaban_'.$index] : '';
        if($jawaban_user == $soal['kunci']){
            $benar++;
        }
    }

    // Rumus Nilai
    $nilai_akhir = ($benar / $total_soal) * 100;

    // Jika Lulus (KKM 70), Update Database Progress
    if($nilai_akhir >= 70){
        mysqli_query($conn, "UPDATE progress SET status_materi='lulus' WHERE id_siswa='$id_siswa' AND id_materi='$id_materi'");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kuis: <?php echo $materi['judul_materi']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script> tailwind.config = { theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } } } </script>
</head>
<body class="bg-gray-900 min-h-screen font-sans py-10">

    <div class="max-w-3xl mx-auto px-4">
        
        <div class="text-center mb-8">
            <span class="bg-schoolOrange text-white px-3 py-1 rounded-full text-xs font-bold tracking-wide">EVALUASI PEMBELAJARAN</span>
            <h1 class="text-white text-2xl md:text-3xl font-bold mt-3"><?php echo $materi['judul_materi']; ?></h1>
            <p class="text-gray-400 mt-2">Jawablah pertanyaan berikut dengan teliti. KKM: 70</p>
        </div>

        <?php if($nilai_akhir !== null) { ?>
            <div class="bg-white rounded-2xl shadow-2xl p-8 text-center mb-8 border-t-8 <?php echo ($nilai_akhir >= 70) ? 'border-green-500' : 'border-red-500'; ?>">
                <h2 class="text-gray-500 font-bold uppercase text-sm tracking-wide">Skor Akhir Anda</h2>
                <div class="text-6xl font-extrabold my-4 <?php echo ($nilai_akhir >= 70) ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo floor($nilai_akhir); ?>
                </div>
                
                <?php if($nilai_akhir >= 70) { ?>
                    <p class="text-green-600 font-bold text-lg mb-6">🎉 SELAMAT! ANDA LULUS MATERI INI.</p>
                    <a href="daftar_materi.php?semester=<?php echo $materi['semester']; ?>" class="bg-schoolOrange text-white px-6 py-3 rounded-full font-bold shadow-lg hover:bg-orange-600 transition">
                        Lanjut Materi Berikutnya <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                <?php } else { ?>
                    <p class="text-red-500 font-bold mb-6">Maaf, Anda belum lulus. Silakan pelajari materi lagi.</p>
                    <div class="flex justify-center gap-4">
                        <a href="materi_belajar.php?id=<?php echo $id_materi; ?>" class="text-gray-500 hover:text-gray-800 underline">Pelajari Materi Lagi</a>
                        <a href="kuis.php?id=<?php echo $id_materi; ?>" class="bg-gray-700 text-white px-6 py-3 rounded-full font-bold shadow-lg hover:bg-gray-800 transition">
                            <i class="fas fa-redo ml-2"></i> Coba Lagi
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>

            <form action="" method="POST">
                <?php
                // Loop Array Soal dari File PHP
                foreach($data_soal as $index => $s){
                    $nomor = $index + 1;
                ?>
                
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-schoolOrange"></div>
                    
                    <div class="mb-6">
                        <span class="bg-orange-100 text-schoolOrange font-bold px-3 py-1 rounded-full text-xs tracking-wide">SOAL <?php echo $nomor; ?></span>
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mt-4 leading-relaxed">
                            <?php echo $s['tanya']; ?>
                        </h3>
                    </div>

                    <div class="space-y-3">
                        <?php 
                        // Array Opsi agar kodenya rapi
                        $opsi = ['a', 'b', 'c', 'd']; 
                        foreach($opsi as $o) {
                            $huruf_besar = strtoupper($o);
                        ?>
                        <label class="flex items-center p-3 md:p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-schoolOrange hover:bg-orange-50 transition group">
                            <input type="radio" name="jawaban_<?php echo $index; ?>" value="<?php echo $huruf_besar; ?>" class="w-5 h-5 text-schoolOrange focus:ring-schoolOrange border-gray-300">
                            <span class="ml-4 text-gray-700 group-hover:text-schoolOrange font-medium">
                                <?php echo $huruf_besar . ". " . $s[$o]; ?>
                            </span>
                        </label>
                        <?php } ?>
                    </div>
                </div>

                <?php } ?>
                
                <div class="mt-8 mb-12 flex justify-end">
                    <button type="submit" name="kirim_jawaban" class="bg-schoolOrange hover:bg-orange-600 text-white font-bold py-4 px-10 rounded-full shadow-2xl transition transform hover:scale-105 text-lg w-full md:w-auto">
                        Kirim Jawaban <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </div>

            </form>
        <?php } ?>

    </div>
</body>
</html>