<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <title><?php echo $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow">
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="keywords" content="<?php echo $keywords; ?>">
  <meta name="author" content="SarjanaKomedi.com">
  <meta name="robots" content="all,index,follow">
  <meta http-equiv="Content-Language" content="id-ID">
  <meta NAME="Distribution" CONTENT="Global">
  <meta NAME="Rating" CONTENT="General">
  <link rel="canonical" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
  <?php if ($this->uri->segment(1) == 'berita' and $this->uri->segment(2) == 'detail') {
    $rows = $this->model_utama->view_where('berita', array('judul_seo' => $this->uri->segment(3)))->row_array();
    echo '<meta property="og:title" content="' . $title . '" />
         <meta property="og:type" content="article" />
         <meta property="og:url" content="' . base_url() . 'berita/detail/' . $this->uri->segment(3) . '" />
         <meta property="og:image" content="' . base_url() . 'asset/foto_berita/' . $rows['gambar'] . '" />
         <meta property="og:description" content="' . $description . '"/>';
  } ?>
  <link rel="shortcut icon" href="<?php echo base_url(); ?>asset/images/<?php echo favicon(); ?>" />
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss.xml" />
  <link href="<?php echo base_url(); ?>template/<?php echo template(); ?>/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/admin/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>template/<?php echo template(); ?>/<?php echo background(); ?>.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/owl.carousel.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>asset/css/home.css">
  <link rel="stylesheet" href="<?= base_url(); ?>asset/css/provider.css">
  <link rel="stylesheet" href="<?= base_url(); ?>asset/css/list-klinik.css">
  <link rel="stylesheet" href="<?= base_url(); ?>asset/css/list-layanan.css">
  <link rel="stylesheet" href="<?= base_url(); ?>asset/css/konsultasiHostory.css">



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link href="https://unpkg.com/pattern.css" rel="stylesheet">

  <script type="text/javascript">
    function nospaces(t) {
      if (t.value.match(/\s/g)) {
        alert('Maaf, Tidak Boleh Menggunakan Spasi,..');
        t.value = t.value.replace(/\s/g, '');
      }
    }
  </script>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
</head>

<body>
  <div id="top-header">
    <?php include "header-top.php"; ?>
  </div>

  <header id="header" class="header">
    <?php include "header.php"; ?>
  </header>

  <!-- <section style="margin-bottom: 50px;"> -->
  <section>
    <div class="wrapper">
      <?php echo $contents; ?>
    </div>
  </section>

  <footer>
    <?php include "footer.php"; ?>
    <!-- <?php
          if ($this->uri->segment(1) == 'user' || $this->uri->segment(1) == 'konsultasi') { ?>
      <link rel="stylesheet" href="<?php echo base_url(); ?>template/phpmu-ekonseling/footer.css">
    <?php } else {
            include "footer.php";
          }
    ?> -->
  </footer>


  <!-- Jquery and Bootstrap Script files -->
  <script src="<?php echo base_url(); ?>template/<?php echo template(); ?>/js/jquery-2.1.4.js"></script>
  <script src="<?php echo base_url(); ?>template/<?php echo template(); ?>/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url(); ?>asset/js/owl.carousel.min.js"></script>


  <script>
    $(document).ready(function() {
      // carousel 1
      $('.main-slider').owlCarousel({
        animateOut: 'fadeOut',
        items: 1,
        loop: true,
        autoplay: true,
      });

      // carousel 2
      $(".layanan-items").owlCarousel({
        animateOut: 'fadeOut',
        // items:4,
        loop: true,
        autoplay: true,
        nav: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          768: {
            items: 2,
            nav: true
          },
          992: {
            items: 4,
            nav: true,
            loop: false
          }
        }
      });

      $(".doctors").owlCarousel({
        animateOut: 'fadeOut',
        // items:4,
        loop: true,
        autoplay: true,
        nav: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          768: {
            items: 3,
            nav: true
          },
          992: {
            items: 3,
            nav: true,
            loop: false
          }
        }
      });

    });
  </script>
  <script>
    $('.datepicker').datepicker();
    $(function() {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
          $('#back-to-top').fadeIn();
        } else {
          $('#back-to-top').fadeOut();
        }
      });
      // scroll body to 0px on click
      $('#back-to-top').click(function() {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
          scrollTop: 0
        }, 800);
        return false;
      });
      $('#back-to-top').tooltip('show');
    });
  </script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script>
    $(function() {
      $('.textarea').wysihtml5()
    })
  </script>
  <div class="modal fade" id="uploadfoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h5 id="myModalLabel">Ganti Foto Profile anda?</h5>
        </div>
        <center>
          <div class="modal-body">
            <?php
            $attributes = array('class' => 'form-horizontal', 'role' => 'form');
            echo form_open_multipart('user/foto', $attributes); ?>

            <div class="form-group">
              <center style='color:#8a8a8a'>Recomended (200 Kb atau 600 x 600) </center><br>
              <label for="inputEmail3" class="col-sm-3 control-label">Pilih Foto</label>
              <div style='background:#fff;' class="input-group col-sm-7">
                <span class="input-group-addon"><i class='fa fa-image fa-fw'></i></span>
                <input style='text-transform:lowercase;' type="file" class="form-control" name="f">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-1">
                <button type="submit" name='submit' class="btn btn-primary">Update Foto</button>
              </div>
            </div>

            </form>
            <div style='clear:both'></div>
          </div>
        </center>
      </div>
    </div>
  </div>
</body>

</html>