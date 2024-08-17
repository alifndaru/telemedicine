<!-- Slider -->
<div id="slider" class="row">
    <div class="wrapper container">
        <div class="main-slider owl-carousel owl-theme">
            <?php $no = 1;
            foreach ($sliders as $slider) { ?>
                <div class="item" style='background-image: url("<?= base_url('asset/foto_slider/') . '/' . $slider['image']; ?>"); height: 467px; background-size: cover;'>
                    <div class="caption">
                        <div class="col-md-offset-1 col-md-10">
                            <h3><?= $slider['sub_title']; ?></h3>
                            <h1><?= $slider['title']; ?></h1>
                            <!-- <a href="#team" class="section-btn btn btn-default smoothScroll">Meet Our Doctors</a> -->
                        </div>
                    </div>
                </div>
            <?php $no++;
            } ?>
        </div>
    </div>
</div>

<!-- Welcome -->


<!-- Layanan -->
<div id="layanan" class="row pt-2">
    <div class="wrapper container">
        <div class="col-md-6 col-sm-6">
            <div class="about-info">
                <h2 class="wow fadeInUp" data-wow-delay="0.1s">Menu Pilihan</h2>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="layanan-items owl-carousel owl-theme">

            <div class="col-md-12 col-sm-12">
                <a href="<?php echo base_url('user/tambah-konsultasi'); ?>">
                    <div class="team-thumb thumbnail wow fadeInUp" data-wow-delay="0.6s">
                        <img src="<?php echo base_url("asset/icon/konsultasi_icon.png"); ?>" class="img-responsive" alt="">
                        <div class="team-info">
                            <div class="team-contact-info text-center">
                                <h3>Konsultasi<br>Online</h3>
                                <!-- <p>Cardiology</p> -->
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Doctors -->
            <div class="col-md-12 col-sm-12">
                <a href="<?php echo base_url('provider/lists'); ?>">
                    <div class="team-thumb thumbnail wow fadeInUp" data-wow-delay="0.2s">
                        <img src="<?php echo base_url("asset/icon/provider_icon.png"); ?>" class="img-responsive" alt="">
                        <div class="team-info">
                            <div class="team-contact-info text-center">
                                <h3><?= count($doctors); ?><br>Provider</h3>
                                <!-- <p><button class="btn btn-success btn-sm">Know more</button></p> -->
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-md-12 col-sm-12">
                <a href="<?php echo base_url('list-layanan'); ?>">
                    <div class="team-thumb thumbnail wow fadeInUp" data-wow-delay="0.4s">
                        <img src="<?php echo base_url("asset/icon/ipes_icon.png"); ?>" class="img-responsive" alt="">
                        <div class="team-info">
                            <div class="team-contact-info text-center">
                                <h3><?= count($kategori_layanan); ?><br>Layanan IPES</h3>
                                <!-- <p>Pregnancy</p> -->
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-12 col-sm-12">
                <a href="<?php echo base_url('list-klinik'); ?>">
                    <div class="team-thumb thumbnail wow fadeInUp" data-wow-delay="0.6s">
                        <img src="<?php echo base_url("asset/icon/location_icon.png"); ?>" class="img-responsive" alt="">
                        <div class="team-info">
                            <div class="team-contact-info text-center">
                                <h3><?= count($kliniks); ?><br>Daerah</h3>
                                <!-- <p>Cardiology</p> -->
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>
</div>

<!-- Doctors -->
<div id="team" class="row">
    <div class="wrapper container">
        <div class="col-md-6 col-sm-6">
            <div class="about-info">
                <h2 class="wow fadeInUp" data-wow-delay="0.1s">Provider Kami - <a href="<?php echo base_url('provider/lists'); ?>" class="btn btn-sm btn-warning">Selebihnya <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></h2>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="doctors owl-carousel owl-theme">
            <?php foreach ($doctors as $dok) { ?>
                <div class="col-md-12 col-sm-12">
                    <div class="team-thumb wow fadeInUp" data-wow-delay="0.2s">
                        <img src="<?php echo base_url("asset/foto_user") . '/' . $dok['foto']; ?>" class="img-responsive" alt="">
                        <div class="team-info">
                            <h3><?php echo $dok['nama_lengkap']; ?></h3>
                            <p><?php echo $dok['jabatan']; ?></p>
                            <div class="team-contact-info">
                                <p>
                                    <a href="<?php echo base_url('user/tambah-konsultasi'); ?>" class="btn btn-sm btn-success">
                                        Konsultasi <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                                    </a>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>







<!-- <div>
    <section class="row" id="google-map">
        <div class="wrapper container">
            <div class="col-md-12">
                <iframe class="thumbnail" src="<?php echo (isset($identitas[0]['maps'])) ? $identitas[0]['maps'] : ""; ?>" width="100%" height="350" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </section>
</div> -->