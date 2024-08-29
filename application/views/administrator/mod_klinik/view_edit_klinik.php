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

<div id="vue-regklinik" class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Registrasi Daerah </h3>
        </div>
        <div class="box-body">
            <form action="../administrator/proses_register_klinik" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="col-md-12">
                    <input type="hidden" name='kid' ref="kid" value="<?php echo $kid; ?>">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Nama Daerah </th>
                                <td><input type="text" class="form-control" v-model="nama_klinik" name="nama_klinik" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Provinsi</th>
                                <td>
                                    <v-select
                                        :disabled="disops.provinsi === true"
                                        label="provinsi"
                                        v-model="provinsi"
                                        :reduce="provinsi => provinsi.id"
                                        :options="provinsi_options"
                                        @search="fetchOptionsProvinsi"
                                        @input="selectedOptionProvinsi">
                                    </v-select>
                                    <input type="hidden" v-model="prov_klinik" name="prov_klinik">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kabupaten</th>
                                <td>
                                    <v-select
                                        :disabled="disops.kabupaten === true"
                                        label="kabupaten"
                                        v-model="kabupaten"
                                        :reduce="kabupaten => kabupaten.id"
                                        :options="kabupaten_options"
                                        @search="fetchOptionsKabupaten"
                                        @input="selectedOptionKabupaten">
                                    </v-select>
                                    <input type="hidden" v-model="kab_klinik" name="kab_klinik">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kecamatan</th>
                                <td>
                                    <v-select
                                        :disabled="disops.kecamatan === true"
                                        label="kecamatan"
                                        v-model="kecamatan"
                                        :reduce="kecamatan => kecamatan.id"
                                        :options="kecamatan_options"
                                        @search="fetchOptionsKecamatan"
                                        @input="selectedOptionKecamatan">
                                    </v-select>
                                    <input type="hidden" v-model="kec_klinik" name="kec_klinik">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kelurahan</th>
                                <td>
                                    <v-select
                                        :disabled="disops.kelurahan === true"
                                        label="kelurahan"
                                        v-model="kelurahan"
                                        :reduce="kelurahan => kelurahan.id"
                                        :options="kelurahan_options"
                                        @search="fetchOptionsKelurahan"
                                        @input="selectedOptionKelurahan">
                                    </v-select>
                                    <input type="hidden" v-model="kel_klinik" name="kel_klinik">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat Lengkap</th>
                                <td><input type="text" class="form-control" v-model="alamat_klinik" name="alamat_klinik" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Kode POS</th>
                                <td><input type="text" class="form-control" v-model="pos_klinik" name="pos_klinik" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td><input type="email" class="form-control" v-model="email_klinik" name="email_klinik" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">No Telepon</th>
                                <td><input type="number" class="form-control" v-model="telp_klinik" name="telp_klinik" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Foto</th>
                                <td><input type="file" class="form-control" name="foto_klinik"></td>
                            </tr>
                            <tr>
                                <th scope="row">Bank </th>
                                <td>
                                    <select name="bank" class="form-control">
                                        <?php
                                        $banks = ['BCA', 'Mandiri', 'BRI', 'BNI', 'CIMB Niaga', 'Danamon'];
                                        foreach ($banks as $bank) {
                                            echo "<option value='{$bank}'>{$bank}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">No Rekening</th>
                                <td><input type="number" class="form-control" name="rekening" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td><img class="zoomable" height="150" v-bind:src="'../asset/foto_klinik/' + foto_klinik" /> </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td v-if="status === 'tidak aktif'">
                                    <span class="label label-danger">{{ status }}</span>
                                </td>
                                <td v-else>
                                    <span class="label label-success">{{ status }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="action" value="update">
                    <button type="submit" name="submit" class="btn btn-info">Ubah</button>
                    <!-- <button onclick="history.back()" type="button" class="btn btn-default pull-right">Cancel</button> -->
                </div>
            </form>
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
<script src="<?php echo base_url('asset/admin/edit_klinik.js'); ?>"></script>