<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <hr>

    <?= form_error('nisn', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message'); ?>

    <a href="" class="btn btn-primary btn-icon-split mb-3 mr-2" data-toggle="modal" data-target="#newRoleModal">
        <span class="icon text-white-50">
            <i class="fas fa-id-card"></i>
        </span>
        <span class="text">Cetak Banyak</span>
    </a>

    <!-- <a href="" class="btn btn-success btn-icon-split mb-3" data-toggle="modal" data-target="#UploadModal">
        <span class="icon text-white-50">
            <i class="fas fa-upload"></i>
        </span>
        <span class="text">Upload Users</span>
    </a> -->

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
                            <th>ASAL SEKOLAH</th>
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
                                <td><?= strtoupper($us['asal_sekolah']); ?></td>
                                <td>
                                    <center>
                                        <?php if ($us['pembayaran'] == 0) { ?>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editBayar<?= $us['id']; ?>">Belum</button>
                                        <?php  }; ?>
                                        <?php if ($us['pembayaran'] == 1) { ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editBayar<?= $us['id']; ?>">Lunas</button>
                                        <?php  }; ?>
                                        <?php if ($us['pembayaran'] == 2) { ?>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editBayar<?= $us['id']; ?>">Gratis</button>
                                        <?php  }; ?>
                                    </center>
                                </td>
                                <td>
                                    <a href="<?= base_url('peserta/kartu/' . $us['no_peserta']); ?>" target="_blank" class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <span class="text">Cetak</span>
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
                <form action="<?= base_url('peserta/editBayar'); ?>" method="post">
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

<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Cetak Kartu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('peserta/cetakBanyak'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" name="no_pendaftaran1" id="no_pendaftaran1" placeholder="Nomor Awal" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" name="no_pendaftaran2" id="no_pendaftaran2" placeholder="Nomor Akhir" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>