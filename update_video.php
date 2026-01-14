<?php
include 'config/koneksi.php';

if(isset($_POST['id_siswa']) && isset($_POST['id_materi'])){
    $id_siswa = $_POST['id_siswa'];
    $id_materi = $_POST['id_materi'];

    // Update status video jadi 1 (Selesai)
    $query = "UPDATE progress SET status_video=1 WHERE id_siswa='$id_siswa' AND id_materi='$id_materi'";
    mysqli_query($conn, $query);
}
?>