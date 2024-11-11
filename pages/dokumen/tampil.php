<div class="content">
    <div class="mt-4">
        <div class="row g-4">
            <div class="col-12 col-xl-10 order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card">
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor">Dokumen</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="collapse code-collapse" id="example-code">
                            </div>
                            <div class="p-4 code-to-copy">
                                <div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                    <div class="table-responsive">
                                        <table class="table table-sm fs--1 mb-0">
                                            <div class="d-flex flex-wrap gap-3 px-4 px-lg-3 py-3">
                                                <a class="btn btn-primary px-3 px-sm-5 px-md-10" href="index.php?pages=dokumen&aksi=tambah">
                                                    <span class="fas fa-plus me-2"></span>Tambah
                                                </a>
                                                <!-- Filter Kategori -->
                                                <select id="filterKategori" class="form-select">
                                                    <option value="">Semua Kategori</option>
                                                    <?php
                                                    // Menampilkan daftar kategori dari database
                                                    $KATEGORI = user_tampil("SELECT * FROM kategori ORDER BY kategori ASC");
                                                    foreach ($KATEGORI as $KAT) {
                                                        echo "<option value='" . htmlspecialchars($KAT['kategori']) . "'>" . htmlspecialchars($KAT['kategori']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <thead>
                                                <tr>
                                                    <th class="sort border-top ps-3" data-sort="name">No</th>
                                                    <th class="sort border-top" data-sort="level">Nama Dokumen</th>
                                                    <th class="sort border-top ps-3" data-sort="photo">Keterangan</th>
                                                    <th class="sort border-top ps-3" data-sort="username">Kategori</th>
                                                    <th class="sort border-top" data-sort="email">Size</th>
                                                    <th class="sort border-top" data-sort="level">Upload Date</th>

                                                    <th class="sort text-end align-middle pe-0 border-top" scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="dokumenTbody">
                                                <?php
                                                require_once '../inc/function.php';
                                                $TAMPIL = user_tampil("SELECT dokumen.*, kategori.kategori AS nama_kategori FROM dokumen LEFT JOIN kategori ON dokumen.kategori = kategori.kat_id ORDER BY dokumen.doc_id ASC");

                                                $NO = 1;
                                                foreach ($TAMPIL as $DATA) :
                                                ?>
                                                    <tr class="dokumen-row" data-kategori="<?= htmlspecialchars($DATA['nama_kategori']); ?>">
                                                        <td class="align-middle ps-3 name"><?php echo $NO; ?></td>
                                                        <td class="align-middle age"><?= $DATA['judul']; ?></td>
                                                        <td class="align-middle age"><?= $DATA['deskripsi']; ?></td>
                                                        <td class="align-middle age"><?= htmlspecialchars($DATA['nama_kategori']); ?></td>
                                                        <td class="align-middle age"><?= $DATA['size']; ?></td>
                                                        <td class="align-middle age"><?= $DATA['upload_date']; ?></td>

                                                        <td class="align-middle white-space-nowrap text-end pe-0">
                                                            <div class="font-sans-serif btn-reveal-trigger position-static">
                                                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                                    <span class="fas fa-ellipsis-h fs--2"></span>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                                    <a class="dropdown-item" href="index.php?pages=dokumen&aksi=edit&id=<?php echo $DATA['doc_id']; ?>">edit</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-primary" href="">download</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-danger" href="index.php?pages=dokumen&aksi=delete&id=<?php echo $DATA['doc_id']; ?>">delete</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $NO++;
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex flex-between-center pt-3">
                                        <div class="pagination d-none"></div>
                                        <p class="mb-0 fs--1">
                                            <span class="d-none d-sm-inline-block" data-list-info="data-list-info"></span>
                                            <span class="d-none d-sm-inline-block"> &mdash; </span>
                                            <a class="fw-semi-bold" href="#!" data-list-view="*">
                                                View all
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">
                                                View Less
                                                <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                            </a>
                                        </p>
                                        <div class="d-flex">
                                            <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev"><span>Previous</span></button>
                                            <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('filterKategori').addEventListener('change', function() {
        const selectedKategori = this.value.toLowerCase();
        const rows = document.querySelectorAll('.dokumen-row');

        rows.forEach(row => {
            const rowKategori = row.getAttribute('data-kategori').toLowerCase();
            if (selectedKategori === "" || rowKategori === selectedKategori) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>