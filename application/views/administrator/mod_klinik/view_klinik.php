<div id="vue_klinik" class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Daerah</h3>
        </div>
        <div class="box-body">
            <div class="row" style="margin-bottom: 10px; ">
                <div class="col-lg-6">
                    <div class="input-group">
                        <?php if ($this->session->level !== 'klinik') { ?>
                            <a href="<?php echo base_url('administrator/register_klinik'); ?>">
                                <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                            </a>
                        <?php } else { ?>

                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input class="form-control" v-model="search" placeholder="Cari berdasarkan nama Daerah">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Cari</button>
                        </span>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Daerah</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Bank</th>
                        <th>No. Rekening</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-for="(item, index) in items">
                    <tr>
                        <td>{{ index+1 }}</td>
                        <td>{{ item.klinik }}</td>
                        <td>{{ item.alamat }}</td>
                        <td>{{ item.phone }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.bank }}</td>
                        <td>{{ item.rekening }}</td>
                        <!-- <td>{{ item.status }}</td> -->
                        <td v-if="item.status === 'tidak aktif'">
                            <span class="label label-danger">{{ item.status }}</span>
                        </td>
                        <td v-else>
                            <span class="label label-success">{{ item.status }}</span>
                        </td>
                        <td style="float: right;">
                            <a v-bind:href="'dokter?kid='+ item.klinik_idx" class="btn btn-primary btn-xs" type="button">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </a>
                            <button @click="statusKlinik(item.klinik_id)" v-if="item.status === 'tidak aktif'" class="btn btn-success btn-xs" type="button">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </button>
                            <button @click="statusKlinik(item.klinik_id)" v-else class="btn btn-danger btn-xs" type="button">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>

                            <a v-bind:href="'edit_klinik?kid='+ item.klinik_idx" class="btn btn-primary btn-xs" type="button">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </td>
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
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/klinik.js'); ?>"></script>