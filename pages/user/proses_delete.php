<?php
require_once '../INC/function.php';


if (user_delete($_POST) > 0) {
	echo "
	<script>
		alert('Data berhasil di hapus!');
		document.location.href = 'index.php?pages=user';
		</script>
		";
	echo "<br>";
	echo mysql_error($kon);
} else {
	echo "
	<script>
			alert ('Data tidak berhasil dihapus!');
			
	</script>
	";
	echo "<br>";
	echo mysqli_error($kon);
}
?>
<!-- <meta http-equiv="refresh" content="1; url=index.php?pages=crud_inner"> -->