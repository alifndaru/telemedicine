<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/konsul.css">

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
.style1 {
	font-size: 26px;
	color: #FF0000;
	font-weight: bold;
}
</style>

<?php
	$total_komentar = $this->model_utama->view_where('komentar_konsul',array('id_konsul' => $rows['id_konsul'],'aktif'=>'Y'))->num_rows();
?>	
<div id="vue_konsul_pasien" class="row container clearfix">
    <div class="col-lg-12">
        <div class="breadcrumb">
            <a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » Konsultasi » <?php echo "$rows[judul]"; ?> 
        </div> 
        <div class="card chat-app">
            <input type="hidden" ref="kid" value="<?php echo $this->uri->segment(3);?>">
            <input type="hidden" ref="dokter" value="<?php echo $this->session->user_id;?>">
            <input type="hidden" ref="siteurl" value="<?php echo base_url(); ?>">
            <div id="plist" class="people-list">
                <h4 style="margin-bottom: 25px;">Pasien</h4>
                    <?php foreach ($pasien[0] as $k => $d) { ?>
                        <?php if ($k == 'foto') { ?> <span><img id="fotox" src="../../asset/foto_user/<?php echo $d; ?>"></span> <?php } ?>
                        <?php if ($k == 'user_id') { ?> <input type="hidden" ref="pasien" value="<?php echo $d?>"> <?php } ?>
                    <?php } ?>
                <table class="table">
                    <tbody> 
                        <?php foreach ($pasien[0] as $k => $d) { ?>
                            <?php if ($k == 'user_id') { ?> <tr><td>ID</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'nama_lengkap') { ?> <tr><td>Nama</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'email') { ?> <tr><td>Email</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'no_telp') { ?> <tr><td>No. Telp</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'jenis_kelamin') { ?> <tr><td>Gender</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'alamat_lengkap') { ?> <tr><td>Alamat</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'tempat_lahir') { ?> <tr><td>Kota Lahir</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'tanggal_lahir') { ?> <tr><td>Tgl. Lahir</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'agama') { ?> <tr><td>Agama</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'status_kawin') { ?> <tr><td>Status kawin</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                        <?php } ?>
                    </tbody> 
                </table>
                <div class="keluhan">
                    <h4>Keluhan</h4>
                    <div ref="keluhan"></div>
                    <div v-if="dokter === null || dokter === ''">
                        <button class="btn btn-info" v-on:click="ambilKonsul">Ambil</button>
                    </div>
                </div>
                <?php if ($this->session->level == 'user') { ?>
                    <div class="catatan">
                        <h4>Catatan</h4>
                        <textarea v-model="catatan" rows="5"></textarea>
                        <br>
                        <div>
                            <h4>Jenis Layanan</h4>
                            <v-select multiple
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
                        <br>
                        <input type="checkbox" v-model="rujuk"> Dirujuk
                        <div v-show="rujuk">
                            <input style="margin-top: 5px;" class="form-control" type="text" v-model="rujukan">
                        </div>
                    </div>
                    <div style="margin-top: 20px;">
                        <button class="btn" v-on:click="closeKonsul">Tutup Konsultasi</button>
                    </div>
                <?php } ?>
            </div>
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <?php if (isset($dokter['foto']) && !empty($dokter['foto'])) { ?>
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="../../asset/foto_user/<?php echo $dokter['foto']; ?>" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <p class="m-b-0 user-name"><?php echo $dokter['nama_lengkap']; ?></p>
                                    <small><?php echo $dokter['user_id']; ?></small>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="../../asset/foto_user/blank.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <p class="m-b-0 user-name">Belum Ada Provider</p>
                                    <small>...</small>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="col-lg-6 hidden-sm text-right">
                            <div class="style1" id="time-counter">0h 0m 0s</div>
                        </div>

                        <div class="col-lg-6 hidden-sm text-right">
                            <div id="time-info">
                                <span>({{ tstart }} - {{ tend }})</span>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="chat-history" ref="chistory">
                    <ul class="m-b-0" v-for="(chat, index) in chats">
                        <li class="clearfix" v-if="chat.level === 'D'">
                            <span v-if="chat.isi_komentar !== null">
                                <span v-if="chat.type === 'text'">
                                    <div class="message-data text-right">
                                        <span class="message-data-time">{{ chat.jam_komentar }}</span>
                                    </div>
                                    <div class="message other-message float-right">{{ chat.isi_komentar }}</div>
                                </span>
                                <span v-else>
                                    <div class="message-data text-right message-file-time">
                                        <span class="message-data-time">{{ chat.jam_komentar }}</span>
                                    </div>
                                    <a target="_blank" :href="chat.isi_komentar" class="message other-message float-right message-file">
                                        <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> file
                                    </a>
                                </span>
                            </span>
                        </li>
                        <li class="clearfix" v-else>
                            <span v-if="chat.isi_komentar !== null">
                                <span v-if="chat.type === 'text'">
                                    <div class="message-data">
                                        <span class="message-data-time">{{ chat.jam_komentar }}</span>
                                    </div>
                                    <div class="message my-message">{{ chat.isi_komentar }}</div>  
                                </span>
                                <span v-else>
                                    <div class="message-data">
                                        <span class="message-data-time">{{ chat.jam_komentar }}</span>
                                    </div>
                                    <a target="_blank" :href="chat.isi_komentar" class="message my-message message-file">
                                        <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> file
                                    </a> 
                                </span>  
                            </span>                      
                        </li>
                    </ul>
                </div>
                <?php if ($this->session->user_id == $dokter['user_id']) { ?>
                <div class="chat-message clearfix">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <label id="labelx">
                                <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                <input type="file" style="display:none" @change="uploadFile" ref="file">
                            </label>
                        </span>
                        <input class="form-control" v-model="cinput" v-on:keyup.enter="cinputEnter">
                        <span class="input-group-addon" v-on:click="cinputEnter">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
                        </span>
                    </div>
                </div>
                <?php } else { ?> <div style="height: 44px;"></div> <?php } ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/konsul_dokter.js'); ?>"></script>