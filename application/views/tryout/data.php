<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <hr>

    <?= form_error('nisn', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message'); ?>

    <a href="" class="btn btn-primary btn-icon-split mb-3 mr-2" data-toggle="modal" data-target="#newRoleModal">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Add User</span>
    </a>

    <a href="" class="btn btn-success btn-icon-split mb-3" data-toggle="modal" data-target="#UploadModal">
        <span class="icon text-white-50">
            <i class="fas fa-upload"></i>
        </span>
        <span class="text">Upload Users</span>
    </a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data <?= $title; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta-Password</th>
                            <th>NISN</th>
                            <th>NAMA SISWA</th>
                            <th>Kelas</th>
                            <th>Asal Sekolah</th>
                            <th>No HP</th>
                            <th>Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($pengguna as $us) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $us['no_peserta']; ?>-<?= $us['password']; ?></td>
                                <td><?= $us['nisn']; ?></td>
                                <td><?= strtoupper($us['nama']); ?></td>
                                <td><?= $us['kelas']; ?></td>
                                <td><?= strtoupper($us['asal_sekolah']); ?></td>
                                <td><?= $us['no_hp']; ?></td>
                                <td align='center'>
                                    <?php
                                    $pembayaran = $us['pembayaran'];
                                    if ($pembayaran == "0") {
                                        $bayar = "belum.png";
                                    } elseif ($pembayaran == "1") {
                                        $bayar = "lunas.png";
                                    } elseif ($pembayaran == "2") {
                                        $bayar = "gratis.png";
                                    }
                                    ?>

                                    <div></div><img src='<?= base_url('assets/img/stempel/' . $bayar); ?>' height='40px'>

                                <td>
                                    <a href="#" class="btn btn-info btn-icon-split btn-sm" data-toggle="modal" data-target="#editModal<?= $us['id']; ?>">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#deleteModal<?= $us['id']; ?>">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash-alt"></i>
                                        </span>
                                        <span class="text">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('tryout/addUser'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" oninput="numberOnly(this.id);" class="form-control form-control-user" maxlength="10" minlength="10" id="nisn" name="nisn" placeholder="NISN" value="<?= set_value('nisn'); ?>" required>
                        <?= form_error('nisn', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" onkeyup="this.value = this.value.toUpperCase()" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= set_value('nama'); ?>" required>
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <select type="option" class="form-control form-control-user" id="kelas" name="kelas" required>
                            <option value="6" selected="selected">6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="asal_sekolah" name="asal_sekolah" placeholder="Asal Sekolah" value="<?= set_value('asal_sekolah'); ?>" required>
                        <?= form_error('asal_sekolah', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" oninput="numberOnly(this.id);" class="form-control form-control-user" maxlength="20" id="no_hp" name="no_hp" placeholder="Nomor HP" value="<?= set_value('no_hp'); ?>" required>
                        <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<?php $no = 0;
foreach ($pengguna as $us) :
    $no++; ?>
    <div class="modal fade" id="editModal<?= $us['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('tryout/editUser'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                            <?= form_error('no_peserta', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" oninput="numberOnly(this.id);" class="form-control form-control-user" maxlength="10" id="nisn" name="nisn" placeholder="NISN" value="<?= $us['nisn']; ?>">
                            <?= form_error('nisn', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" onkeyup="this.value = this.value.toUpperCase()" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $us['nama']; ?>">
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <select type="option" class="form-control form-control-user" id="kelas" name="kelas">
                                <option value="<?= $us['kelas']; ?>" selected="selected"><?= $us['kelas']; ?></option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="asal_sekolah" name="asal_sekolah" placeholder="Asal Sekolah" value="<?= $us['asal_sekolah']; ?>">
                            <?= form_error('asal_sekolah', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" oninput="numberOnly(this.id);" class="form-control form-control-user" maxlength="20" id="no_hp" name="no_hp" placeholder="Nomor HP" value="<?= $us['no_hp']; ?>">
                            <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php $no = 0;
foreach ($pengguna as $us) : $no++; ?>
    <div class="modal fade" id="deleteModal<?= $us['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url('tryout/deleteUser'); ?>" method="post">
                    <div class="modal-body">
                        <p>Anda yakin untuk menghapus pengguna yang bernama <strong><?= $us['nama']; ?></strong>?</p>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $us['id']; ?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="UploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UploadModalLabel">Upload Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('tryout/uploadUsers') ?>
            <div class="modal-body">
                <a href="<?= base_url('assets/data/template_users.xlsx'); ?>" class="btn btn-success btn-icon-split mt-2 mb-2 btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-download"></i>
                    </span>
                    <span class="text">Download Template</span>
                </a>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="importexcel" name="importexcel">
                    <label class="custom-file-label" for="importexcel">Choose file</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<?php $no = 0;
foreach ($pengguna as $us) :
    $no++; ?>
    <div class="modal fade" id="editBayar<?= $us['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editBayarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBayarLabel">Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('tryout/editBayar'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                            <?= form_error('no_peserta', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" onkeyup="this.value = this.value.toUpperCase()" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= $us['nama']; ?>" readonly>
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <?php
                            if ($us['pembayaran'] == 2) {
                                $massagebayar = "Gratis";
                            } elseif ($us['pembayaran'] == 1) {
                                $massagebayar = "Lunas";
                            } else {
                                $massagebayar = "Belum";
                            }
                            ?>
                            <select type="option" class="form-control form-control-user" id="pembayaran" name="pembayaran">
                                <option value="<?= $us['pembayaran']; ?>" selected="selected"><?= $massagebayar; ?></option>
                                <option value="0">Belum</option>
                                <option value="1">Bayar</option>
                                <option value="2">Gratis</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
    function numberOnly(id) {
        // Get element by id which passed as parameter within HTML element event
        var element = document.getElementById(id);
        // This removes any other character but numbers as entered by user
        element.value = element.value.replace(/[^0-9]/gi, "");
    }
</script>