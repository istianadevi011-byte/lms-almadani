<?php
session_start();
include 'config/koneksi.php';

// 1. CEK KEAMANAN
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){ 
    header("location:index.php"); 
    exit; 
}

// 2. TANGKAP DATA FILTER
$semester = isset($_GET['semester']) ? $_GET['semester'] : '1';
$kelas    = isset($_GET['kelas']) ? $_GET['kelas'] : '11';
$urutan   = isset($_GET['urutan']) ? $_GET['urutan'] : '';
$id_siswa = $_SESSION['id_siswa'];

// 3. LOGIKA UNLOCK UJIAN AKHIR
$query_total = mysqli_query($conn, "SELECT id_materi FROM materi WHERE semester='$semester' AND kelas='$kelas'");
$total_materi = mysqli_num_rows($query_total);

$query_lulus = mysqli_query($conn, "SELECT p.id_progress FROM progress p 
                                    JOIN materi m ON p.id_materi = m.id_materi 
                                    WHERE p.id_siswa='$id_siswa' 
                                    AND p.status_materi='lulus' 
                                    AND m.semester='$semester' 
                                    AND m.kelas='$kelas'");
$total_lulus = mysqli_num_rows($query_lulus);

$ujian_terbuka = ($total_lulus >= $total_materi && $total_materi > 0);
$sisa_materi = $total_materi - $total_lulus;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Materi - Kelas <?php echo $kelas; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { schoolOrange: '#f59e0b', schoolBlue: '#1e3a8a' } } }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

    <nav class="bg-schoolOrange text-white shadow-md sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="semester.php" class="font-bold hover:text-blue-900 transition flex items-center gap-2">
                <i class="fas fa-filter"></i> Ganti Filter
            </a>
            <div class="flex gap-2">
                <span class="bg-white/20 px-3 py-1 rounded-lg text-sm font-bold shadow-sm">
                    Kelas <?php echo $kelas; ?>
                </span>
                <span class="bg-white/20 px-3 py-1 rounded-lg text-sm font-bold shadow-sm">
                    Sem. <?php echo $semester; ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-8 w-full flex-grow">
        
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-schoolBlue">Materi Pembelajaran</h1>
            <p class="text-gray-500 mt-2">
                Menampilkan materi untuk <b>Kelas <?php echo $kelas; ?></b> - <b>Semester <?php echo $semester; ?></b>
            </p>
            
            <?php if($total_materi > 0) { $persen = ($total_lulus / $total_materi) * 100; ?>
            <div class="w-full max-w-md mx-auto bg-gray-200 rounded-full h-2.5 mt-4">
                <div class="bg-green-500 h-2.5 rounded-full transition-all duration-1000" style="width: <?php echo $persen; ?>%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1"><?php echo $total_lulus; ?> dari <?php echo $total_materi; ?> materi selesai.</p>
            <?php } ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php
            $sql = "SELECT * FROM materi WHERE semester='$semester' AND kelas='$kelas'";
            if($urutan != '') $sql .= " AND urutan='$urutan'";
            $sql .= " ORDER BY urutan ASC";
            $query = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($query) == 0){
                echo "<div class='col-span-1 md:col-span-2 text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300'><p class='text-gray-500'>Belum ada materi.</p></div>";
            }
            
            while($m = mysqli_fetch_array($query)){
                $id_materi = $m['id_materi'];
                $q_prog = mysqli_query($conn, "SELECT * FROM progress WHERE id_siswa='$id_siswa' AND id_materi='$id_materi'");
                $prog = mysqli_fetch_array($q_prog);
                $is_lulus = (isset($prog['status_materi']) && $prog['status_materi'] == 'lulus');
                
                $btn_color = $is_lulus ? "bg-green-600 hover:bg-green-700" : "bg-schoolBlue hover:bg-blue-900";
                $btn_text  = $is_lulus ? "Sudah Lulus" : "Mulai Belajar";
                $btn_icon  = $is_lulus ? "fa-check-circle" : "fa-play-circle";
            ?>
            <div class="bg-white rounded-xl shadow-md border <?php echo $is_lulus ? 'border-green-200' : 'border-gray-100'; ?> hover:shadow-xl transition duration-300 overflow-hidden flex flex-col group relative">
                <div class="p-6 flex-grow">
                    <div class="absolute top-2 right-4 text-6xl font-black text-gray-100 group-hover:text-orange-50 transition pointer-events-none"><?php echo $m['urutan']; ?></div>
                    <div class="flex items-center gap-2 mb-3 relative z-10">
                        <span class="bg-orange-100 text-schoolOrange text-xs font-bold px-3 py-1 rounded-full">BAB <?php echo $m['urutan']; ?></span>
                        <?php if($is_lulus) { ?><span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1"><i class="fas fa-check"></i> Selesai</span><?php } ?>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 leading-snug relative z-10"><?php echo $m['judul_materi']; ?></h3>
                    <p class="text-gray-500 text-sm line-clamp-2 relative z-10"><?php echo strip_tags(substr($m['deskripsi'], 0, 100)) . '...'; ?></p>
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 relative z-10">
                    <a href="materi_belajar.php?id=<?php echo $id_materi; ?>" class="<?php echo $btn_color; ?> text-white w-full py-3 rounded-lg font-bold shadow transition flex items-center justify-center gap-2"><i class="fas <?php echo $btn_icon; ?>"></i> <?php echo $btn_text; ?></a>
                </div>
            </div>
            <?php } ?>
        </div>
        
        <div class="mt-12 mb-10">
            <div class="relative bg-gradient-to-r from-indigo-900 to-purple-800 rounded-2xl shadow-2xl p-8 md:p-10 text-center text-white overflow-hidden border-4 border-white ring-4 ring-indigo-100">
                
                <i class="fas fa-trophy absolute top-[-20px] right-[-20px] text-9xl text-white opacity-10 transform rotate-12"></i>

                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3 uppercase tracking-wider">Evaluasi Akhir Semester</h2>
                    <p class="text-indigo-200 mb-8 max-w-2xl mx-auto">
                        Ujian ini mencakup seluruh materi di Semester <?php echo $semester; ?>. Lulus ujian ini untuk mendapatkan <strong>Sertifikat Digital</strong>.
                    </p>

                    <?php if($ujian_terbuka) { ?>
                        <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                            <a href="rangkuman.php?kelas=<?php echo $kelas; ?>&sem=<?php echo $semester; ?>" class="bg-white/10 hover:bg-white/20 text-white font-bold px-8 py-4 rounded-full shadow-lg border-2 border-white/30 transition flex items-center gap-2">
                                <i class="fas fa-book-reader"></i> BACA RANGKUMAN
                            </a>
                            
                            <a href="evaluasi.php?kelas=<?php echo $kelas; ?>&sem=<?php echo $semester; ?>" class="bg-yellow-400 hover:bg-yellow-300 text-purple-900 font-extrabold px-10 py-4 rounded-full shadow-lg transform transition hover:scale-105 hover:shadow-yellow-400/50 flex items-center gap-2 animate-bounce-slow">
                                <i class="fas fa-file-signature"></i> KERJAKAN UJIAN
                            </a>
                        </div>
                        <p class="text-xs text-yellow-300 mt-6 font-bold"><i class="fas fa-unlock"></i> AKSES TERBUKA</p>
                    <?php } else { ?>
                        <div>
                            <button disabled class="bg-gray-700/50 text-gray-400 font-bold px-8 py-4 rounded-full cursor-not-allowed border border-gray-600"><i class="fas fa-lock mr-2"></i> UJIAN MASIH TERKUNCI</button>
                            <p class="text-sm text-red-300 mt-4"><i class="fas fa-exclamation-triangle mr-1"></i> Selesaikan <strong><?php echo $sisa_materi; ?> materi lagi</strong>.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>