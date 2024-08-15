<link rel="stylesheet" href="<?php echo base_url(); ?>asset/konsul.css">

<?php
	$total_komentar = $this->model_utama->view_where('komentar_konsul',array('id_konsul' => $rows['id_konsul']))->num_rows();
?>	
<style type="text/css">
<!--
.style1 {
	font-family: "Times New Roman", Times, serif;
	font-size: 26px;
	color: #FF0000;
	font-weight: bold;
}
.style2 {color: #0000FF}
-->
</style>
<div id="vue_konsul_pasien" class="row container clearfix">
    <div class="col-lg-12">
        <div class="breadcrumb">
            <a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> » Konsultasi » <?php echo "$rows[judul]"; ?> 
        </div> 
        <div class="card chat-app">
            <input type="hidden" ref="kid" value="<?php echo $this->uri->segment(3);?>">
            <input type="hidden" ref="pasien" value="<?php echo $this->session->user_id;?>">
            <div id="plist" class="people-list">
                <h4 class="style2" style="margin-bottom: 25px;">Provider</h4>
                    <?php foreach ($dokter[0] as $k => $d) { ?>
                        <?php if ($k == 'foto') { ?> <span><img id="fotox" src="../../asset/foto_user/<?php echo $d; ?>"></span> <?php } ?>
                        <?php if ($k == 'user_id') { ?> <input type="hidden" ref="dokter" value="<?php echo $d?>"> <?php } ?>
                    <?php } ?>
                <table class="table">
                    <tbody> 
                        <?php foreach ($dokter[0] as $k => $d) { ?>
                            <?php if ($k == 'user_id') { ?> <tr><td><big>ID</td><td>:</td><td><?php echo $d; ?></td></tr></big> <?php } ?>
                            <?php if ($k == 'nama_lengkap') { ?> <big><tr><td>Nama</td><td>:</td><td><?php echo $d; ?></td></tr></big> <?php } ?>
                            <?php if ($k == 'klinik') { ?> <tr><td>Klinik</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                            <?php if ($k == 'alamat_klinik_lengkap') { ?> <tr><td>Alamat</td><td>:</td><td><?php echo $d; ?></td></tr> <?php } ?>
                        <?php } ?>
                    </tbody> 
                </table>
                <div class="keluhan">
                    <h4>Keluhan</h4>
                    <div ref="keluhan"></div>
                </div>
            </div>
			
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="../../asset/foto_user/<?php echo $pasien['foto']; ?>" alt="avatar">
                            </a>
                          <div class="chat-about">
                                <big<p class="m-b-0 user-name"><?php echo $pasien['nama_lengkap']; ?></p></big>
                                <big><?php echo $pasien['user_id']; ?></big>
                            </div>
							
                        </div>
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
                        <li class="clearfix" v-if="chat.level === 'P'">
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
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/konsul_pasien.js'); ?>"></script>