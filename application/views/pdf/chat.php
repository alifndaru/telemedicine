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
</head>
<body>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="">
                            <div class="d-inline-block">
                                <img src="<?php echo base_url('asset/logo/medical.png'); ?>" style="height: 70px;">
                            </div>
                            <div class="d-inline-block" style="float: right;">
                                <p class="font-weight-bold mb-1">No. #<?php echo $konsul[0]['id_konsul']; ?></p>
                                <p class="text-muted">Printed: <?php echo date("d-m-Y"); ?></p>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-3">Pasien</p>
                                <p class="mb-1"><?php echo $konsul[0]['nama_pasien']; ?></p>
                                <p><?php echo $konsul[0]['user_id']; ?></p>
                                <p class="mb-1"><?php echo $konsul[0]['alamat_pasien']; ?></p>
                                <p class="mb-1"><?php echo $konsul[0]['telp_pasien']; ?></p>
                            </div>
                        </div>
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-3">Dokter</p>
                                <p class="mb-1"><?php echo $konsul[0]['nama_dokter']; ?></p>
                                <p><?php echo $konsul[0]['dokter']; ?></p>
                                <p class="mb-1"><?php echo $konsul[0]['klinik']; ?></p>
                                <p class="mb-1"><?php echo $konsul[0]['alamat_klinik']; ?></p>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-3">Keluhan</p>
                                <p><?php echo $konsul[0]['isi_konsul']; ?></p>
                                <p class="mb-1 font-italic"><?php echo $konsul[0]['hari_konsul'] . ', ' . $konsul[0]['tanggal_konsulx'] . ' ' . $konsul[0]['jam_konsul']; ?></p>
                            </div>
                        </div>
                        <!-- <hr class="my-3">
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-3">Konsultasi</p>
                                <?php foreach($konsul as $d) { ?>
                                    <?php if ($d['level'] == 'P') { ?>
                                        <p class="mb-1 blockquote-footer">Pasien <span class="font-italic">(<?php echo $d['tanggal_komentarx'] . ' ' . $d['jam_komentar']; ?>)</span></p>
                                    <?php } ?>

                                    <?php if ($d['level'] == 'D') { ?>
                                        <p class="mb-1 blockquote-footer">Dokter <span class="font-italic">(<?php echo $d['tanggal_komentarx'] . ' ' . $d['jam_komentar']; ?>)</span></p>
                                    <?php } ?>
                                    <?php if ($d['type'] == 'file') { ?>
                                        <p><a style="text-decoration: underline;" href="<?php echo base_url('./foto_konsul/') . $d['isi_komentar'] ?>">File</a></p>
                                    <?php } else { ?>
                                        <p><?php echo $d['isi_komentar']; ?></p>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div> -->
                        <hr class="my-3">
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-3">Catatan Dokter</p>
                                <?php if ($konsul[0]['catatan_dokter'] !== "") { ?>
                                    <p><?php echo $konsul[0]['catatan_dokter']; ?></p>
                                <?php } else { ?>
                                    <p>-</p>
                                <?php } ?>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row p-0 mb-4">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-3">Rujukan</p>
                                <?php if ($konsul[0]['rujukan'] !== "") { ?>
                                    <p><?php echo $konsul[0]['rujukan']; ?></p>
                                <?php } else { ?>
                                    <p>-</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>