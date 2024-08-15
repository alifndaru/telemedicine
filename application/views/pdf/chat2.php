<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsul :: </title>
    <link href="<?php echo base_url('asset/bootstrap-4.1.3/css/bootstrap.css'); ?>" rel="stylesheet" />
    <script src="<?php echo base_url('asset/bootstrap-4.1.3/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap-4.1.3/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap-4.1.3/popper.min.js'); ?>"></script>

    <style>
        /* table {
            text-align: left;
        }
        table tbody tr th:first-child {
            background-color: blue;
            width: 180px !important;
        }
        table tbody tr td:nth-child(3) {
            background-color: magenta;
            width: 1px !important;
        }
        table tbody tr td:nth-child(4) {
            width: 1px;
            background-color: red;
            text-align: left;
            float: left;
        } */
        table {
            padding-left: 0px;
            border-collapse:collapse;
            margin-left: -4px;
        }
    .style1 {color: #FF0000}
    </style>
</head>
<body>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div>
                            <div class="d-inline-block">
                                <img src="<?php echo base_url('asset/logo/pkbinew.jpg'); ?>" style="height: 70px;">
                            </div>
                            <div class="d-inline-block" style="float: right;">
                                <p class="font-weight-bold mb-1">No. #<?php echo $konsul[0]['id_konsul']; ?></p>
                                <p class="text-muted"><i>Printed: <?php echo date("d-m-Y"); ?></i></p>
                            </div>
                        </div>
                        <br>
                        <div style="text-align: center;">
                            <h3>REKAM MEDIS TELEMEDICINE</h3>
                        </div>
                        <hr class="my-3">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <p class="font-weight-bold mb-3">Profil Klien</p>
                                <table class="table table-borderless table-sm" style="width: 600px;">
                                    <tbody>
                                        <tr>
                                            <td width="100" scope="row">Nama</td>
                                            <td width="4">:</td>
                                            <td width="300"><?php echo $konsul[0]['nama_pasien']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Alamat</td>
                                            <td>:</td>
                                            <td><?php echo $konsul[0]['alamat_pasien']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Jenis Kelamin</td>
                                            <td>:</td>
                                            <td><?php echo $konsul[0]['gender_pasien']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Usia</td>
                                            <td>:</td>
                                            <td ><?php echo $konsul[0]['umur_pasien']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <p class="font-weight-bold mb-3">Profil Provider</p>
                                <table class="table table-borderless table-sm" style="width: 600px;">
                                    <tbody>
                                        <tr>
                                            <td width="100" scope="row">Nama</td>
                                            <td width="4">:</td>
                                            <td width="300"><?php echo $konsul[0]['nama_dokter']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Status</td>
                                            <td>:</td>
                                            <td><?php echo $konsul[0]['jabatan_dokter']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <p class="font-weight-bold mb-3">Profil Daerah</p>
                                <table class="table table-borderless table-sm" style="width: 600px;">
                                    <tbody>
                                        <tr>
                                            <td width="100" scope="row">Nama</td>
                                            <td width="4">:</td>
                                            <td width="300"><?php echo $konsul[0]['klinik']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Alamat</td>
                                            <td>:</td>
                                            <td><?php echo $konsul[0]['alamat_klinik']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <p class="font-weight-bold mb-3">Isian</p>
                                <table class="table table-borderless table-sm" style="width: 600px;">
                                    <tbody>
                                        <tr>
                                            <td width="100" scope="row">Tanggal Konsultasi</td>
                                            <td width="4">:</td>
                                            <td width="300"><?php echo $konsul[0]['tanggal_konsulx']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Keluhan</td>
                                            <td>:</td>
                                            <td><?php echo $konsul[0]['isi_konsul']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row"><span class="style1">Diagnosa (IPES)</span></td>
                                            <td><span class="style1">:</span></td>
                                            <td><span class="style1"><?php echo $konsul[0]['kategori_layananx']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Catatan Dokter</td>
                                            <td>:</td>
                                            <td><?php echo $konsul[0]['catatan_dokter']; ?></td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Rujukan</td>
                                            <td>:</td>
                                            <td>
                                                <?php if ($konsul[0]['rujukan'] !== "") { ?>
                                                    <p><?php echo $konsul[0]['rujukan']; ?></p>
                                                <?php } else { ?>
                                                    <p>-</p>
                                                <?php } ?>                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <div>* Jika kondisi belum membaik, periksakan diri ke dokter terdekat untuk pemeriksaan lebih lanjut.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>