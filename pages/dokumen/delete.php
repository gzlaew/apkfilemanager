<?php
require_once "../inc/function.php";
$ID = $_GET['id'];
$QUERY = mysqli_query($kon, "SELECT * FROM dokumen WHERE doc_id = '$ID'");
$DATA = mysqli_fetch_array($QUERY);
?>

<div>
    <h2>PENGHAPUSAN DATA</h2>

</div>
<div class="section">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3>Hapus Data</h3>
        </div>
        <div class="panel-body">
            <h2>Apakah Anda yakin ingin Menghapus Data <?php echo $DATA['judul']; ?></h2>
            <form class="form-horizontal col-sm-12" method="post" role="form">
                <div class="form-group">
                    <div class="">
                        <a href="?pages=dokumen&aksi=proses_delete&id=<?php echo $DATA['doc_id']; ?>" class="btn btn-primary">
                            Hapus
                        </a>
                        <a href="?pages=dokumen" class="btn btn-primary">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>