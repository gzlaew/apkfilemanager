<?php

require_once "../INC/function.php";

$id=$_GET['id'];
$QUERY = mysqli_query($kon, "SELECT * FROM user WHERE user_id = '$id' ") or die (mysqli_error());
$DATA = mysqli_fetch_array($QUERY);
?>




<div class="page-header">
    <h1>DATA USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Hapus &amp; Data User
        </small>
    </h1>
</div>
<div class="section">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="">Hapus Data User</h3>
        </div>
        <div class="panel-body">
            <h3>Apakah anda ingin menghapus Data User : <?php echo $DATA['username']; ?></h3>
            <form action="" class="form-horizontal col-sm-12" method="post" role="form">
                <div class="form-group">
                    <hr>
                    <div class="">
                        <a href="?pages=user&aksi=proses_delete&id=<?php echo $DATA['user_id']; ?>" class="btn btn-danger">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Hapus
                        </a>
                        <a href="?pages=user" class="btn btn-success">
                            <span class="glyphicon glyphicon-remove"></span>Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
