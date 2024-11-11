<?php
ob_start();
//include "koneksi.php";
require_once "../INC/function.php";

$nama = mysqli_real_escape_string($kon,@$_POST['Nama']);
$email = mysqli_real_escape_string($kon,@$_POST['Email']);
$PICTURE = mysqli_real_escape_string($kon,@$_POST['Foto']);
$password1 = mysqli_real_escape_string($kon,@$_POST['Password1']);
$password2 = mysqli_real_escape_string($kon,@$_POST['Password2']);

if($nama == "" || $email == "" || $password1 == "" || $password2 == '')
 {
 ?>

 <div class="alert alert-block alert-danger">
 	<button type="button" class="close" data-dismiss="alert">
 		<i class="icon-remove"></i>
 	</button>

 	<i class="icon-warning-sign red"></i>
 	PASTIKAN SEMUA FORN TERISI!!!
 </div>

 <?php
}
else
{
	if (user_tambah($_POST, $_FILES) > 0){
		echo "
		<script>
			alert('Data berhasil di tambahkan!');
			document.location.href = 'index.php?pages=user';
		</script>
		"; 
		echo "<br>";
	}
	else{
	echo "

		<script>
			alert('Data berhasil di tambahkan!');
			document.location.href = 'index.php?pages=user';
		</script>
		"; 
		echo "<br>";
		echo mysql_error($kon);

	} 

	?>
	<div class="alert alert-block alert-success">
	<button type="button" class="close" data-dismiss="alert">
		<i class="icon-remove"></i>
	</button>

	<i class="icon-ok green"></i>
	<h4>Data berhasil di tambahkan!</h4>

	</div>
	<meta http-equiv="refresh" content="2, url=index.php?pages=user"> 
	<?php
	}
	?>
