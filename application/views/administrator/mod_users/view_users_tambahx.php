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

    .vs__dropdown-menu {
        height: 200px !important;
    }
</style>

<div id="tambah-user" class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Data User</h3>
        </div>
        <div class="box-body">
            <form action="<?php echo base_url('/administrator/tambah_manajemenuser'); ?>" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="col-md-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                            <tr>
                                <th width="140px" scope="row">Username</th>
                                <td><input type="text" class="form-control" name="a" onkeyup="nospaces(this)" required=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Password</th>
                                <td><input type="password" class="form-control" name="b" onkeyup="nospaces(this)" required=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Lengkap</th>
                                <td><input type="text" class="form-control" name="c" required=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat Email</th>
                                <td><input type="email" class="form-control" name="d" required=""></td>
                            </tr>
                            <tr>
                                <th scope="row">No Telepon</th>
                                <td><input type="number" class="form-control" name="e" required=""></td>
                            </tr>
                            <tr>
                                <th scope="row">Alamat Lengkap</th>
                                <td><input type="text" class="form-control" name="alamat"></td>
                            </tr>
                            <tr>
                                <th scope="row">Tempat Lahir</th>
                                <td><input type="text" class="form-control" name="tempat_lahir"></td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal Lahir</th>
                                <td><input type="text" class="form-control" name="tanggal_lahir" value="00-00-0000"></td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Kelamin</th>
                                <td>
                                    <input type="radio" name="kelamin" value="Laki-laki" checked=""> Laki-laki
                                    <input type="radio" name="kelamin" value="Perempuan"> Perempuan
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Status Kawin</th>
                                <td>
                                    <select class="form-control" name="status" required="">
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Duda / Janda">Duda / Janda</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Agama</th>
                                <td>
                                    <select class="form-control" name="agama" required="">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><input type="text" class="form-control" name="perangkat_daerah"></td>
                            </tr>
                            <tr>
                                <th scope="row">Upload Foto</th>
                                <td><input type="file" class="form-control" name="f"></td>
                            </tr>
                            <tr>
                                <th scope="row">Level</th>
                                <td>
                                    <input v-model="level" type="radio" name="g" value="inovator" checked=""> Klien &nbsp;
                                    <input v-model="level" type="radio" name="g" value="user"> Provider &nbsp;
                                    <input v-model="level" type="radio" name="g" value="admin"> Administrator &nbsp;
                                    <input v-model="level" type="radio" name="g" value="klinik"> Daerah
                                </td>
                            </tr>
                            <tr v-if="level === 'klinik'">
                                <th>Daerah</th>
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-12 mb-10">
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Akses Modul</th>
                                <td>
                                    <div class="checkbox-scroll">
                                        <?php foreach ($record as $row) { ?>
                                            <span style="display:block">
                                                <input name="modul[]" type="checkbox" value="<?php echo $row['id_modul']; ?>"> <?php echo $row['nama_modul']; ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                            <tr v-if="level === 'user'">
                                <th scope="row">Klinik</th>
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-12 mb-10">
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="level === 'user'">
                                <th scope="row">No SIP</th>
                                <td><input type="text" class="form-control" name="sip"></td>
                            </tr>

                            <tr v-if="level === 'user'">
                                <th scope="row">No STR</th>
                                <td><input type="text" class="form-control" name="str"></td>
                            </tr>
                            <tr v-if="level === 'user'">
                                <th scope="row">Spesialis</th>
                                <td><input type="text" class="form-control" name="spesialis"></td>
                            </tr>

                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <input type="hidden" v-model="klinik" name="klinik">
                    <button type="submit" name="submit" class="btn btn-info">Perbaharui</button>
                    <a href="home"><button type="button" class="btn btn-default pull-right">Batal</button></a>
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
<script src="<?php echo base_url('asset/admin/tambah-user.js'); ?>"></script>