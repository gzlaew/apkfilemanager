<?php

$hostname = "localhost";
$database = "apk_file";
$username = "root";
$password = "";
$kon = mysqli_connect($hostname, $username, $password, $database);
// script cek koneksi
if (!$kon) {
  die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
}

function autonumber($tabel, $kolom, $lebar = 0, $awalan)
{
  global $kon;
  global $tgl;
  $auto = mysqli_query($kon, "select $kolom from $tabel order by $kolom desc limit 1") or die(mysqli_error($kon));
  $jumlah_record = mysqli_num_rows($auto);
  if ($jumlah_record == 0)
    $nomor = 1;
  else {
    $row = mysqli_fetch_array($auto);
    $nomor = intval(substr($row[0], strlen($awalan))) + 1;
  }
  if ($lebar > 0)
    $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
  else
    $angka = $awalan . $nomor;
  return $angka;
}
function registrasi($data)
{

  global $kon;

  $nama = stripcslashes($data["Nama"]);
  $email = strtolower(stripcslashes($data["Email"]));
  $password = mysqli_real_escape_string($kon, $data["Password"]);
  $password2 = mysqli_real_escape_string($kon, $data["Password2"]);


  $result = mysqli_query($kon, "SELECT email FROM user WHERE email='$email' ");


  if (mysqli_fetch_assoc($result)) {
    echo "<script>

    alert('email terdaftar ');
 	</script>";
    return false;
  }


  if ($password !== $password2) {
    echo "<script>

    alert('konfirmasi password tidak sesuai ');
    document.location.href = 'register.php';
 	</script>";
    return false;
  }

  //return 1;

  //$password = md5($password);
  $password = password_hash($password, PASSWORD_DEFAULT);

  //var_dump($password); die;


  $SQL = "INSERT INTO user SET
username ='$nama',
email ='$email',
role ='users',
password='$password'";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

function setting($data)
{
  global $kon;
  $result  = mysqli_query($kon, $data);
  $row = [];  //kita menyiapkan wadah kosong data untuk menyimpan data yang ada di dalam database
  $row = mysqli_fetch_array($result);

  // $rows[] =$row; //disini kitdataa sudah memasukan data spesifik



  return $row; //mengembalikan data
}

function user_tampil($query)
{
  global $kon; //variabel yang adad di dalam scope aslinya berbeda dengan yang ada di luar scope agar variabel yang di luar bisa di baca data scope maka gunakan global
  $result = mysqli_query($kon, $query);
  $row = []; //kita menyiapkan wadah kosong untuk menyimpoan data yang ada di dalam data base(ibarat  nya menyimpan langsung baju di dalam lemari)

  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row; //kita suadah memasukan data spesifik (ibarat  nya baju)
  }
  return $rows; //mengembalikan nilai
}

function user_tambah($data, $file)
{
  global $kon;

  $nama = stripcslashes($data["Nama"]);
  $email = strtolower(stripcslashes($data["Email"]));
  $password1 = mysqli_real_escape_string($kon, $data['Password1']);
  $password2 = mysqli_real_escape_string($kon, $data['Password2']);

  // Cek apakah file foto diunggah
  $PICTURE = 'default.jpg'; // Nilai default jika tidak ada gambar yang diunggah
  if (isset($file['Foto']) && $file['Foto']['error'] == 0) {
    $TARGET_DIR = '../foto/';
    $PICTURE = uniqid() . basename($file['Foto']['name']);
    $TARGET_FILE = $TARGET_DIR . $PICTURE;
    if (!move_uploaded_file($file['Foto']['tmp_name'], $TARGET_FILE)) {
      echo "<script>alert('Gagal mengunggah gambar');</script>";
      return false;
    }
  }

  // Validasi email unik
  $result = mysqli_query($kon, "SELECT email FROM user WHERE email = '$email'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>alert('Email sudah terdaftar');</script>";
    return false;
  }

  // Validasi password
  if ($password1 !== $password2) {
    echo "<script>alert('Konfirmasi password tidak sesuai');</script>";
    return false;
  }

  // Hash password
  $password_hash = password_hash($password1, PASSWORD_DEFAULT);

  // Simpan data ke database
  $SQL = "INSERT INTO user (username, email, password, profile_picture, role) VALUES ('$nama', '$email', '$password_hash', '$PICTURE', 'user')";
  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

function user_edit($data, $file)
{
  global $kon;

  $id = mysqli_real_escape_string($kon, $data['id_user']);
  $name = stripcslashes($data["Nama"]);
  $email = strtolower(stripcslashes($data["Email"]));
  $role = mysqli_real_escape_string($kon, $data['Role']);

  // Ambil gambar lama dari database untuk dihapus jika ada gambar baru yang diunggah
  $old_picture_query = mysqli_query($kon, "SELECT profile_picture FROM user WHERE user_id = '$id'");
  $old_picture = '';
  if ($old_picture_row = mysqli_fetch_assoc($old_picture_query)) {
    $old_picture = $old_picture_row['profile_picture'];
  }

  // Default gambar jika tidak ada gambar yang diunggah
  $PICTURE = $old_picture ?: 'default.jpg';

  // Cek apakah ada file foto yang diunggah
  if (isset($file['profile_picture']) && $file['profile_picture']['error'] == 0) {
    $TARGET_DIR = '../foto/';
    $PICTURE = uniqid() . "_" . basename($file['profile_picture']['name']);
    $TARGET_FILE = $TARGET_DIR . $PICTURE;

    // Pindahkan file baru ke direktori target dan hapus file lama jika unggahan berhasil
    if (move_uploaded_file($file['profile_picture']['tmp_name'], $TARGET_FILE)) {
      // Hapus file lama jika berbeda dari gambar default
      if ($old_picture && $old_picture != 'default.jpg' && file_exists($TARGET_DIR . $old_picture)) {
        unlink($TARGET_DIR . $old_picture);
      }
    } else {
      echo "<script>alert('Gagal mengunggah gambar');</script>";
      return false;
    }
  }

  // Validasi email unik kecuali jika email tidak berubah
  $result = mysqli_query($kon, "SELECT email FROM user WHERE email = '$email' AND user_id != '$id'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>alert('Email sudah terdaftar');</script>";
    return false;
  }

  // Update data ke database
  $SQL = "UPDATE user SET
                username = '$name',
                email = '$email',
                role = '$role',
                profile_picture = '$PICTURE'
            WHERE user_id = '$id'";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}





function user_delete()
{
  global $kon;

  $id = $_GET['id'];
  mysqli_query($kon, "DELETE FROM user WHERE user.user_id='$id'");
  return mysqli_affected_rows($kon);
}

function menu_tampil($query)
{
  global $kon; //variabel yang adad di dalam scope aslinya berbeda dengan yang ada di luar scope agar variabel yang di luar bisa di baca data scope maka gunakan global
  $result = mysqli_query($kon, $query);
  $row = []; //kita menyiapkan wadah kosong untuk menyimpoan data yang ada di dalam data base(ibarat  nya menyimpan langsung baju di dalam lemari)

  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row; //kita suadah memasukan data spesifik (ibarat  nya baju)
  }
  return $rows; //mengembalikan nilai
}

function submenu_tampil($query)
{
  global $kon; //variabel yang adad di dalam scope aslinya berbeda dengan yang ada di luar scope agar variabel yang di luar bisa di baca data scope maka gunakan global
  $result = mysqli_query($kon, $query);
  $row = []; //kita menyiapkan wadah kosong untuk menyimpoan data yang ada di dalam data base(ibarat  nya menyimpan langsung baju di dalam lemari)

  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row; //kita suadah memasukan data spesifik (ibarat  nya baju)
  }
  return $rows; //mengembalikan nilai
}


function kategori_tambah($query)
{
  global $kon;

  $namakategori = mysqli_real_escape_string($kon, @$_POST['namakategori']);
  $SQL = "INSERT INTO kategori SET
  kategori = '$namakategori'";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}


function subkategori_tambah($query)
{
  global $kon;

  $kategori = mysqli_real_escape_string($kon, $_POST['kategori']);
  $namasubkategori = mysqli_real_escape_string($kon, $_POST['namasubkategori']);

  $SQL = "INSERT INTO subkategori (kategori, subkat) VALUES ('$kategori', '$namasubkategori')";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

function kat_delete()
{
  global $kon;

  $id = $_GET['kat_id'];
  mysqli_query($kon, "DELETE FROM kategori WHERE user.kat_id='$id'");
  return mysqli_affected_rows($kon);
}

function subkat_delete()
{
  global $kon;

  $id = $_GET['kat_id'];
  mysqli_query($kon, "DELETE FROM subkategori WHERE user.subkat_id='$id'");
  return mysqli_affected_rows($kon);
}

function katedit()
{
  global $kon;
  $id     = mysqli_real_escape_string($kon, @$_POST['kat_id']);
  $kategori    = mysqli_real_escape_string($kon, @$_POST['kategori']);


  $SQL = "UPDATE kategori SET
		kategori = '$kategori' WHERE kategori.kat_id='$id' ";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

function subkatedit()
{
  global $kon;
  $id     = mysqli_real_escape_string($kon, @$_POST['subkat_id']);
  $subkat = mysqli_real_escape_string($kon, @$_POST['subkat']);
  $kategori    = mysqli_real_escape_string($kon, @$_POST['kategori']);


  $SQL = "UPDATE subkategori SET
    subkat = '$subkat',
		kategori = '$kategori' WHERE subkategori.subkat_id='$id' ";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

function settampil($query)
{
  global $kon;
  $result  = mysqli_query($kon, $query);
  //$row = [];	
  $row = mysqli_fetch_assoc($result);

  //$rows[] =$row; 
  return $row;
}

function setupdate($DATA)
{
  global $kon;
  $ID        = mysqli_real_escape_string($kon, @$_POST['ID']);
  $JUDUL        = mysqli_real_escape_string($kon, @$_POST['JUDUL']);
  $FOOTER      = mysqli_real_escape_string($kon, @$_POST['FOOTER']);

  echo $JUDUL . $FOOTER;

  $SQL = "UPDATE setting SET
    judul = '$JUDUL',
    footer          = '$FOOTER'	WHERE setting.set_id='$ID' ";

  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

//funsi update logo
function setupdatelogo($DATA)
{
  global $kon;

  $ID        = mysqli_real_escape_string($kon, @$_POST['set_id']);
  $LOGO = @$_FILES['Logo']['tmp_name'];
  $TARGET = '../foto/';
  $GAMBAR_LOGO = @$_FILES['Logo']['name'];

  $UPDATE_LOGO = move_uploaded_file($LOGO, $TARGET . $GAMBAR_LOGO);
  $SQL = "UPDATE setting SET
     logo = '$GAMBAR_LOGO' WHERE set_id = $ID ";
  mysqli_query($kon, $SQL);
  return mysqli_affected_rows($kon);
}

function dokumentambah()
{
  global $kon;

  $judul = mysqli_real_escape_string($kon, @$_POST['judul']);
  $deskripsi = mysqli_real_escape_string($kon, @$_POST['deskripsi']);
  $kategori = mysqli_real_escape_string($kon, @$_POST['kategori']);
  $size = mysqli_real_escape_string($kon, @$_POST['size']);
  $tanggal = date('Y-m-d H:i:s');
  $file = @$_FILES['file']['tmp_name'];
  $TARGET = '../upload/';
  $GAMBAR_file = @$_FILES['file']['name'];

  // Validasi jika file tidak terupload
  if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading file: " . $_FILES['file']['error'];
    return 0;
  }

  // Memindahkan file yang di-upload
  $UPDATE_LOGO = move_uploaded_file($file, $TARGET . $GAMBAR_file);
  if (!$UPDATE_LOGO) {
    echo "Failed to move uploaded file.";
    return 0;
  }
  // Pembuatan query SQL
  $SQL = "INSERT INTO dokumen (judul, deskripsi, file, kategori, size) VALUES ('$judul', '$deskripsi', '$GAMBAR_file', '$kategori', '$size')";




  mysqli_query($kon, $SQL);
  if (mysqli_affected_rows($kon) > 0) {
    return 1;
  } else {
    echo mysqli_error($kon);
    return 0;
  }
}

function dokumenedit($doc_id)
{
  global $kon;

  $judul = mysqli_real_escape_string($kon, @$_POST['judul']);
  $deskripsi = mysqli_real_escape_string($kon, @$_POST['deskripsi']);
  $kategori = mysqli_real_escape_string($kon, @$_POST['kategori']);
  $tanggal = date('Y-m-d H:i:s');

  // Periksa apakah ada file yang di-upload
  if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = mysqli_real_escape_string($kon, $_FILES['file']['name']);
    $target_dir = '../upload/';

    // Memindahkan file ke direktori target
    if (!move_uploaded_file($file_tmp, $target_dir . $file_name)) {
      echo "Failed to move uploaded file.";
      return 0;
    }

    // Update dengan file baru
    $SQL = "UPDATE dokumen SET judul = '$judul', deskripsi = '$deskripsi', kategori = '$kategori', upload_date = '$tanggal', file = '$file_name' WHERE doc_id = '$doc_id'";
  } else {
    // Update tanpa file baru
    $SQL = "UPDATE dokumen SET judul = '$judul', deskripsi = '$deskripsi', kategori = '$kategori', upload_date = '$tanggal' WHERE doc_id = '$doc_id'";
  }

  // Jalankan query
  mysqli_query($kon, $SQL);
  if (mysqli_affected_rows($kon) > 0) {
    return 1;
  } else {
    echo mysqli_error($kon);
    return 0;
  }
}
