<?php
// Mendapatkan ID dokumen yang akan diedit dari parameter URL
if (isset($_GET['id'])) {
    $doc_id = $_GET['id'];
} else {
    die("ID dokumen tidak ditemukan.");
}

// Mengambil data dokumen dari database
require_once "../inc/function.php";
$edit_query = mysqli_query($kon, "SELECT * FROM dokumen WHERE doc_id = '$doc_id'");
$document = mysqli_fetch_assoc($edit_query);

if (!$document) {
    die("Dokumen tidak ditemukan.");
}

// Mengambil daftar kategori
$categories = [];
$category_query = mysqli_query($kon, "SELECT * FROM kategori");
if (mysqli_num_rows($category_query) > 0) {
    while ($row = mysqli_fetch_assoc($category_query)) {
        $categories[] = [
            'id' => $row['kat_id'],
            'name' => $row['kategori']
        ];
    }
}

// Menyimpan perubahan dokumen jika form di-submit
if (isset($_POST['Update'])) {
    require_once "proses_edit.php";
}

?>

<div class="content">
    <div class="mt-4">
        <div class="row g-4">
            <div class="col-12 col-xl-10 order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card">
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Edit Dokumen</h4>
                                </div>
                                <div class="col col-md-auto">
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="hidden" name="doc_id" class="form-control" value="<?= htmlspecialchars($document['doc_id']) ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Dokumen</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($document['judul']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= htmlspecialchars($document['deskripsi']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select id="category-select" name="kategori" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>" <?= ($document['kategori'] == $category['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tgl. Upload</label>
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($document['upload_date']) ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">File Saat Ini</label>
                                    <p><?= htmlspecialchars($document['file']) ?></p>
                                    <label class="form-label">Ganti File (jika diperlukan)</label>
                                    <div class="controls">
                                        <input type="file" name="file" class="form-control" id="chooseFile">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start">
                                    <button name="Update" type="submit" class="btn btn-primary">Update</button>
                                    <a href="index.php?pages=dokumen&aksi=tampil" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>