<?php
ob_start();
require_once '../inc/function.php';

// Mengambil data dari form
$doc_id = mysqli_real_escape_string($kon, @$_POST['doc_id']);
$judul = mysqli_real_escape_string($kon, @$_POST['judul']);
$deskripsi = mysqli_real_escape_string($kon, @$_POST['deskripsi']);
$kategori = mysqli_real_escape_string($kon, @$_POST['kategori']);
$tanggal = mysqli_real_escape_string($kon, @$_POST['tanggal']);

// Validasi input
echo "doc_id: $doc_id, judul: $judul, deskripsi: $deskripsi, kategori: $kategori, tanggal: $tanggal";

if ($doc_id == "" || $judul == "" || $deskripsi == "" || $kategori == "" || $tanggal == "") {
?>
    <div class="alert alert-block alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <i class="icon-warning-sign-end"></i>
        Pastikan Semua form terisi
    </div>
<?php
} else {
    // Panggil fungsi edit
    if (dokumenedit($doc_id) > 0) {
        echo "
            <script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php?pages=dokumen';
            </script>";
    } else {
        echo "
        <script>
        alert('Data tidak berhasil diubah');
        document.location.href = 'index.php?pages=edit&id=$doc_id';
        </script>";
        echo "<br>";
        echo mysqli_error($kon);
    }
}
?>