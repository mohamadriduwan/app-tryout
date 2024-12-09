<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <hr>

    <?= form_error('nisn', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message'); ?>

    <a href="" class="btn btn-success btn-icon-split mb-3" data-toggle="modal" data-target="#UploadModal">
        <span class="icon text-white-50">
            <i class="fas fa-upload"></i>
        </span>
        <span class="text">Upload Nilai</span>
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
                            <th>No Peserta</th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Matematika</th>
                            <th>IPA</th>
                            <th>Bhs. Indonesia</th>
                            <th>Bhs. Inggris</th>
                            <th>PAI</th>
                            <th>TOTAL</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($nilai as $us) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $us['no_peserta']; ?></td>
                                <td><?= $us['nama']; ?></td>
                                <td><?= $us['asal_sekolah']; ?></td>
                                <td align="center"><?= $us['matematika']; ?></td>
                                <td align="center"><?= $us['ipa']; ?></td>
                                <td align="center"><?= $us['bindo']; ?></td>
                                <td align="center"><?= $us['bingg']; ?></td>
                                <td align="center"><?= $us['pai']; ?></td>
                                <td align="center"><?= $us['matematika'] + $us['ipa'] + $us['bindo'] + $us['bingg'] + $us['pai']; ?></td>
                                <td align="center"><?= $us['waktu']; ?></td>
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

<div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="UploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UploadModalLabel">Upload Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('tryout/uploadNilai') ?>
            <div class="modal-body">
                <a href="<?= base_url('assets/data/template_nilai.xlsx'); ?>" class="btn btn-success btn-icon-split mt-2 mb-2 btn-sm float-right">
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