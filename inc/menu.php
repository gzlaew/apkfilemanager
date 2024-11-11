
<?php


@$pages = $_GET['pages'];

switch ($pages) {
	case 'kategori':
		include "../pages/kategori/kategori.php";
		break;
	case 'user':
		include "../pages/user/user.php";
		break;
	case 'peminjaman':
		include "../pages/peminjaman/peminjaman.php";
		break;
	case 'pengaduan':
		include "../pages/pengaduan/pengaduan.php";
		break;
	case 'pengajuan':
		include "../pages/pengajuan/pengajuan.php";
		break;
	case 'setting':
		include "../pages/setting/setting.php";
		break;
	case 'menu':
		include "../pages/menu/menu.php";
		break;

	case 'dokumen':
		include "../pages/dokumen/dokumen.php";
		break;
	case 'ruangan':
		include "../pages/ruangan/ruangan.php";
		break;





	default:
		include "../pages/dashboard.php";
		break;
}

?>