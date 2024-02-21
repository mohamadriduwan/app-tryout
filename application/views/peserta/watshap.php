<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <hr>

    <?= form_error('nisn', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message'); ?>
    <a href="" class="btn btn-success btn-icon-split mb-3 mr-3" data-toggle="modal" data-target="#UploadModal">
        <span class="icon text-white-50">
            <i class="fas fa-upload"></i>
        </span>
        <span class="text">Upload Users</span>
    </a>
    <a href="" class="btn btn-primary btn-icon-split mb-3 mr-3" data-toggle="modal" data-target="#newRoleModal">
        <span class="icon text-white-50">
            <i class="far fa-paper-plane"></i>
        </span>
        <span class="text">Kirim WA</span>
    </a>
    <a href="" class="btn btn-danger btn-icon-split mb-3 mr-3" data-toggle="modal" data-target="#hapusModal">
        <span class="icon text-white-50">
            <i class="fas fa-trash-alt"></i>
        </span>
        <span class="text">Hapus Semua</span>
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
                            <th>TOKEN</th>
                            <th>NISN</th>
                            <th>NAMA SISWA</th>
                            <th>Kelas</th>
                            <th>Asal Sekolah</th>
                            <th>No HP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($pengguna as $us) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td style="width: 150px;"><?= $us['token']; ?></td>
                                <td><?= $us['nisn']; ?></td>
                                <td><?= strtoupper($us['nama']); ?></td>
                                <td><?= $us['kelas']; ?></td>
                                <td><?= strtoupper($us['asal_sekolah']); ?></td>
                                <td><?= $us['no_hp']; ?></td>
                                <td><?= $us['keterangan']; ?></td>
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
                <h5 class="modal-title" id="newRoleModalLabel">Kirim WA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('peserta/kirimWA'); ?>" method="post">
                <div class="modal-body">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="UploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UploadModalLabel">Upload Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('peserta/uploadWatshap') ?>
            <div class="modal-body">
                <a href="<?= base_url('assets/data/template_watshap.xlsx'); ?>" class="btn btn-success btn-icon-split mt-2 mb-2 btn-sm float-right">
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

<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Hapus Semua</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('peserta/HapusWA'); ?>" method="post">
                <div class="modal-body">
                    Yakin menghapus seluruh data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary">Yakin</button>
                </div>
            </form>
        </div>
    </div>
</div>