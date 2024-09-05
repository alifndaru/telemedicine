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
        width: 50px;
        height: 50px;
        margin-right: 15px;
        border-radius: 50%;
    }

    .dokter-info h5 {
        margin: 0;
        font-size: 14px;
        font-weight: bold;
    }

    .dokter-info p {
        margin: 0;
        font-size: 12px;
        color: #666;
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
    #kode_voucher {
        margin-top: 10px;
    }

    .btn-primary {
        margin-top: 10px;
    }
</style>
<?php
// Fetch user data
$usr = $this->db->query("SELECT * FROM users WHERE username='" . $this->session->username . "'")->row_array();
?>
<!-- HTML -->
<div id="tambah-konsultasi" class="row container">
    <div class="col-md-8 col-sm-12 clearfix">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> <?php echo $title; ?>
        </div>
        <h2><?php echo "$title"; ?></h2><br>

        <!-- Form for selecting province, clinic, and doctor -->
        <form action="">
            <!-- Select Province -->
            <div class="form-group">
                <label class="col-sm-3 control-label pl-0">Provinsi</label>
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
                <label class="col-sm-3 control-label pl-0">Klinik <span class="red">*</span></label>
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
                <label class="col-sm-3 control-label pl-0">Dokter</label>
                <div class="col-sm-9 mb-10">
                    <ul class="list-group">
                        <li class="list-group-item" v-for="dokter in dokter_options" :key="dokter.id">
                            <div class="dokter-item">
                                <img :src="`${baseUrl}asset/foto_user/${dokter.foto_dokter}`" alt="Foto Dokter" class="foto-dokter">
                                <div class="dokter-info">
                                    <h5>{{ dokter.dokter }}</h5>
                                    <p>{{ dokter.jabatan }} di {{ dokter.klinik }}</p>
                                    <p>{{ dokter.spesialis }}</p>
                                    <div v-if="dokter.kuota.length > 0">
                                        <div v-for="(kuota, index) in dokter.kuota" :key="index">
                                            <label class="radio-inline">
                                                <input type="radio"
                                                    :name="'selected_kuota_' + dokter.id +"
                                                    :value="index"
                                                    v-model="selected_kuota[dokter.id]"
                                                    @change="handleKuotaChange(dokter, index)">
                                                Kuota: {{ kuota }} - {{ dokter.tstart[index] }} to {{ dokter.tend[index] }} (Tarif: {{ dokter.biaya_tarif[index] | currency }})
                                            </label>
                                        </div>
                                    </div>
                                    <p v-else>Kuota: Tidak tersedia</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Payment Details -->
            <div v-if="Object.keys(selected_kuota).length > 0" class="form-group">
                <label class="col-sm-3 control-label pl-0">Detail Pembayaran</label>
                <div class="col-sm-9 mb-10">
                    <div v-if="biaya_tarif">
                        <div>Biaya Tarif: {{ formatCurrency(biaya_tarif) }}</div>
                    </div>
                    <div v-if="bank && rekening" class="form-group">
                        <label>Metode Pembayaran</label>
                        <div>Bank: {{ bank }}</div>
                        <div>Rekening: {{ rekening }}</div>
                        <div>Atas Nama: {{ atas_nama }}</div>
                    </div>
                    <div class="form-group">
                        <label>Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
            </div>

            <!-- Voucher Input -->
            <div class="form-group">
                <label class="col-sm-3 control-label pl-0">Kode Voucher</label>
                <div class="col-sm-9 mb-10">
                    <input type="text" id="kode_voucher" v-model="kodeVoucher" class="form-control" placeholder="Masukkan Kode Voucher">
                    <button type="button" class="btn btn-primary" @click="applyVoucher">Apply Voucher</button>
                    <p v-if="voucher_info" class="text-success">
                        Voucher berhasil diterapkan! Diskon: {{ discount }}%
                    </p>
                    <p v-else-if="voucher_info === false" class="text-danger">
                        Kode voucher tidak valid atau tidak aktif.
                    </p>
                    <p v-if="total_biaya !== null" class="text-info">
                        Total setelah diskon: {{ formatCurrency(total_biaya) }}
                    </p>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="button" class="btn btn-success" @click="submitForm">Submit</button>
                </div>
            </div>

        </form>
    </div>

    <!-- Sidebar -->
    <div class='col-md-4 sidebar col-sm-12'>
        <div class="right-section">
            <?php include "sidebar.php"; ?>
        </div>
    </div>
</div>


<script>
    var baseUrl = "<?php echo base_url(); ?>";
</script>



<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/tambah-konsultasi-dokter.js'); ?>"></script>