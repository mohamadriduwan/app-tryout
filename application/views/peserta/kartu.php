<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title; ?> <?= $siswa['no_peserta'] ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        .ttd {
            position: absolute;
            z-index: -1;
        }

        * {
            font-size: x-small;
        }

        .box {
            border: 1px solid #000;
            width: 100%;
            height: 150px;
        }

        .ukuran {
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .ukuran2 {
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .ukuran3 {
            font-size: 25px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .user {
            font-size: 15px;
        }
    </style>
    <?php
    function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }
    ?>
</head>

<body>
    <table width='100%' align='center' cellpadding='10' cellspacing="5" border="1">
        <tr>
            <?php
            $pembayaran = $siswa['pembayaran'];
            ?>
            <?php
            $nopeserta = $siswa['no_peserta'];
            $karakter = strlen($siswa['nama']);
            if ($karakter > 100) {
                $ukuran = "ukuran2";
            } else {
                $ukuran = "ukuran";
            }

            if ($pembayaran == "0") {
                $bayar = "belum.png";
            } elseif ($pembayaran == "1") {
                $bayar = "lunas.png";
            } elseif ($pembayaran == "2") {
                $bayar = "gratis.png";
            }
            ?>

            <td width='50%'>
                <div style='width:100%;border:0px solid #666;'>
                    <table style="text-align:center; width:100%">
                        <tr>
                            <td style="text-align:left; vertical-align:top" width="70px">
                                <img src='<?= base_url('assets/img/lembaga/logo.jpg'); ?>' height='60px'>
                            </td>
                            <td style="text-align:left">
                                <b class="ukuran">
                                    <?= strtoupper("TRYOUT MASAMA") ?><BR>
                                    <?= strtoupper("MTS. MA'ARIF BAKUNG") ?><BR>
                                    TAHUN PELAJARAN 2024-2025
                                </b>
                            </td>
                            <td class="ukuran" style="text-align:right; vertical-align:top">
                                User-Password :<br>
                                <b class="ukuran3"><?= $siswa['no_peserta'] ?>-<?= $siswa['password'] ?></b>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table style="text-align:left; width:100%">
                        <tr>
                            <td class="ukuran" valign='top' width="130px">Nama</td>
                            <td class="ukuran" valign='top' width="5px">:</td>
                            <td class="<?= $ukuran; ?>" valign='top' colspan="2"><b class="ukuran"><?= $siswa['nama'] ?><b></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>NISN</td>
                            <td class="ukuran" valign='top'>:</td>
                            <td class="ukuran" valign='top' colspan="2"><?= $siswa['nisn'] ?></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>Asal Sekolah</td>
                            <td class="ukuran" valign='top'>:</td>
                            <td class="ukuran" valign='top' colspan="2"><?= $siswa['asal_sekolah'] ?></td>
                        </tr>
                        <tr>

                            <td class="ukuran" valign='top'>No HP</td>
                            <td class="ukuran" valign='top'>:</td>
                            <td class="ukuran" valign='top' colspan="2"><?= $siswa['no_hp'] ?></td>

                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'></td>
                            <td class="ukuran" valign='top'></td>
                            <td class="ukuran" valign='top' colspan="2">
                                <div style="padding-top: 32px; padding-left: 330px;" class="ttd"><img src='<?= base_url('assets/img/ttd/umi.png'); ?>' height='40px'></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ukuran" valign='top' colspan="3">
                                <div style="padding-top: 10px;" align='center'><img src='<?= base_url('assets/img/stempel/' . $bayar); ?>' height='60px'></div>
                            </td>
                            <td class="ukuran2" valign='top' align='center' width="300px">
                                Blitar, <?= tgl_indo(date('Y-m-d', strtotime($siswa['date_created']))); ?><br>
                                Ketua Panitia<br><br>
                                <br>
                                <b>UMI LAILATURRAHMA, S.Ag.</b><br>
                                <b></b>

                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr>

        </tr>
    </table>
</body>

</html>