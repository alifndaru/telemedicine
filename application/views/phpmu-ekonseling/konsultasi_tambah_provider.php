<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">
<link rel="stylesheet" href="<?= base_url(); ?>asset/css/konsultasiHostory.css">

<style>
    .pl-0 {
        padding-left: 0px !important;
    }

    .mb-10 {
        margin-bottom: 10px !important;
    }

    /* vue-select */
    .vs__no-options {
        text-align: left !important;
        padding-left: 8px;
    }

    .vs__clear {
        margin-bottom: 1px;
    }

    input[type="search"] {
        border: none !important;
        padding: 0px 10px 0px 10px !important;
    }

    .foto-dokter {
        width: 250px;
        height: 250px;
        margin-right: 15px;
        object-fit: cover;
    }

    .dokter-info h5 {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
    }

    .dokter-info p {
        margin: 0;
        font-size: 12px;
        color: #0056a4;
    }


    .jadwal-dokter-text {
        background-color: #e4eff9;
        color: #000 !important;
        font-weight: 400;
        width: 135px;
        border-radius: 0px !important;
    }

    .panel-dokter {
        margin-bottom: 5px;
    }

    .panel-default-dokter {
        border: none !important;
    }

    .timedifinfo {
        font-weight: 400;
        width: 230px;
    }

    .style2 {
        color: #FFFFFF
    }

    .p-0 {
        padding: 0;
    }

    .text-primary {
        color: #0056a4;
    }

    .style5 {
        font-size: 16px;
        color: #FF0000;
    }

    .style15 {
        font-size: 36
    }

    .dokter-item {
        display: flex;
        align-items: center;
    }

    .vs__no-options {
        text-align: left !important;
        padding-left: 8px;
    }

    .vs__clear {
        margin-bottom: 1px;
    }

    input[type="search"] {
        border: none !important;
        padding: 0px 10px 0px 10px !important;
    }

    /* Voucher Input */

    .my-auto {
        margin-top: auto;
        margin-bottom: auto;
    }

    .custom-hr {
        width: 100%;
        height: 2px;
        background-color: #0056a4;
        border: none;
        margin: 20px auto;
    }

    .table-payment td {
        border: none !important;
        padding: 2px !important;
    }

    /* Wizard Form */
    .d-flex {
        display: flex;
    }

    .justify-content-center {
        justify-content: center;
    }

    .align-items-center {
        align-items: center;
    }

    .wizard .nav-tabs {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: transparent;
    }

    .wizard>div.wizard-inner {
        position: relative;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 75%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 50%;
        z-index: 1;
    }

    .wizard .nav-tabs>li.active>a,
    .wizard .nav-tabs>li.active>a:hover,
    .wizard .nav-tabs>li.active>a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 15px;
        height: 15px;
        line-height: 15px;
        display: inline-block;
        border-radius: 50%;
        background: #fff;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 16px;
        color: #0e214b;
        font-weight: 500;
        border: 1px solid #ddd;
    }

    span.round-tab i {
        color: #555555;
    }

    .wizard li.active span.round-tab {
        background: #0056a4;
        color: #fff;
        border-color: #0056a4;
    }

    .wizard li.active span.round-tab i {
        color: #5bc0de;
    }

    .wizard .nav-tabs>li.active>a i {
        color: #0056a4;
    }

    .wizard .nav-tabs>li {
        width: 25%;
    }

    .nav-tabs>li>a:after {
        background: transparent;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        background: transparent;
        border: 5px solid transparent;
        border-bottom-color: red;
        transition: 0.1s ease-in-out;
    }



    .wizard .nav-tabs>li a {
        width: 15px;
        height: 15px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
        background: transparent;
        background-color: transparent;
        position: relative;
        top: 0;
    }

    .wizard .nav-tabs>li a i {
        position: absolute;
        top: -15px;
        font-style: normal;
        font-weight: 400;
        white-space: nowrap;
        background: transparent;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        font-weight: 700;
        color: #000;
    }

    .wizard .nav-tabs>li a:hover {
        background: transparent;
        background-color: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        padding-top: 20px;
    }


    .wizard h3 {
        margin-top: 0;
    }

    .prev-step,
    .next-step {
        font-size: 13px;
        padding: 8px 24px;
        border: none;
        border-radius: 4px;
        margin-top: 30px;
    }

    .next-step {
        background-color: #0056a4;
    }

    .skip-btn {
        background-color: #cec12d;
    }

    .step-head {
        font-size: 20px;
        text-align: center;
        font-weight: 500;
        margin-bottom: 20px;
    }

    @media (max-width: 767px) {
        .wizard .wizard-inner {
            display: none;
        }

        /* .wizard .nav-tabs>li {
            display: none;
        }
        .connecting-line {
            display: none;
        } */
    }

    /* End Wizard Form */
    @media (max-width: 768px) {
        .content-wrapper-history {
            flex-direction: column-reverse;
        }
    }

    .one {
        flex: 2;
    }

    .two {
        flex: 1;
    }
</style>
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
                                    <!-- <div v-if="bank && rekening" class="form-group">
                                            <label>Metode Pembayaran</label>
                                            <div>Bank: {{ bank }}</div>
                                            <div>Rekening: {{ rekening }}</div>
                                            <div>Atas Nama: {{ atas_nama }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Bukti Pembayaran</label>
                                            <input type="file" class="form-control" name="image">
                                        </div> -->
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
                                            <input type="file" class="mr-2 form-control" name="image" accept="image/png, image/jpeg">
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
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

            var $target = $(e.target);

            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function(e) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function(e) {
            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);
        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }

    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }
</script>



<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/tambah-konsultasi-dokter.js'); ?>"></script>