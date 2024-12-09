<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        .ttd {
            position: absolute;
            z-index: -1;
        }

        .sertifikat {
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

        h1 {
            font-size: 60px;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            margin-top: 60px;
        }

        h2 {
            font-size: 20px;
            font-family: "Lucida Console", "Courier New", monospace;
            text-align: center;
            margin-top: -45px;
            margin-bottom: 60px;
        }

        p {
            font-size: 20px;
            font-family: "Lucida Console", "Courier New", monospace;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        h3 {
            font-size: 30px;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            text-align: center;
            margin-top: 5px;
        }

        h4 {
            font-size: 20px;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            text-align: center;
            margin-top: -30px;
            margin-bottom: 0px;
        }

        h5 {
            font-size: 25px;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .tempatttd {
            font-size: 15px;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
        }

        .tempatttd b {
            font-size: 15px;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
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

    <?php if ($siswa['no_peserta']) : ?>
        <?php
        if ($siswa['mapel'] == "umum") {
            $mapel = "Umum";
        }
        if ($siswa['mapel'] == "ipa") {
            $mapel = "IPA";
        }
        if ($siswa['mapel'] == "matematika") {
            $mapel = "Matematika";
        }
        if ($siswa['mapel'] == "bindo") {
            $mapel = "Bhs. Indonesia";
        }
        if ($siswa['mapel'] == "bingg") {
            $mapel = "Bhs. Inggris";
        }
        if ($siswa['mapel'] == "pai") {
            $mapel = "Pendidikan Agama Islam";
        }
        ?>
        <center>
            <img class="sertifikat" src='<?= base_url('assets/img/sertifikat/sertifikat2.png'); ?>' height='705px' Width='1035px'>
        </center>
        <table width='80%' align='center' cellpadding='10' cellspacing="5" border="0">
            <tr>
                <td width='50%' colspan="2">
                    <div style='width:100%;border:0px solid #666;'>
                        <h1>SERTIFIKAT</h1>
                        <h2>P e n g h a r g a a n</h2>
                        <p>Dengan bangga kita berikan kepada :</p>
                        <u>
                            <h3><?= $siswa['nama'] ?></h3>
                        </u>
                        <h4><?= $siswa['asal_sekolah'] ?></h4>
                        <p>Sebagai</p>
                        <h5><?= "Juara " . $mapel . " Ranking " . $siswa['ranking'] ?></h5>
                        <p>Tryout Online Tingkat SD / MI di MTs. Ma'arif Bakung<br>
                            Pada Tanggal 08 Februari 2024</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="tempatttd">
                        <div style="padding-top: 15px; padding-left: 140px;" class="ttd"><img src='<?= base_url('assets/img/ttd/faruq.png'); ?>' height='110px'></div>
                        <br>
                        Mengetahui,<br>
                        Kepala Madrasah,<br><br><br><br><br>
                        <b>FARUQ RIFQI, S.Pd.</b>
                    </div>
                </td>
                <td>
                    <div class="tempatttd">
                        <div style="padding-top: 40px; padding-left: 120px;" class="ttd"><img src='<?= base_url('assets/img/ttd/umi.png'); ?>' height='80px'></div>
                        Blitar, <?= tgl_indo(date('Y-m-d', strtotime('2024-02-08'))); ?><br><br>
                        Ketua Pelaksana,<br><br><br><br><br>
                        <b>UMI LAILATUR RAHMAH, S.Ag</b>
                    </div>
                </td>
            </tr>
        </table>
    <?php endif; ?>
</body>

</html>