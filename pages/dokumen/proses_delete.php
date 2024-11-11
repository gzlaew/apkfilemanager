<?php
require_once '../inc/function.php';
$ID = $_GET['id'];
$QUERY = mysqli_query($kon, "DELETE FROM dokumen WHERE doc_id = '$ID'");

?>
<meta http-equiv="refresh" content="1; url=index.php?pages=dokumen">