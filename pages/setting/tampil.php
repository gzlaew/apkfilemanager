<?php
$DATA = settampil("SELECT * FROM setting");
?>

<!-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item"><a href="#">Library</a></li>
                              <li class="breadcrumb-item"><a href="#">Data</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Files</li>
                            </ol>
                          </nav> -->
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="form-validation">
            <?php
            if (isset($_POST['Update'])) {
              include "proses_edit.php";
            }
            if (isset($_POST['Update_logo'])) {
              include "proses_edit_logo.php";
            }
            ?>
            <form class="form-valide" name="input" method="post" enctype="#">
              <div class="mb-3">
                <label>Nama Aplikasi</label>
                <input type="hidden" name="ID" value="<?php echo $DATA['set_id']; ?>" class="form-control">
                <input type="text" name="JUDUL" value="<?php echo $DATA['judul']; ?>" class="form-control" required="">
              </div>
              <div class="mb-3">
                <label>Footer</label>
                <input type="text" name="FOOTER" value="<?php echo $DATA['footer']; ?>" class="form-control" required="">
              </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-8 ml-auto">
              <button type="submit" name="Update" class="btn btn-outline-danger">Update</button>
            </div>
          </div>
          </form>
          <br>
          <div class="row">

            <div class="col-12 col-md-6 col-lg-6">
              <div class="card">
                <form method="post" role="form" enctype="multipart/form-data">
                  <div>
                    <label for="inputLogo">Logo Aplikasi</label>
                    <input type="hidden" name="set_id" value="<?php echo $DATA['set_id']; ?>" class="form-control">
                    <input type="file" name="Logo" class="form-control" required="">
                    <br>
                    <img src="../foto/<?php echo $DATA['logo']; ?>" alt="Logo" width="200px" />
                    <div class="buttons">
                      <button type="submit" name="Update_logo" class="btn btn-outline-danger">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>