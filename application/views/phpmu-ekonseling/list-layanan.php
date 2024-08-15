<div id="list-layanan" class="row container">
	<div class="col-md-12 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » <?php echo $title; ?> 
		</div>

		<!-- <h2><?php echo $title; ?></h2> -->
        <br>
        <div>
            <div class="row" style="margin-bottom: 10px; ">
                <div class="col-lg-6">
                    <div class="input-group"></div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input class="form-control" v-model="search" placeholder="Cari berdasarkan nama layanan"> 
                        <span class="input-group-btn"> 
                            <button class="btn btn-default" type="button">Cari</button> 
                        </span> 
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row list-klinik">
            <div v-for="(item, index) in items">
                <div class="col-md-6 col-sm-6">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <span class="glyphicon glyphicon-globe" style="color: #b16260;" aria-hidden="true"></span> 
                            </a> 
                        </div> 
                        <div class="media-body"> 
                            <h4 class="media-heading">{{ item.nama_kategori_layanan }}</h4> 
                            <p>{{ item.deskripsi_layanan }}</p>
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
<script src="<?php echo base_url('asset/list-layanan.js'); ?>"></script>
