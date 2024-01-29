<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Content Row -->
    <?php if ($nilaiUmum) : ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Juara Umum</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta </th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai</th>
                            <th>Ranking</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($nilaiUmum as $us) : ?>
                            <?php $urut = $no++; ?>
                            <?php if ($urut < 4) : ?>
                                <tr>
                                    <td> <?= $urut; ?></td>
                                    <td><?= $us['no_peserta']; ?></td>
                                    <td><?= $us['nama']; ?></td>
                                    <td><?= $us['asal_sekolah']; ?></td>
                                    <td align="center"><?= $us['total']; ?></td>
                                    <td align="center"><?= $urut; ?></td>
                                    <td align="center"><?= date('h:i:s', strtotime($us['waktu'])); ?></td>
                                    <td align="center">
                                        <form action="<?= base_url('peserta/sertifikat'); ?>" method="post">
                                            <input type="hidden" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                                            <input type="hidden" id="nama" name="nama" value="<?= $us['nama']; ?>" readonly>
                                            <input type="hidden" id="asal_sekolah" name="asal_sekolah" value="<?= $us['asal_sekolah']; ?>" readonly>
                                            <input type="hidden" id="ranking" name="ranking" value="<?= $urut; ?>" readonly>
                                            <input type="hidden" id="mapel" name="mapel" value="umum" readonly>
                                            <button type="submit" href="" class="btn btn-info btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-id-card"></i>
                                                </span>
                                                <span class="text">Cetak</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $umum[] = $us['no_peserta']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php
                $a = 1;
                foreach ($nilaiUmum as $us) : ?>
                    <?php if ($us['no_peserta']) : ?>

                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if ($nilaiMatematika) : ?>
        <!-- Approach -->
        <?php $no = 1; ?>
        <?php foreach ($nilaiMatematika as $us) : ?>
            <?php if (!in_array($us['no_peserta'], $umum)) : ?>
                <?php $urut = $no++; ?>
                <?php if ($urut < 4) : ?>
                    <?php $mat[] = $us; ?>
                    <?php $mat2[] = $us['no_peserta']; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Juara Matematika</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta</th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai</th>
                            <th>Ranking</th>
                            <th>waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($mat as $us) : ?>
                            <?php $urutan = $no++; ?>
                            <tr>
                                <td> <?= $urutan; ?></td>
                                <td><?= $us['no_peserta']; ?></td>
                                <td><?= $us['nama']; ?></td>
                                <td><?= $us['asal_sekolah']; ?></td>
                                <td align="center"><?= $us['matematika']; ?></td>
                                <td align="center"><?= $urutan; ?></td>
                                <td align="center"><?= date('h:i:s', strtotime($us['waktu'])); ?></td>
                                <td align="center">
                                    <form action="<?= base_url('peserta/sertifikat'); ?>" method="post">
                                        <input type="hidden" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                                        <input type="hidden" id="nama" name="nama" value="<?= $us['nama']; ?>" readonly>
                                        <input type="hidden" id="asal_sekolah" name="asal_sekolah" value="<?= $us['asal_sekolah']; ?>" readonly>
                                        <input type="hidden" id="ranking" name="ranking" value="<?= $urutan; ?>" readonly>
                                        <input type="hidden" id="mapel" name="mapel" value="matematika" readonly>
                                        <button type="submit" href="" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>

                <?php
                $juara1 = array_merge($umum, $mat2); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($nilaiIpa) : ?>
        <!-- Approach -->
        <?php $no = 1; ?>
        <?php foreach ($nilaiIpa as $us) : ?>
            <?php if (!in_array($us['no_peserta'], $juara1)) : ?>
                <?php $urut = $no++; ?>
                <?php if ($urut < 4) : ?>
                    <?php $ipa[] = $us; ?>
                    <?php $ipa2[] = $us['no_peserta']; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Juara IPA</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta</th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai</th>
                            <th>Ranking</th>
                            <th>waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($ipa as $us) : ?>
                            <?php $urutan = $no++; ?>
                            <tr>
                                <td> <?= $urutan; ?></td>
                                <td><?= $us['no_peserta']; ?></td>
                                <td><?= $us['nama']; ?></td>
                                <td><?= $us['asal_sekolah']; ?></td>
                                <td align="center"><?= $us['ipa']; ?></td>
                                <td align="center"><?= $urutan; ?></td>
                                <td align="center"><?= date('h:i:s', strtotime($us['waktu'])); ?></td>
                                <td align="center">
                                    <form action="<?= base_url('peserta/sertifikat'); ?>" method="post">
                                        <input type="hidden" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                                        <input type="hidden" id="nama" name="nama" value="<?= $us['nama']; ?>" readonly>
                                        <input type="hidden" id="asal_sekolah" name="asal_sekolah" value="<?= $us['asal_sekolah']; ?>" readonly>
                                        <input type="hidden" id="ranking" name="ranking" value="<?= $urutan; ?>" readonly>
                                        <input type="hidden" id="mapel" name="mapel" value="ipa" readonly>
                                        <button type="submit" href="" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>

                <?php
                $juara2 = array_merge($ipa2, $juara1); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($nilaiBindo) : ?>
        <!-- Approach -->
        <?php $no = 1; ?>
        <?php foreach ($nilaiBindo as $us) : ?>
            <?php if (!in_array($us['no_peserta'], $juara1)) : ?>
                <?php $urut = $no++; ?>
                <?php if ($urut < 4) : ?>
                    <?php $bindo[] = $us; ?>
                    <?php $bindo2[] = $us['no_peserta']; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Juara Bhs. Indonesia</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta</th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai</th>
                            <th>Ranking</th>
                            <th>waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($bindo as $us) : ?>
                            <?php $urutan = $no++; ?>
                            <tr>
                                <td> <?= $urutan; ?></td>
                                <td><?= $us['no_peserta']; ?></td>
                                <td><?= $us['nama']; ?></td>
                                <td><?= $us['asal_sekolah']; ?></td>
                                <td align="center"><?= $us['bindo']; ?></td>
                                <td align="center"><?= $urutan; ?></td>
                                <td align="center"><?= date('h:i:s', strtotime($us['waktu'])); ?></td>
                                <td align="center">
                                    <form action="<?= base_url('peserta/sertifikat'); ?>" method="post">
                                        <input type="hidden" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                                        <input type="hidden" id="nama" name="nama" value="<?= $us['nama']; ?>" readonly>
                                        <input type="hidden" id="asal_sekolah" name="asal_sekolah" value="<?= $us['asal_sekolah']; ?>" readonly>
                                        <input type="hidden" id="ranking" name="ranking" value="<?= $urutan; ?>" readonly>
                                        <input type="hidden" id="mapel" name="mapel" value="bindo" readonly>
                                        <button type="submit" href="" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>

                <?php
                $juara3 = array_merge($bindo2, $juara2); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($nilaiBingg) : ?>
        <!-- Approach -->
        <?php $no = 1; ?>
        <?php foreach ($nilaiBingg as $us) : ?>
            <?php if (!in_array($us['no_peserta'], $juara3)) : ?>
                <?php $urut = $no++; ?>
                <?php if ($urut < 4) : ?>
                    <?php $bingg[] = $us; ?>
                    <?php $bingg2[] = $us['no_peserta']; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Juara Bhs. Inggris</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta</th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai</th>
                            <th>Ranking</th>
                            <th>waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($bingg as $us) : ?>
                            <?php $urutan = $no++; ?>
                            <tr>
                                <td> <?= $urutan; ?></td>
                                <td><?= $us['no_peserta']; ?></td>
                                <td><?= $us['nama']; ?></td>
                                <td><?= $us['asal_sekolah']; ?></td>
                                <td align="center"><?= $us['bingg']; ?></td>
                                <td align="center"><?= $urutan; ?></td>
                                <td align="center"><?= date('h:i:s', strtotime($us['waktu'])); ?></td>
                                <td align="center">
                                    <form action="<?= base_url('peserta/sertifikat'); ?>" method="post">
                                        <input type="hidden" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                                        <input type="hidden" id="nama" name="nama" value="<?= $us['nama']; ?>" readonly>
                                        <input type="hidden" id="asal_sekolah" name="asal_sekolah" value="<?= $us['asal_sekolah']; ?>" readonly>
                                        <input type="hidden" id="ranking" name="ranking" value="<?= $urutan; ?>" readonly>
                                        <input type="hidden" id="mapel" name="mapel" value="bingg" readonly>
                                        <button type="submit" href="" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>

                <?php
                $juara4 = array_merge($bingg2, $juara3); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($nilaiPai) : ?>
        <!-- Approach -->
        <?php $no = 1; ?>
        <?php foreach ($nilaiPai as $us) : ?>
            <?php if (!in_array($us['no_peserta'], $juara4)) : ?>
                <?php $urut = $no++; ?>
                <?php if ($urut < 4) : ?>
                    <?php $pai[] = $us; ?>
                    <?php $bpai2[] = $us['no_peserta']; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Juara PAI</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Peserta</th>
                            <th>NAMA SISWA</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai</th>
                            <th>Ranking</th>
                            <th>waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pai as $us) : ?>
                            <?php $urutan = $no++; ?>
                            <tr>
                                <td> <?= $urutan; ?></td>
                                <td><?= $us['no_peserta']; ?></td>
                                <td><?= $us['nama']; ?></td>
                                <td><?= $us['asal_sekolah']; ?></td>
                                <td align="center"><?= $us['pai']; ?></td>
                                <td align="center"><?= $urutan; ?></td>
                                <td align="center"><?= date('h:i:s', strtotime($us['waktu'])); ?></td>
                                <td align="center">
                                    <form action="<?= base_url('peserta/sertifikat'); ?>" method="post">
                                        <input type="hidden" id="no_peserta" name="no_peserta" value="<?= $us['no_peserta']; ?>" readonly>
                                        <input type="hidden" id="nama" name="nama" value="<?= $us['nama']; ?>" readonly>
                                        <input type="hidden" id="asal_sekolah" name="asal_sekolah" value="<?= $us['asal_sekolah']; ?>" readonly>
                                        <input type="hidden" id="ranking" name="ranking" value="<?= $urutan; ?>" readonly>
                                        <input type="hidden" id="mapel" name="mapel" value="pai" readonly>
                                        <button type="submit" href="" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-id-card"></i>
                                            </span>
                                            <span class="text">Cetak</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>

                <?php
                $juara4 = array_merge($bingg2, $juara3); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
</div>