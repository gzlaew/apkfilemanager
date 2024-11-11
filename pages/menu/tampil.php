<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "apk_file";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data kategori dari database
$categories = [];
$sql = "SELECT * FROM kategori";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category = [
            'id' => $row['kat_id'],
            'name' => $row['kategori'],
            'subcategories' => []
        ];

        // Mengambil subkategori terkait
        $subcategory_sql = "SELECT * FROM subkategori WHERE kategori = '" . $conn->real_escape_string($row['kat_id']) . "'";
        $subcategory_result = $conn->query($subcategory_sql);

        if ($subcategory_result->num_rows > 0) {
            while ($subcategory_row = $subcategory_result->fetch_assoc()) {
                $category['subcategories'][] = [
                    'id' => $subcategory_row['subkat_id'],
                    'name' => $subcategory_row['subkat']
                ];
            }
        }

        $categories[] = $category;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .category-container {
            width: 70%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .category {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .subcategory {
            padding-left: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .actions {
            margin-left: 10px;
        }

        .edit,
        .delete {
            cursor: pointer;
        }

        .edit {
            color: green;
            margin-right: 10px;
        }

        .delete {
            color: red;
        }

        .subcategory-container {
            display: none;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h4 {
            margin: 0;
        }

        .close {
            cursor: pointer;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
    <script>
        function toggleSubcategories(element) {
            const subcategoryContainer = element.nextElementSibling;
            if (subcategoryContainer.style.display === 'none' || subcategoryContainer.style.display === '') {
                subcategoryContainer.style.display = 'block';
            } else {
                subcategoryContainer.style.display = 'none';
            }
        }

        function openModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function openSubcategoryModal() {
            document.getElementById('modal-subcategory').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function closeSubcategoryModal() {
            document.getElementById('modal-subcategory').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('modal');
            const modalSubcategory = document.getElementById('modal-subcategory');
            if (event.target === modal) {
                closeModal();
            } else if (event.target === modalSubcategory) {
                closeSubcategoryModal();
            }
        }
    </script>
</head>

<body>
    <div class="category-container">
        <h3>Data Kategori</h3>
        <button class="btn" onclick="openModal()">+ Tambah Kategori</button>
        <button class="btn" onclick="openSubcategoryModal()">+ Tambah Subkategori</button>
        <?php foreach ($categories as $category) :  ?>
            <div class="category" onclick="toggleSubcategories(this)">
                <span><i class="fas fa-folder"></i> <?= htmlspecialchars($category['name']) ?></span>
                <span class="actions">
                    <a href="index.php?pages=menu&aksi=editkat&id=<?php echo $category['id']; ?>"">
                        <i class=" fas fa-edit edit" aria-hidden="true"></i>
                    </a>
                    <a href="index.php?pages=menu&aksi=deletekat&id=<?php echo $category['id']; ?>"">
                        <i class=" fas fa-times delete" aria-hidden="true"></i>
                    </a>
                </span>
            </div>
            <div class="subcategory-container">
                <?php foreach ($category['subcategories'] as $subcategory) : ?>
                    <div class="subcategory">
                        <span><i class="fas fa-folder-open"></i> <?= htmlspecialchars($subcategory['name']) ?></span>
                        <span class="actions">
                            <a href="index.php?pages=menu&aksi=editsubkat&id=<?= $subcategory['id']; ?>">
                                <i class="fas fa-edit edit" aria-hidden="true"></i>
                            </a>
                            <a href="index.php?pages=menu&aksi=deletesubkat&id=<?= $subcategory['id']; ?>">
                                <i class="fas fa-times delete" aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="modal" class="modal">
        <?php
        if (isset($_POST['Tambah'])) {
            require_once "proses_tambah.php";
        }

        ?>
        <div class="modal-content">
            <div class="modal-header">
                <h4>Tambah Kategori</h4>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="category-form" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category-name">Nama Kategori</label>
                        <input type="text" id="category-name" name="namakategori" class="form-control" placeholder="Nama Kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="Tambah" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-subcategory" class="modal">
        <div class="modal-content">
            <?php
            if (isset($_POST['Tambahh'])) {
                require_once "proses_tambahh.php";
            }

            ?>
            <div class="modal-header">
                <h4>Tambah Subkategori</h4>
                <span class="close" onclick="closeSubcategoryModal()">&times;</span>
            </div>
            <form id="subcategory-form" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category-select">Pilih Kategori</label>
                        <select id="category-select" name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="subcategory-name">Nama Subkategori</label>
                        <input type="text" id="subcategory-name" name="namasubkategori" class="form-control" placeholder="Nama Subkategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeSubcategoryModal()">Cancel</button>
                    <button type="submit" name="Tambahh" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>