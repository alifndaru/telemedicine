<div class="col-xs-12" id="vue_payment_status">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Konfirmasi Payment</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <input type="text" v-model="search" placeholder="Search..." class="form-control mb-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:10px'>id</th>
                        <th style='width:150px'>Code</th>
                        <th>users_id</th>
                        <th>Jadwal_id</th>
                        <th>Image</th>
                        <th>biaya (Rp)</th>
                        <th>klinik_id</th>
                        <th>Aktif</th>
                        <th style='width:100px'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="item.payment_id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.payment_id }}</td>
                        <td>{{ item.users_id }}</td>
                        <td>{{ item.jadwal_id }}</td>
                        <td><img :src="base_url + 'asset/payment_proofs/' + item.image" height="50" v-if="item.image"></td>
                        <td>{{ item.biaya }}</td>
                        <td>{{ item.klinik_id }}</td>
                        <td>{{ item.aktif === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}</td>
                        <td>
                            <button v-if="item.aktif !== 'aktif'" class="btn btn-success btn-sm" @click="updatePaymentStatus(item.payment_id, true)">
                                Aktifkan
                            </button>
                            <button v-if="item.aktif === 'aktif'" class="btn btn-danger btn-sm" @click="updatePaymentStatus(item.payment_id, false)">
                                Non-Aktifkan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <paginate
                :page-count="totalPage"
                :click-handler="clickCallback"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </paginate>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/payment_status.js'); ?>"></script>