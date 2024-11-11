<?php
ob_start();
require_once '../INC/function.php';

$id = mysqli_real_escape_string($kon, @$_POST['id_user']);
$nama = mysqli_real_escape_string($kon, @$_POST['Nama']);
$email = mysqli_real_escape_string($kon, @$_POST['Email']);
$role = mysqli_real_escape_string($kon, @$_POST['Role']);
$profile_picture = mysqli_real_escape_string($kon, @$_POST['profile_picture']);

// Tampilkan nilai untuk debugging
echo $id . $nama . $email . $role;

// Validasi apakah form sudah diisi lengkap
if ($id == "" || $nama == "" || $role == "") {
?>
    <div class="alert alert-block alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <i class="icon-warning-sign red"></i>
        <h4>Pastikan form sudah diisi semua!</h4>
    </div>
<?php
} else {
    // Proses update data
    if (user_edit($_POST, $_FILES) > 0) {
        echo "
        <script>
            alert('Data berhasil diperbarui!');
            document.location.href = 'index.php?pages=user';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal diperbarui!');
            document.location.href = 'index.php?pages=user&aksi=edit';
        </script>
        ";
        echo "<br>";
        echo mysqli_error($kon); // Menampilkan pesan error MySQL untuk debugging
    }
}
?>