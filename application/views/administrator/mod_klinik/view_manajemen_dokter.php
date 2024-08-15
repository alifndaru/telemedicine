
<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">

<style>
   /* vue-select */
   .vs__no-options {
      text-align: left !important;
      padding-left: 8px;
   }

   .vs__clear {
      margin-bottom: 1px;
   }
</style>

<div id="vue-jadwal" class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Jadwal Provider</h3> 
        </div>
        <div class="box-body">
            <input type="hidden" name='kid' ref="kid" value="<?php echo $kid; ?>">
            <table class="table table-condensed table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Daerah</th>
                        <td><input type="text" class="form-control" v-model="nama_klinik" name="nama_klinik" value="" disabled></td>
                    </tr>
                    <tr>
                        <th scope="row">Pilih Provider </th>
                        <td>
                            <v-select 
                                :disabled="disops.dokter === true" 
                                label="dokter" 
                                v-model="dokter" 
                                :reduce="dokter => dokter.id" 
                                :options="dokter_options" 
                                @search="fetchOptionsDokter" 
                                @input="selectedOptionDokter">
                            </v-select>
                            <input type="hidden" v-model="dokter_id" name="dokter_id">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Waktu Konsul</th>
                        <td>
                            <div class="input-group" style="display: inline-flex !important;">
                                <vue-timepicker v-model="tstart" input-class="input-time-custom" @change="time_handler($event, 'tstart')"></vue-timepicker>&nbsp; <div>-</div> &nbsp;
                                <vue-timepicker v-model="tend" input-class="input-time-custom" @change="time_handler($event, 'tend')"></vue-timepicker>&nbsp;&nbsp;
                                <select style="height: 30.8px; width: 80px;" class="form-control" v-model="timezone">
                                    <option value="wib">WIB</option>
                                    <!-- <option value="wita">WITA</option>
                                    <option value="wit">WIT</option> -->
                                </select>&nbsp;&nbsp;
                                <select style="height: 30.8px; width: 110px !important;" class="form-control" v-model="timestatus">
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                </select>
                                <input type="hidden" v-model="tstart">
                                <input type="hidden" v-model="tend">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Kuota Klien </th>
                        <td><input type="text" class="form-control" style="width: 200px !important;" v-model="kuota_pasien" name="kuota_pasien" value=""></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span v-if="actAdd === true">
                                <button v-on:click="tambahJadwal" class="btn btn-primary">Tambah</button>
                            </span>
                            <span v-if="actEdit === true">
                                <button v-on:click="editJadwal" class="btn btn-warning">Simpan</button>
                            </span>
                            <br>
                            <div v-if="message !== null" class="bs-callout bs-callout-danger">{{ message }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div>
                <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></h3> 
                </div>
                <div class="box-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Daerah</th>
                                <th>Provider</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Kuota</th>
                                <th>Zona</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-for="(item, index) in jadwal">
                            <tr>
                                <td>{{ index+1 }}</td>
                                <td>{{ item.klinik }}</td>
                                <td>{{ item.nama_dokter }}</td>
                                <td>{{ item.tstart }}</td>
                                <td>{{ item.tend }}</td>
                                <td>{{ item.kuota }}</td>
                                <td style="text-transform: uppercase;">{{ item.timezone }}</td>
                                <td v-if="item.status === 'tidak aktif'">
                                    <span class="label label-danger">{{ item.status }}</span>
                                </td>
                                <td v-else>
                                    <span class="label label-success">{{ item.status }}</span>
                                </td>
                                <td style="float: right;">
                                    <button @click="statusJadwal(item.id)" v-if="item.status === 'tidak aktif'" class="btn btn-success btn-xs" type="button">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    </button>
                                    <button @click="statusJadwal(item.id)" v-else class="btn btn-danger btn-xs" type="button">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </button>
                                    <button @click="statusDel(item.id)" class="btn btn-danger btn-xs" type="button">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                    <button :class="{edit_active: (jadwal_id === item.id)}" :disabled="dokter_id === '' || dokter_id === null" @click="editMode(item.id, item.tstart, item.tend, item.kuota, item.timezone, item.status)" class="btn btn-success btn-xs" type="button">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <span v-if="jadwal !== null">
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
        </div>
    </div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/smooth-zoom/zoom.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/manajemen_dokter.js'); ?>"></script>