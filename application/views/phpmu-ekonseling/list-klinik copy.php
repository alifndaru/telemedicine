<div id="list-klinik" class="row container">
    <div class="col-md-12 col-sm-12 clearfix">
        <!-- <h2>Daftar Daerah</h2> -->
        <h2>Lokasi PKBI</h2>
        <div>
            <div class="row" style="margin-bottom: 10px; ">
                <div class="col-lg-6">
                    <div class="input-group"></div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input class="form-control" v-model="search" placeholder="Cari berdasarkan nama klinik atau daerah">
                        <span class="input-group-btn">
                            <select v-model="sfilter" style="width: 150px;" class="form-control">
                                <option value="klinik">Klinik</option>
                                <option value="provinsi">Daerah (Provinsi)</option>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <h4>Rekomendasi</h4>
        <div class="row list-klinik rekomendasi">
            <div v-for="(item, index) in items">
                <div v-if="item.ranke > 3" class="col-md-6 col-sm-6">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object thumbnail" :src="'asset/foto_klinik/'+item.foto" style="width: 64px; height: 64px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ item.klinik }}</h4>
                            <p>{{ item.alamat }}, {{ item.kelurahan }}, {{ item.kecamatan }}, {{ item.kabupaten }}, <span class="btn-prov">{{ item.provinsi }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></h4>
        <div class="row list-klinik">
            <div v-for="(item, index) in items">
                <div v-if="item.ranke <= 3" class="col-md-6 col-sm-6">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object thumbnail" :src="'asset/foto_klinik/'+item.foto" style="width: 64px; height: 64px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ item.klinik }}</h4>
                            <p>{{ item.alamat }}, {{ item.kelurahan }}, {{ item.kecamatan }}, {{ item.kabupaten }}, <span class="btn-prov">{{ item.provinsi }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
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

<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/list-klinik.js'); ?>"></script>