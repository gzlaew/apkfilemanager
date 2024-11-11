
<?php 
if (isset($_POST['Tambah'])) {
  require_once "proses_tambah.php";
}

?>
     <div class="col-lg-12">
    <div class="card shadow-none border border-300" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
            <div class="row g-3 justify-content-between align-items-end">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Tambah User</h4>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="p-4 code-to-copy">
                <form class="needs-validation" method="POST" enctype="multipart/form-data" >
                <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <div class="controls">
                            <!-- Area Tampilan Gambar -->
                            <div class="image-preview" id="imagePreview">
                                <img src="foto/<?= htmlspecialchars($row['profile_picture'] ?: 'default.jpg'); ?>" alt="Profile Picture" class="image-preview__image" id="previewImage" style="display: block;" />
                                <span class="image-preview__default-text" id="defaultText" style="display: none;">Image Preview</span>
                                <button type="button" class="remove-image" id="removeButton">&#10006;</button>
                            </div>
                            <!-- Input File untuk Memilih Gambar -->
                            <input type="file" name="Foto" class="form-control" id="chooseFile" >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Nama</label> 
                        <div class="controls">
                            <input type="hidden" name="id_user" class="form-control" >
                            <input type="text" name="Nama" class="form-control" id="basic-form-name" >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Email</label>
                        <div class="controls">
                            <input type="text" name="Email" class="form-control" >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Password</label>
                        <div class="controls">
                        <input type="text" name="Password1" class="form-control" required
                          data-validation-required-message="This field is required" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Confirm Password</label>
                        <div class="controls">
                        <input type="text" name="Password2" class="form-control" required
                          data-validation-required-message="This field is required" />
                        </div>
                    </div>

                    <button  name="Tambah" class="btn float-right btn-outline-primary">Tambah</button>
                    <a href="index.php?pages=user" type="button" class="btn btn-outline-danger">Batal</a>
                    <button type="reset" class="btn btn-outline-success">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>                                                        