<?php
ob_start();
//include "koneksi.php";
require_once "../INC/function.php";

$namakategori = mysqli_real_escape_string($kon, @$_POST['namakategori']);

if ($namakategori == "") {
?>

    <div class="alert alert-block alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>

        <i class="icon-warning-sign red"></i>
        PASTIKAN SEMUA FORN TERISI!!!
    </div>

<?php
} else {
    if (kategori_tambah($_POST) > 0) {
        echo "
		<script>
			alert('Data berhasil di tambahkan!');
			document.location.href = 'index.php?pages=menu';
		</script>
		";
        echo "<br>";
    } else {
        echo "

		<script>
			alert('Data berhasil di tambahkan!');
			document.location.href = 'index.php?pages=menu';
		</script>
		";
        echo "<br>";
    }

?>
    <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>

        <i class="icon-ok green"></i>
        <h4>Data berhasil di tambahkan!</h4>

    </div>
    <meta http-equiv="refresh" content="2, url=index.php?pages=menu">
<?php
}
?>