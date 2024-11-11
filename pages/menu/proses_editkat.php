<?php
ob_start();
require_once '../inc/function.php';
$id     = mysqli_real_escape_string($kon, @$_POST['kat_id']);
$kategori    = mysqli_real_escape_string($kon, @$_POST['kategori']);


echo $id . $kategori;

if ($id == "" || $kategori == "") {
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
    if (katedit($_POST) > 0) {
        echo "
            <script>
            alert('Data berhasil diedit');
            document.location.href = 'index.php?pages=menu';
            </script>";
    } else {
        echo "
        <script>
        alert('Data tidak berhasil diedit');
        document.location.href = 'index.php?pages=edit';
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
    Data berhasil diedit
</div>
<meta http-equiv="refresh" content="1; url=index.php?pages=menu">