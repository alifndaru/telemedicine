<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('asset/vue2-datepicker/index.css'); ?>">

<style>
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
    /* Datepicker */
    .mx-datepicker {
        width: 130px;
    }
    .mx-datepicker input {
        text-align: center;
    }
    .echarts {
         width: 100% !important;
         height: 400px !important;
         border: 1px solid #607d8b6b;
         padding-top: 6px;
         border-radius: 5px;
      }
</style>

<div id="vue-laporan" class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">
                <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
            </h3> 
        </div>
        <div class="box-body">
            <div class="row" style="margin-bottom: 13px;">
                <div class="col-md-6">
                    <input type="hidden" ref="klinik_id" value="<?php if (isset($klinik[0])) {echo $klinik[0]['klinik_id'];}; ?>">
                    <input type="hidden" ref="klinik_name" value="<?php if (isset($klinik[0])) {echo $klinik[0]['klinik'];}; ?>">
                    <p>Daerah</p>
                    <?php if (isset($klinik[0])) { ?>
                    <v-select
                        :disabled="disops.klinik === false" 
                        label="klinik" 
                        v-model="klinik" 
                        :reduce="klinik => klinik.id" 
                        :options="klinik_options"
                        @search="fetchOptionsKlinik" 
                        @search:focus="fetchOptionsKlinik"
                        @input="selectedOptionKlinik">
                    </v-select>
                    <?php } else { ?>
                    <v-select 
                        :disabled="disops.klinik === true" 
                        label="klinik" 
                        v-model="klinik" 
                        :reduce="klinik => klinik.id" 
                        :options="klinik_options"
                        @search="fetchOptionsKlinik" 
                        @search:focus="fetchOptionsKlinik"
                        @input="selectedOptionKlinik">
                    </v-select>
                    <?php }?>
                    
                    <input type="hidden" v-model="klinik" name="klinik">
                </div>
                <div class="col-md-6">
                    <p>Periode</p>
                    <date-picker v-model="tstart" lang="en" type="date" format="DD-MM-YYYY" placeholder="Start"></date-picker>
                    <date-picker v-model="tend" lang="en" type="date" format="DD-MM-YYYY" placeholder="End"></date-picker>
                    &nbsp;&nbsp;<span class="btn btn-primary" style="height: 32px; vertical-align: baseline;" v-on:click="exportExcel"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="row" style="margin-bottom: 13px;">
                <div class="col-md-6">
                    <p>IPES</p>
                    <v-select
                        :disabled="disops.layanan === true" 
                        label="layanan" 
                        v-model="layanan" 
                        :reduce="layanan => layanan.id" 
                        :options="layanan_options"
                        @search="fetchLayanan" 
                        @search:focus="fetchLayanan"
                        @input="selectedLayanan">
                    </v-select>
                    <input type="hidden" v-model="layanan">
                </div>
                <div class="col-md-6">
                    <p>Jenis Kelamin</p>
                    <v-select v-model="gender" :options="['Laki-laki', 'Perempuan']"></v-select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Daerah</th>
                                <th>ID Klien </th>
                                <th>Nama Klien </th>
                                <th>Gender</th>
                                <th>Tanggal</th>
                                <th>IPES</th>
                            </tr>
                        </thead>
                        <tbody v-for="(item, index) in items">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ item.klinik }}</td>
                                <td>{{ item.user_id }}</td>
                                <td>{{ item.nama_pasien }}</td>
                                <td>{{ item.gender_pasien }}</td>
                                <td>{{ item.tanggalx }}</td>
                                <td>{{ item.kategori_layananx }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <span v-if="items !== null">
                        <paginate 
                            first-last-button
                            :page-count="getPageCount" 
                            :page-range="3" 
                            :margin-pages="1" 
                            :click-handler="clickCallback" 
                            :disabled-class="'disabled'"
                            :active-class="'active'"
                            :prev-link-class="'page-link'"
                            :prev-text="'<'" 
                            :next-link-class="'page-link'"
                            :next-text="'＞'"
                            :container-class="'pagination'" 
                            :page-class="'page-item'"
                            :page-link-class="'page-link'">
                        </paginate>
                    </span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>IPES</p>
                    <v-chart autoresize :option="chart_layanan_pie"/>
                </div>
                <div class="col-md-6">
                    <p>Jumlah Konsultasi (Gender) </p>
                    <v-chart autoresize :option="chart_gender"/>
                </div>
            </div>
            <!-- <br>
            <div class="row">
                <div class="col-md-6">
                    <p>IPES 2</p>
                    <v-chart autoresize :option="chart_layanan_pie"/>
                </div>
            </div> -->
        </div>
    </div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/vue2-datepicker/index.min.js'); ?>"></script>

<script src="<?php echo base_url('asset/admin/plugins/composition-api/composition-api.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-echarts/index.umd.min.js'); ?>"></script>

<script src="<?php echo base_url('asset/admin/laporan.js'); ?>"></script>