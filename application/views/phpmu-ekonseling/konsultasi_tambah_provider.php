<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">
<link rel="stylesheet" href="<?= base_url(); ?>asset/css/konsultasiHostory.css">

<?php
// Fetch user data
$usr = $this->db->query("SELECT * FROM users WHERE username='" . $this->session->username . "'")->row_array();
?>
<!-- HTML -->
<div id="tambah-konsultasi" class="container" style="margin-top: 30px;">
  <div class="row content-wrapper-history">
    <div class="col-xs-12 col-md-8 one">
      <div class="wizard clearfix">
        <div class="wizard-inner">
          <div class="connecting-line"></div>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab"></span> <i>Pilih Provider</i></a>
            </li>
            <li role="presentation" class="disabled">
              <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"></span> <i>Pembayaran</i></a>
            </li>
            <li role="presentation" class="disabled">
              <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab"></span> <i>Validasi</i></a>
            </li>
            <li role="presentation" class="disabled">
              <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab"></span> <i>Mulai Konsultasi</i></a>
            </li>
          </ul>
        </div>

        <!-- Form for selecting province, clinic, and doctor -->
        <div class="tab-content" id="main_form">
          <div class="tab-pane active" role="tabpanel" id="step1">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-left text-primary">Konsultasi > Beranda</h4>
                <hr class="custom-hr">
                <!-- Select Province -->
                <div class="form-group">
                  <label class="col-sm-3 control-label pl-0 text-primary">Provinsi</label>
                  <div class="col-sm-9 mb-10">
                    <v-select
                      :disabled="disops.provinsi"
                      label="provinsi"
                      placeholder="Pilih Provinsi"
                      v-model="provinsi"
                      :reduce="provinsi => provinsi.id"
                      :options="provinsi_options"
                      @search="fetchOptionsProvinsi"
                      @input="selectedOptionProvinsi">
                      <span slot="no-options">Silahkan Ketikan Nama Daerah</span>
                    </v-select>
                    <input type="hidden" v-model="provinsi" name="prov_klinik">
                  </div>
                </div>

                <!-- Select Clinic -->
                <div class="form-group">
                  <label class="col-sm-3 control-label pl-0 text-primary">Klinik</label>
                  <div class="col-sm-9 mb-10">
                    <v-select
                      :disabled="disops.klinik"
                      label="klinik"
                      v-model="klinik"
                      placeholder="Pilih Klinik"
                      :reduce="klinik => klinik.id"
                      :options="klinik_options"
                      @search="fetchOptionsKlinik"
                      @input="selectedOptionKlinik">
                    </v-select>
                    <input type="hidden" v-model="klinik" name="klinik">
                  </div>
                </div>

                <!-- Display Available Doctors -->
                <div v-if="dokter_options.length > 0" class="form-group">
                  <div class="row d-flex">
                    <label class="col-sm-3 my-auto text-primary">PILIH PROVIDER</label>
                    <hr class="col-sm-9 custom-hr text-primary" />
                  </div>
                  <div class="col-sm-12 mb-10">
                    <div class="row">
                      <div class="col-md-2 p-0">
                        <label for="" class="text-primary">Provider</label>
                      </div>
                      <div class="col-md-10">
                        <div class="dokter-item mb-5" v-for="dokter in dokter_options" :key="dokter.id">
                          <img :src="dokter.foto_dokter ? `${baseUrl}asset/foto_user/${dokter.foto_dokter}` : `${baseUrl}asset/foto_user/blank.png`" alt="Foto Dokter" class="foto-dokter mr-8">
                          <div class="dokter-info">
                            <h5 class="text-primary">{{ dokter.dokter }}</h5>
                            <p class="text-primary">{{ dokter.jabatan }} di {{ dokter.klinik }}</p>
                            <p class="text-primary">{{ dokter.spesialis }}</p>
                            <template v-if="dokter.kuota.length > 0">
                              <div v-for="(kuota, index) in dokter.kuota" :key="index" class="col-md-12">
                                <label class="radio">
                                  <input type="radio"
                                    :name="selected_kuota"
                                    :value="index"
                                    v-model="selected_kuota[dokter.id]"
                                    @change="handleKuotaChange(dokter, index)">
                                  <table>
                                    <tr>
                                      <td class="text-primary">{{ dokter.tstart[index].split(':').slice(0, 2).join(':') }} - {{ dokter.tend[index].split(':').slice(0, 2).join(':') }} </td>
                                      <td class="text-primary">&nbsp;WIB |</td>
                                      <td><span class="text-danger">&nbsp;Kuota: {{ kuota }}</span></td>
                                      <td class=`tarif-${dokter}` style="display: none;">{{ dokter.biaya_tarif[index] | currency }}</td>
                                    </tr>
                                  </table>
                                </label>
                            </template>
                            </template>
                            <p v-else>Kuota: Tidak tersedia</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-5">
                <!-- Payment Details -->
                <div v-if="Object.keys(selected_kuota).length > 0" class="form-group">
                  <div v-if="biaya_tarif" class="bg-danger p-4 radius-5">
                    <h3 class="text-white mb-0">Tarif Layanan Konsultasi {{ formatCurrency(biaya_tarif) }}</h3>
                  </div>
                </div>
              </div>
            </div>
            <ul class="list-inline pull-right">
              <li><button type="button" class="btn btn-primary next-step">SELANJUTNYA</button></li>
            </ul>
          </div>
          <div class="tab-pane" role="tabpanel" id="step2">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-left text-primary">Pembayaran</h4>
                <hr class="custom-hr">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <table class="table table-responsive table-payment">
                      <tbody>
                        <tr>
                          <td><b class="text-info">Tarif Layanan</b></td>
                          <td><b class="text-info">{{ formatCurrency(biaya_tarif) }}</b></td>
                        </tr>
                        <tr v-if="discount > 0">
                          <td><b class="text-info">Potongan</b> <b class="text-warning">{{discount}}%</b></td>
                          <td><b class="text-warning">- {{formatCurrency(discountAmount)}}</b></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>
                            <hr style="margin-top: 0px; margin-left: 0px">
                          </td>
                        </tr>
                        <tr>
                          <td><b class="text-danger">Total Bayar</b></td>
                          <td><b class="text-danger">{{ formatCurrency(total_biaya) }}</b></td>
                        </tr>
                        </thead>
                    </table>
                    <div class="d-flex">
                      <span class="text-info mr-5" style="white-space: nowrap;"><b>Metode Bayar</b></span>
                      <div>
                        <span>Transfer via Rekening</span><br>
                        <span class="text-info" style="font-size: 14px;"><b>Metode Pembayaran</b></span><br>
                        <p class="text-info" style="font-size: 14px;">
                          Bank: {{ bank }}<br>
                          No. Rekening: {{ rekening }}<br>
                          Atas Nama: {{ atas_nama }}
                        </p>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="text-info mr-5" class="form-control" style="white-space: nowrap;"><b>Bukti Bayar</b></div>
                      <input type="file" class="mr-2 form-control" name="image" accept="image/png, image/jpeg, image/jpg">
                    </div>

                  </div>
                  <div class="col-sm-12 col-md-6">
                    <!-- Voucher Input -->
                    <div class="form-group">
                      <label class="control-label text-info" style="white-space: nowrap;">Masukkan Voucher</label>
                      <div class="d-flex">
                        <input type="text" id="kode_voucher" v-model="kodeVoucher" class="form-control mr-3" placeholder="Masukkan Kode Voucher">
                        <button type="button" class="btn btn-primary" @click="applyVoucher">Konfirmasi</button>
                      </div>
                      <p v-if="voucher_info" class="text-success" style="font-size: 14px;">
                        Voucher berhasil diterapkan!
                      </p>
                      <p v-else-if="voucher_info === false" class="text-danger" style="font-size: 14px;">
                        Kode voucher tidak valid atau tidak aktif.
                      </p>
                      <p v-if="total_biaya !== null" class="text-info" style="font-size: 14px;">
                        Total setelah diskon: {{ formatCurrency(total_biaya) }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <ul class="list-inline pull-right">
              <li><button type="button" class="btn btn-danger prev-step">KEMBALI</button></li>
              <li><button type="button" class="btn btn-primary" style="font-size: 13px;padding: 8px 24px;border: none;border-radius: 4px;margin-top: 30px;" @click="submitForm">SELANJUTNYA</button></li>
            </ul>
          </div>
          <div class="tab-pane" role="tabpanel" id="step3">
            <div class="panel">
              <div class="panel-body text-center" style="background-color: skyblue;">
                <p class="text-center">Bukti Pembayaran Anda Sedang Divalidasi</p>
                <i class="fa fa-spinner fa-spin-pulse fa-4x"></i>
                <div class="text-center" style="background: aliceblue;max-width: fit-content;padding: 0px 100px;">HARAP TUNGGU</div>
              </div>
            </div>
          </div>
          <div class="tab-pane" role="tabpanel" id="step4">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-left text-primary">Konsultasi Dimulai</h4>
                <hr class="custom-hr">
                <div class="provider-info" v-if="selectedProviderInfo">
                  <table style="width: 50%; border-collapse: collapse;">
                    <tr>
                      <td style="padding:5px 5px 5px 0; vertical-align: top;">
                        <label class="text-primary">Klinik:</label>
                      </td>
                      <td style="padding:5px 5px 5px 0; vertical-align: top;">
                        {{ selectedProviderInfo.klinik }}
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:5px 5px 5px 0; vertical-align: top;">
                        <label class="text-primary">Provider:</label>
                      </td>
                      <td style="padding:5px 5px 5px 0; vertical-align: top;">
                        <div class="provider-details" style="display: flex; align-items: center;">
                          <!-- Tampilkan foto dokter -->
                          <img
                            :src="selectedProviderInfo.foto_dokter ? `${baseUrl}asset/foto_user/${selectedProviderInfo.foto_dokter}` : `${baseUrl}asset/foto_user/blank.png`"
                            alt="Foto Dokter"
                            class="provider-photo"
                            width="80"
                            style="margin-right: 10px; border-radius: 50%;" />

                          <div class="provider-desc">
                            <div class="provider-name">
                              <strong>{{ selectedProviderInfo.dokter }}</strong><br>
                              <span>{{ selectedProviderInfo.jabatan }}</span>
                            </div>
                            <div class="provider-time">
                              <span>{{ formatProviderTime(selectedProviderInfo.tstart, selectedProviderInfo.tend) }}</span>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>

                <hr class="custom-hr">
                <div class="complaint-form">
                  <div class="form-group">
                    <label for="keluhanSingkat" class="text-primary">Keluhan Singkat</label>
                    <input type="text" id="keluhanSingkat" class="form-control p-3" placeholder="Masukkan keluhan singkat Anda" value="">
                  </div>

                  <div class="form-group">
                    <label for="penjelasanKeluhan" class="text-primary">Penjelasan Keluhan</label>
                    <textarea id="penjelasanKeluhan" class="form-control" rows="5" placeholder="Jelaskan keluhan Anda secara rinci"></textarea>
                  </div>
                </div>
                <div class="consent-form mt-5">
                  <h4 class="text-primary mb-4">
                    <u>Lembar Persetujuan</u>
                  </h4>
                  <div class="mb-2">
                    <p class="text-primary m-0">
                      I Layanan Telemedicine PKBI adalah
                    </p>
                    <span class="text-sm"> Pelayanan kesehatan yang dilakukan oleh PKBI dengan metode pelayanan kesehatan jarak jauh yang dilakukan professional kesehatan kepada klien dengan menggunakan teknologi informasi dan komunikasi untuk kepentingan peningkatan kesehatan individu dan masyarakat, sesuai dengan kompetensi dan kewenangannya dengan tetap memperhatikan mutu pelayanan dan keselamatan pasien</span>
                  </div>
                  <div class="mb-2">
                    <p class="text-primary m-0">
                      II Pernyataan persetujuan terkait profil dan informasi yang disampaikan
                    </p>
                    <ol>
                      <li>Saya, menyatakan bahwa telah menyampaikan data diri: Demografi saya secara lengkap dan benar</li>
                      <li>Saya, setuju akan menyampaikan segala informasi melalui suara, dan atau tulisan, dan atau gambar dengan jujur untuk mendukung hasil diagnosa yang maksimal</li>
                      <li>Saya menyetujui bahwa segala percakapan melalui suara, tulisan, gambar dan video yang saya kirimkan akan direkam sebagai dokumentasi dan saya tidak berkeberatan akan hal tersebut.</li>
                      <li>Saya menyatakan bahwa saya memiliki hak untuk menghentikan konsultasi kapanpun tanpa menyebutkan alasan dan tidak akan mempengaruhi dan menyalahkan petugas telemedicine dalam proses pelayanan.</li>
                      <li>Saya menyatakan bahwa saya memiliki hak yang dilindungi atas semua informasi yang saya berikan untuk tidak disebarluaskan tanpa persetujuan, kecuali untuk kepentingan PKBI dalam proses pemberian layanan, pendidikan dan penelitian tanpa menyebutkan data diri.</li>
                    </ol>
                  </div>
                  <div class="mb-2">
                    <p class="text-primary m-0">
                      III Risiko
                    </p>
                    <span>
                      Dalam keadaan tertentu kegagalan pelayanan informasi dan/atau konseling dan/atau konsultasi dan/atau pengobatan yang dikarenakan masalah digital (resolusi gambar, sinyal dan masalah digital lainnya) mungkin terjadi meskipun jarang. <br>

                      Melalui dokumen surat pernyataan dan persetujuan umum untuk semua informasi dan layanan telemedicine ini saya (sesuai nama yang ada diregristrasi), telah membaca dan dengan sadar tanpa paksaan memberikan kewenangan pada petugas telemedicine PKBI untuk melakukan layanan informasi dan atau konseling dan atau konsultasi dan atau pengobatan pada permasalahan medis dan atau non medis dengan mengklik tanda kolom setuju dibawah ini
                    </span>
                  </div>
                  <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="setujuPersyaratan" v-model="setujuPersyaratan">
                    <label class="form-check-label text-primary" for="setujuPersyaratan">
                      Saya menyetujui persyaratan ini
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <ul class="list-inline">
              <li><button type="button" class="btn btn-back prev-step">Kembali</button></li>
              <li><button type="button" class="btn btn-primary next-step">Selanjutnya</button></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-xs-12 col-md-4 two sidebar">
      <div class="right-section">
        <?php include "sidebar.php"; ?>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url(); ?>/asset/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
  var baseUrl = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    // Disable all tabs except the first one on page load
    $('.wizard .nav-tabs li').not(':first').addClass('disabled');
    $('.wizard .nav-tabs li a').click(function(e) {
      // Prevent navigation via clicking tab directly
      if ($(this).parent().hasClass('disabled')) {
        e.preventDefault();
        return false;
      }
    });

    // Function to save the active tab to localStorage
    function saveActiveTab() {
      var activeTab = $('.wizard .nav-tabs li.active a').attr('href');
      localStorage.setItem('activeTab', activeTab); // Save active tab to localStorage
    }

    // Save the active tab whenever a tab is shown
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      saveActiveTab();
    });

    // Validate step1 form before moving to the next step
    $(".next-step").click(function(e) {
      var $active = $('.wizard .nav-tabs li.active');
      var currentStep = $active.find('a').attr('href');

      if (currentStep === '#step1') {
        // Validate step1 form (e.g., ensure 'provinsi' and 'klinik' are selected)
        if (validateStep1()) {
          // If step1 is valid, move to the next step
          $active.next().removeClass('disabled');
          nextTab($active);
          saveActiveTab(); // Save active tab when next button is clicked
        } else {
          alert('Harap isi semua field yang diperlukan di langkah 1!');
        }
      } else if (currentStep === '#step2') {
        // Add validation for step2 here if needed
        if (validateStep2()) {
          $active.next().removeClass('disabled');
          nextTab($active);
          saveActiveTab();
        } else {
          alert('Harap isi semua field yang diperlukan di langkah 2!');
        }
      } else if (currentStep === '#step3') {
        // Add validation for step3 if necessary
        nextTab($active);
        saveActiveTab();
      }
      // Add more validation for additional steps if necessary
    });

    $(".prev-step").click(function(e) {
      var $active = $('.wizard .nav-tabs li.active');
      prevTab($active);
      saveActiveTab(); // Save active tab when previous button is clicked
    });

    // Function to navigate to the next tab
    function nextTab(elem) {
      $(elem).next().find('a[data-toggle="tab"]').click();
    }

    // Function to navigate to the previous tab
    function prevTab(elem) {
      $(elem).prev().find('a[data-toggle="tab"]').click();
    }

    // On page load, retrieve the active tab from localStorage and show it
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
      $('.wizard .nav-tabs a[href="' + activeTab + '"]').tab('show');
    } else {
      // Default to the first step if no tab is stored in localStorage
      $('.wizard .nav-tabs a[href="#step1"]').tab('show');
    }

    // Validation function for step1 (example)
    function validateStep1() {
      var provinsi = $('input[name="prov_klinik"]').val(); // Replace with your field's name/ID
      var klinik = $('input[name="klinik"]').val(); // Replace with your field's name/ID

      if (provinsi === '' || klinik === '') {
        return false; // Validation fails
      }
      return true; // Validation passes
    }

    // Validation function for step2 (add more validation as needed)
    function validateStep2() {
      var field2 = $('input[name="field2"]').val(); // Example field in step2
      if (field2 === '') {
        return false;
      }
      return true;
    }
  });
</script>




<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/tambah-konsultasi-dokter.js'); ?>"></script>