<?php
@$aksi = $_GET['aksi'];

switch ($aksi) {

    case 'tampil':
        include "tampil.php";
        break;

    case 'tambah':
        include "tambah.php";
        break;

    case 'editkat':
        include "editkat.php";
        break;

    case 'editsubkat':
        include "editsubkat.php";
        break;


    case 'proses_editkat':
        include "proses_editkat.php";
        break;


    case 'deletekat':
        include "deletekat.php";
        break;

    case 'deletesubkat':
        include "deletesubkat.php";
        break;

    case 'prosesdeletesubkat':
        include "prosesdeletesubkat.php";
        break;

    case 'prosesdeletekat':
        include "prosesdeletekat.php";
        break;


    case 'proses_delete':
        include "proses_delete.php";
        break;

    case 'laporan':
        include "../laporan/laporan";
        break;
    default:
        include "tampil.php";
        break;
}
