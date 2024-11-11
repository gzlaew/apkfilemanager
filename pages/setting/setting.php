<?php
@$pages = $_GET['aksi'];
switch ($pages) {

	case 'tampil';
		include "tampil.php";
		break;
	case 'edit';
		include "edit.php";
		break;
	default:
		include "../pages/setting/tampil.php";
		break;
}
