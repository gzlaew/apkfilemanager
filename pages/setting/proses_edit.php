<?php
ob_start();
require_once '../inc/function.php';
$ID        = mysqli_real_escape_string($kon, @$_POST['ID']);
$JUDUL        = mysqli_real_escape_string($kon, @$_POST['JUDUL']);
$FOOTER      = mysqli_real_escape_string($kon, @$_POST['FOOTER']);

echo $JUDUL . $FOOTER;

if ($JUDUL == "" || $FOOTER == "") {
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
    if (setupdate($_POST) > 0) {
        echo "
            <script>
            alert('Data berhasil diedit');
            document.location.href = 'index.php?pages=setting';
            </script>";
    } else {
        echo "
        <script>
        alert('Data berhasil diedit');
        document.location.href = 'index.php?pages=setting';
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
<meta http-equiv="refresh" content="1; url=index.php?pages=setting">