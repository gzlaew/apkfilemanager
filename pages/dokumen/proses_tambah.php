<?php
// ob_start();
require_once '../inc/function.php';
$judul      = mysqli_real_escape_string($kon, @$_POST['judul']);
$deskripsi   = mysqli_real_escape_string($kon, @$_POST['deskripsi']);
$kategori = mysqli_real_escape_string($kon, @$_POST['kategori']);
$tanggal   = mysqli_real_escape_string($kon, @$_POST['tanggal']);
$file   = mysqli_real_escape_string($kon, @$_POST['file']);
$size   = mysqli_real_escape_string($kon, @$_POST['size']);



echo $judul, $deskripsi, $kategori, $tanggal, $file, $size;

if ($size == "" || $judul == "" || $deskripsi == "" || $kategori == "" || $tanggal == "") {
?>
    <div class="alert alert-block alert-danger">
        <button type="button" class="close" data-dissmis="alert">
            <i class="icon-remove"></i>
        </button>
        <i class="icon-warning-sign-end"></i>
        Pastikan Semua form terisi
    </div>
<?php
} else {
    if (dokumentambah($_POST) > 0) {
        echo "
            <script>
            alert('Data berhasil Ditambahkan!');
            document.location.href = 'index.php?pages=dokumen';
            </script>";
    } else {
        echo "
        <script>
        alert('Data tidak berhasil Ditambahkan!');
        document.location.href = 'index.php?pages=tambah';
        </script>";
        echo "<br>";
        echo mysqli_error($kon);
    }
}
?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dissmis="alert">
        <i class="icon-remove"></i>
    </button>
    <i class="icon-warning-sign-end"></i>
    Data berhasil ditambah
</div>
<meta http-equiv="refresh" content="2; url=index.php?pages=dokumen">