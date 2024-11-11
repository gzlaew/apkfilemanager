<?php
if (isset($_POST['Tambah'])) {
    require_once "proses_tambah.php";
}
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
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Tambah Dokumen</h4>
                                </div>
                                <div class="col col-md-auto">
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Dokumen</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select id="category-select" name="kategori" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tgl. Upload</label>
                                    <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('d-m-Y'); ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">File</label>
                                    <div class="controls">
                                        <!-- Input File untuk Memilih Gambar -->
                                        <input type="file" name="file" class="form-control" id="chooseFile" onchange="readFileSize(this)" required>
                                        <small id="fileSizeInfoText" style="display: block; margin-top: 5px;"></small>
                                        <input type="hidden" name="size" id="fileSizeInfo">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start">
                                    <button name="Tambah" type="submit" class="btn btn-primary">Submit</button>
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

<script>
    function readFileSize(input) {
        if (input.files && input.files.length > 0) {
            const file = input.files[0];
            const fileSize = file.size / 1024; // in KB
            document.getElementById('fileSizeInfoText').innerText = `Ukuran file: ${fileSize.toFixed(2)} KB`;
            document.getElementById('fileSizeInfo').value = fileSize.toFixed(2); // set hidden input value

            const maxSize = 2048; // max 2MB
            if (fileSize > maxSize) {
                alert("Ukuran file terlalu besar. Maksimal 2MB.");
                input.value = "";
                document.getElementById('fileSizeInfoText').innerText = "File tidak dipilih karena ukuran terlalu besar.";
                document.getElementById('fileSizeInfo').value = ""; // clear hidden input value
            }
        } else {
            document.getElementById('fileSizeInfoText').innerText = "";
            document.getElementById('fileSizeInfo').value = ""; // clear hidden input value
        }
    }
</script>