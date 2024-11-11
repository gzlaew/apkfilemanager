<?php
require_once "../inc/function.php";

// Cek apakah session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Memulai session hanya jika belum ada session yang aktif
}

$ID = $_GET['id'];

// Query untuk mengambil data kategori berdasarkan ID
$SQL = mysqli_query($kon, "SELECT * FROM kategori WHERE kat_id = '$ID'");

// Mengambil data dari hasil query
if ($ROW = mysqli_fetch_assoc($SQL)) {
    $id = $ROW['kat_id'];
    $kategori = $ROW['kategori'];
} else {
    // Jika data tidak ditemukan, Anda bisa menambahkan error handling
    echo "Data tidak ditemukan.";
    exit;
}

// Proses saat tombol Edit ditekan
if (isset($_POST['Edit'])) {
    // Hanya admin yang bisa mengedit data
    if ($_SESSION['role'] == "admin") {
        // Memanggil fungsi untuk melakukan proses update
        if (katedit($_POST, $_FILES) > 0) {
            echo "
            <script>
                alert('Data berhasil diperbarui!');
                document.location.href = 'index.php?pages=menu&aksi=tampil';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Data gagal diperbarui!');
                document.location.href = 'index.php?pages=menu&aksi=editkat&id=$ID';
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
                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Edit Kategori</h4>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="p-4 code-to-copy">
                <form class="needs-validation" novalidate="novalidate" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="kat_id" class="form-control" value="<?= htmlspecialchars($id); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Masukan Nama Kategori" value="<?= htmlspecialchars($kategori); ?>" required>
                    </div>

                    <button type="submit" name="Edit" class="btn float-right btn-outline-primary">Edit</button>
                    <a href="index.php?pages=menu&aksi=tampil" type="button" class="btn btn-outline-danger">Batal</a>
                    <button type="reset" class="btn btn-outline-success">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>