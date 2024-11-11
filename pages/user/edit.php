<?php
require_once "../inc/function.php";

// Cek apakah session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Memulai session hanya jika belum ada session yang aktif
}

$id = $_GET['id'];
$sql = "SELECT * FROM user WHERE user_id = '$id'";
$edit = mysqli_query($kon, $sql) or die("Gagal melakukan query: " . mysqli_error($kon));

// Cek apakah data ditemukan
if ($row = mysqli_fetch_assoc($edit)) {
    $username = $row['username'];
    $email = $row['email'];
    $role = isset($row['role']) ? $row['role'] : 'user'; // Atur nilai default jika 'role' tidak ada
} else {
    die("User tidak ditemukan.");
}

// Proses saat tombol Edit ditekan
if (isset($_POST['Edit'])) {
    // Hanya admin yang bisa mengedit data
    if ($_SESSION['role'] == "admin") {
        // Memanggil fungsi user_edit untuk melakukan proses update
        if (user_edit($_POST, $_FILES) > 0) { // Pastikan $_FILES ditambahkan di sini
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
                document.location.href = 'index.php?pages=user&aksi=edit&id=$id';
            </script>
            ";
            echo "<br>";
            echo mysqli_error($kon); // Menampilkan pesan error MySQL untuk debugging
        }
    } elseif ($_SESSION['role'] == "user") {
        // Pengguna dengan level "user" diarahkan ke halaman pengguna
        header("location:../pengguna/index.php");
        exit();
    }
}

?>

<div class="col-lg-12">
    <div class="card shadow-none border border-300" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
            <div class="row g-3 justify-content-between align-items-end">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Edit User</h4>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="p-4 code-to-copy">
                <form class="needs-validation" novalidate="novalidate" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <div class="controls">
                            <!-- Area Tampilan Gambar -->
                            <div class="image-preview" id="imagePreview">
                                <img src="../foto/<?= htmlspecialchars($row['profile_picture'] ?: 'default.jpg'); ?>" alt="Profile Picture" class="image-preview__image" id="previewImage" style="display: block;" />
                                <span class="image-preview__default-text" id="defaultText" style="display: none;">Image Preview</span>
                                <button type="button" class="remove-image" id="removeButton">&#10006;</button>
                            </div>

                            <!-- Input File untuk Memilih Gambar -->
                            <input type="file" name="profile_picture" class="form-control" id="chooseFile" accept="image/png, image/jpeg">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label> 
                        <div class="controls">
                            <input type="hidden" name="id_user" class="form-control" value="<?= htmlspecialchars($id); ?>">
                            <input type="text" name="Nama" class="form-control" id="basic-form-name" value="<?= htmlspecialchars($username); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="controls">
                            <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($email); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <div class="controls">
                            <select name="Role" id="basic-form-gender" class="form-control" required>
                                <option value="admin" <?php if ($role == 'admin') echo "selected"; ?>>admin</option>
                                <option value="user" <?php if ($role == 'user') echo "selected"; ?>>user</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="Edit" class="btn float-right btn-outline-primary">Edit</button>
                    <a href="index.php?pages=user" type="button" class="btn btn-outline-danger">Batal</a>
                    <button type="reset" class="btn btn-outline-success">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
