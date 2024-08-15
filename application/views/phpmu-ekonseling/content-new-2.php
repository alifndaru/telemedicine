<!-- SLIDER -->
<div id="slider" class="row">
    <div class="wrapper">
        <div class="slider">
            <?php foreach ($sliders as $slider) { ?>
                <div class="slide">
                    <div class="slider-image">
                        <img src="<?= base_url('asset/foto_slider/') . '/' . $slider['image']; ?>" alt="">
                    </div>
                    <div class="slider-content">
                        <h3>Konsultasi secara pribadi terjamin kerahasiaan informasi pribadi dan keamanan data klien</h3>
                        <a href="<?php echo base_url('user/tambah-konsultasi'); ?>" class="consult-btn"><i class="fa fa-comments"></i> KONSULTASI</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- END SLIDER -->

<!-- ABOUT ME -->
<section>
    <div class="wrapper wrapper-aboutme container">
        <div class="about-info">
            <p>PKBIcare adalah salah satu layanan konsultasi online yang dipersembahkan oleh PKBI. Layanan ini dirancang untuk masyarakat yang memiliki keterbatasan waktu dan jarak (tanpa kasus darurat) agar tetap bisa mendapatkan layanan konseling dan konsultasi yang dibutuhkan, terutama di bidang kesehatan reproduksi.</p>
            <p>PKBIcare dikelola oleh seluruh daerah PKBI di 25 provinsi di seluruh Indonesia. Pasien/Klien akan ditangani oleh para provider handal yang dimiliki oleh PKBI, seperti dokter, bidan, dan konselor yang berpengalaman menangani Pasien/Klien di klinik statis di lokasi tugas mereka.</p>
            <p>PKBIcare menyediakan fitur chat konsultasi yang interaktif dan diharapkan dapat memudahkan klien mendapatkan informasi yang cepat dan tepat dari para provider yang ada. Klien juga bisa mendapatkan catatan medis dari hasil konsultasi tersebut.</p>
            <p>Semoga PKBIcare dapat menjadi salah satu solusi masyarakat Indonesia untuk semakin mudah mendapatkan layanan Kesehatan dari PKBI kapanpun dan dimanapun berada.</p>
        </div>
    </div>
</section>

<!-- END ABOUT ME -->

<!-- layanan -->
<section class="wrapper cards-section">
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-user-md"></i>
        </div>
        <a href="<?php echo base_url('psikolog/lists'); ?>" class="card-content">
            <h2><?= $total_doctors; ?></h2>
            <p>TENAGA PROFESIONAL dan TERPERCAYA</p>
        </a>
    </div>
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="card-content">
            <h2><?= $total_kategori_layanan ?></h2>
            <p>LAYANAN KESPRO SESUAI STANDAR WHO</p>
        </div>
    </div>
    <div class="card">
        <div class="card-icon">
            <i class="fas fa-map-marked-alt"></i>
        </div>
        <a href="<?php echo base_url('list-klinik'); ?>" class="card-content">
            <h2><?= $total_kliniks; ?></h2>
            <p>LOKASI DI SELURUH WILAYAH INDONESIA</p>
        </a>
    </div>
</section>

<!-- end layanan -->

<!-- banner konsultasi -->
<section class="wrapper consultation-section">
    <div class="consultation-container">
        <div class="consultation-image">
            <img src="<?= base_url(); ?>asset/images/news-image2.jpg" alt="Consultation Image">
        </div>
        <div class="consultation-content">
            <h2>DAPATKAN SOLUSI DARI TENAGA PROFESIONAL KAMI</h2>
            <h3>Konsultasi dengan</h3>
            <img src="<?= base_url(); ?>asset/logo/logo_telemedicine_(1)1.png" alt="Logo" class="consultation-logo">
            <a href="<?php echo base_url('user/tambah-konsultasi'); ?>" class="consult-btn"><i class="fa fa-comments"></i> KONSULTASI SEKARANG </a>
        </div>
    </div>
</section>
<!-- end banner konsultasi -->


<!-- tenaga profesional -->

<section>
    <div class="slider-container-tenagakerja">
        <div class="slider-tenagakerja" id="slider-tenagakerja">
            <?php foreach ($doctors as $dok) { ?>
                <div class="slide-tenagakerja">
                    <img src="<?= base_url("asset/foto_user") . '/' . $dok['foto']; ?>" class="img-responsive" alt="">
                    <div class="content-tenagakerja">
                        <h3><?= $dok['nama_lengkap']; ?></h3>
                        <p class="dokter-umum"><?= $dok['jabatan']; ?></p>
                        <p class="klinik-mitra">Klinik Mitra Sehat Sejahtera PKU Cabang Tegal</p>
                        <a href="<?php echo base_url('user/tambah-konsultasi'); ?>" class="consult-btn"><i class="fa fa-comments"></i> KONSULTASI</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- end tenaga profesional -->



<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentIndex = 0;
        const slides = document.querySelectorAll(".slide-tenagakerja");
        const totalSlides = slides.length;

        function moveToNextSlide() {
            if (currentIndex < totalSlides - 1) {
                currentIndex++;
            } else {
                currentIndex = 0; // Kembali ke slide pertama
            }
            updateSlidePosition();
        }

        function moveToPrevSlide() {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = totalSlides - 1; // Pindah ke slide terakhir
            }
            updateSlidePosition();
        }

        function updateSlidePosition() {
            const slider = document.getElementById("slider-tenagakerja");
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Tambahkan event listeners untuk navigasi Anda di sini
        // Contoh: document.querySelector('.next-btn').addEventListener('click', moveToNextSlide);
        // Contoh: document.querySelector('.prev-btn').addEventListener('click', moveToPrevSlide);
    });


    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.querySelector('.slider');
        let index = 0;

        function slide() {
            index++;
            if (index >= slider.children.length) {
                index = 0;
            }
            slider.scrollTo({
                left: slider.clientWidth * index,
                behavior: 'smooth'
            });
        }

        setInterval(slide, 3000); // Berpindah setiap 3 detik
    });
</script>