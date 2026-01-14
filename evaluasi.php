<?php
session_start();
include 'config/koneksi.php';

if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){ header("location:index.php"); exit; }

$kelas = $_GET['kelas'];
$sem   = $_GET['sem'];
$id_siswa = $_SESSION['id_siswa'];

// LOAD SOAL FINAL
$file_soal = "assets/soal/final_" . $kelas . "_" . $sem . ".php";
$data_soal = [];

if(file_exists($file_soal)){
    include $file_soal;
} else {
    echo "<script>alert('Soal ujian belum tersedia!'); window.location='semester.php';</script>";
    exit;
}

// PROSES NILAI
if(isset($_POST['kirim_jawaban'])){
    $benar = 0;
    foreach($data_soal as $idx => $s){
        if(isset($_POST['ans_'.$idx]) && $_POST['ans_'.$idx] == $s['kunci']) $benar++;
    }
    $nilai = ($benar / count($data_soal)) * 100;
    
    if($nilai >= 75){ // KKM Ujian 75
        // Redirect ke Sertifikat
        $_SESSION['nilai_ujian'] = $nilai;
        header("location:sertifikat.php?kelas=$kelas&sem=$sem");
    } else {
        echo "<script>alert('Nilai Anda: ".floor($nilai).". Maaf belum lulus KKM (75). Silakan coba lagi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Ujian Akhir Semester</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen py-10 px-4 font-sans text-gray-800">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-purple-800 p-6 text-center text-white">
            <h1 class="text-2xl font-bold">Ujian Evaluasi Akhir</h1>
            <p class="text-purple-200 text-sm">Kerjakan dengan jujur. KKM: 75</p>
        </div>

        <form action="" method="POST" class="p-8 space-y-8">
            <?php foreach($data_soal as $i => $s) { ?>
                <div class="border-b pb-6">
                    <p class="font-bold text-lg mb-3"><?php echo ($i+1) . ". " . $s['tanya']; ?></p>
                    <div class="space-y-2">
                        <?php foreach(['a','b','c','d'] as $opt) { ?>
                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 cursor-pointer border border-transparent hover:border-gray-200">
                                <input type="radio" name="ans_<?php echo $i; ?>" value="<?php echo strtoupper($opt); ?>" class="w-5 h-5 text-purple-600">
                                <span><?php echo strtoupper($opt) . ". " . $s[$opt]; ?></span>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <button type="submit" name="kirim_jawaban" class="w-full bg-purple-700 hover:bg-purple-900 text-white font-bold py-4 rounded-xl shadow-lg transition text-lg">
                SELESAI & LIHAT HASIL
            </button>
        </form>
    </div>
</body>
</html>