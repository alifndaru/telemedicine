<link rel="stylesheet" href="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.css'); ?>">

<style>
    .pl-0 {
        padding-left: 0px !important;
    }
    .mb-10 {
        margin-bottom: 10px !important;
    }

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
    .foto-dokter {
        width: 200px;
    }
    .jadwal-dokter-text {
        background-color: #e4eff9;
        color: #000 !important;
        font-weight: 400;
        width: 135px;
        border-radius: 0px !important;
    }
    .panel-dokter {
        margin-bottom: 5px;
    }
    .panel-default-dokter {
        border: none !important;
    }
    .timedifinfo {
        font-weight: 400;
        width: 230px;
    }
.style2 {color: #FFFFFF}
.style5 {
	font-size: 16px;
	color: #FF0000;
}
.style15 {font-size: 36}
</style>

<!-- HTML -->
<div id="tambah-konsultasi" class="row container">
	<div class="col-md-8 col-sm-12 clearfix">
		<div class="breadcrumb">
			<a href="<?php echo base_url('/'); ?>"><i class="fa fa-home"></i> Home</a> <?php echo $title; ?> 
		</div>
		<h2><?php echo "$title"; ?></h2><br>

        <!-- Form -->
        <form method="post" action="konsultasi_proses">
            <div class="form-group">
                <label class="col-sm-3 control-label pl-0">Provinsi</label>
                <div class="col-sm-9 mb-10">
                    <v-select 
                        :disabled="disops.provinsi === true" 
                        label="provinsi" 
						 placeholder="Pilih Provinsi"
                        v-model="provinsi" 
                        :reduce="provinsi => provinsi.id" 
                        :options="provinsi_options" 
                        @search="fetchOptionsProvinsi" 
                        @input="selectedOptionProvinsi">
						<span slot = "no-options"> Silahkan Ketikan Nama Daerah </span>
                    </v-select>
                    <input type="hidden" v-model="prov_klinik" name="prov_klinik">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label pl-0">Klinik <span class="red">*</span></label>
                <div class="col-sm-9 mb-10">
                    <v-select 
                        :disabled="disops.klinik === true" 
                        label="klinik" 
                        v-model="klinik" 
                        placeholder="Pilih Klinik"
                        :reduce="klinik => klinik.id" 
                        :options="klinik_options"
                        @search="fetchOptionsKlinik" 
                        @search:focus="fetchOptionsKlinik"
                        @input="selectedOptionKlinik">
                    </v-select>
                    <input type="hidden" v-model="klinik" name="klinik">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label pl-0">Provider <span class="red">*</span></label>
                <div class="col-sm-9 mb-10">
                    <v-select 
                        :disabled="disops.dokter === true" 
                        label="dokter" 
                        v-model="dokter" 
                        placeholder="Pilih Provider"
                        :reduce="dokter => dokter.id" 
                        :options="dokter_options"
                        @search="fetchOptionsDokter" 
                        @search:focus="fetchOptionsDokter"
                        @input="selectedOptionDokter">
						<span slot = "no-options"> Silahkan Pilih Nama Provider </span>
                    </v-select>
                    <input type="hidden" v-model="dokter" name="dokter">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label pl-0"></label>
                <div class="col-sm-9 mb-10">
                    <div v-for="(d, i) in dokter_selected">
                        <div class="col-sm-6 thumbnail">
                            <img v-bind:src="'../asset/foto_user/' + d.foto_dokter" /> 
                            <div class="caption">
                                <h3 style="margin-bottom: 15px;">{{ d.dokter }}</h3>
                                <div class="panel panel-default panel-default-dokter">
                                    <div class="panel-heading panel-dokter">
                                        <h3 class="panel-title">ID</h3>
                                    </div>
                                    <div class="panel-body">
                                        {{ d.dokter_id }}
                                    </div>
                                </div>
                                <div class="panel panel-default panel-default-dokter">
                                    <div class="panel-heading panel-dokter">
                                        <h3 class="panel-title">Provider</h3>
                                    </div>
                                    <div class="panel-body">
                                        {{ d.jabatan }}
                                    </div>
                                </div>
                                <div class="panel panel-default panel-default-dokter">
                                    <div class="panel-heading panel-dokter">
                                        <h3 class="panel-title">Praktek</h3>
                                    </div>
                                    <div class="panel-body">
                                        {{ d.klinik }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div v-for="(d, i) in jadwal_options">
                            <div class="col-sm-6 mb-10">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                        <input :disabled="d.sisa <= 0" type="radio" name="jadwal_selected" v-model="jadwal_selected" v-bind:value="[d.tstart, d.tend, d.jadwal_id]">
                                  </span>
                                    <input class="jadwal-dokter-text" type="text" v-bind:value="d.tstart + ' - ' + d.tend" disabled class="form-control">
                                    <span class="style2"> -- </span><span class="kuota-pasien style5" :class = "(d.sisa <= 0)? 'kuota-habis':'kuota-ada'"><strong>Kuota Tersisa Adalah:::</strong><strong>{{ d.sisa }}</strong></span> </div>
                            </div>
                        </div>
                        <div v-if="dokter_selected.length !== 0" class="timedifinfo col-sm-6 mb-10">
                            <hr>Zona waktu yang tertera adalah WIB, lebih lambat 1 jam dengan WITA, dan lebih lambat 2 jam dengan WIT<hr>
                        </div>
                    </div>
                    
                </div>
            </div>

            
            <div class="form-group">
                <label class="col-sm-3 control-label pl-0"></label>
                <div class="col-sm-9 mb-10"><hr></div>
            </div>

            <!-- <div class="form-group">
                <label class="col-sm-3 control-label pl-0">Kategori <span class="red">*</span></label>
                <div class="col-sm-9 mb-10">
                    <select name="kategori" class="form-control" required="">
                        <?php foreach ($kategori as $row) { ?>
                            <option value="<?php echo $row['id_kategori_konsul']; ?>"><?php echo $row['nama_kategori']; ?></option>;
                        <?php } ?>
                    </select>
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-sm-3 pl-0">Judul <span class="red">*</span></span></label>
				
                <div class="controls col-sm-9 ">
                    <input class="input-md emailinput form-control mb-10" v-model="judul" name="judul" type="text" placeholder="Isi judul">
                </div>     
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3 pl-0">Keluhan <span class="red">*</span></label>
                <div class="controls col-sm-9 ">
                    <textarea class="input-md  textinput textInput form-control mb-10" v-model="keluhan" name="keluhan" type="text" placeholder="Isi Keluhan">></textarea>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label class="control-label col-sm-3 pl-0"></label>
                    <div class="controls col-sm-9 ">
                        <table width="517" bordercolor="#FFFFFF">
                          <tr>
                            <td colspan="3"><strong>Lembar Persetujuan </strong></td>
                          </tr>
                          <tr>
                            <td colspan="2"><span class="style15">I</span></td>
                            <td width="473"><ol>
                              <strong>  Layanan  Telemedicine PKBI adalah:                              </strong>
                            <p align="justify">Pelayanan  kesehatan yang dilakukan oleh PKBI dengan metode pelayanan kesehatan jarak jauh  yang dilakukan professional Kesehatan kepada klien dengan menggunakan teknologi  informasi dan komunikasi untuk kepentingan peningkatan kesehatan individu dan  masyarakat, sesuai dengan kompetensi dan kewenangannya dengan tetap memperhatikan  mutu pelayanan dan keselamatan pasien</p></td>
                          </tr>
                          <tr>
                            <td width="16" rowspan="6"><div align="justify"><span class="style15">II</span></div></td>
                            <td width="12"><div align="justify"><span class="style15"></span></div></td>
                            <td><div align="justify"><strong>Pernyataan  dan persetujuan terkait Profil dan informasi yang disampaikan</strong></div></td>
                          </tr>
                          <tr>
                            <td><div align="justify"><span class="style15">1.</span></div></td>
                            <td><ol>
                            <div align="justify">Saya,  menyatakan bahwa telah menyampaikan data diri / Demografi saya secara Lengkap  dan benar</div></td>
                          </tr>
                          <tr>
                            <td><div align="justify"><span class="style15">2.</span></div></td>
                            <td><ol>
                            <div align="justify">Saya,  setuju &nbsp;akan menyampaikan segala  informasi melalui suara, dan atau tulisan, dan atau atau gambar dengan jujur  untuk mendukung&nbsp; hasil diagnose yang  maksimal</div></td>
                          </tr>
                          <tr>
                            <td><div align="justify"><span class="style15">3.</span></div></td>
                            <td><ol>
                            <div align="justify">Saya  menyetujui bahwa segala percakapan melalui suara, tulisan, gambar dan video  yang saya kirimkan akan direkam dan disimpan sebagai dokumentasi dan saya tidak  berkeberatan akan hal tersebut</div></td>
                          </tr>
                          <tr>
                            <td><div align="justify"><span class="style15">4.</span></div></td>
                            <td><ol>
                            <div align="justify">Saya menyatakan  bahwa saya memiliki hak untuk menghentikan konsultasi kapanpun tanpa  menyebutkan alasan dan tidak akan mempengaruhi dan menyalahkan petugas telemedicine  dalam proses pelayanan</div></td>
                          </tr>
                          <tr>
                            <td><div align="justify"><span class="style15">5.</span></div></td>
                            <td><ol>
                            <div align="justify">Saya,  menyatakan bahwa saya memiliki hak yang dilindungi atas semua informasi yang  saya berikan untuk tidak disebarluaskan tanpa persetujuan, kecuali untuk  kepentingan PKBI dalam proses pemberian layanan, Pendidikan dan penelitian  tanpa menyebutkan data diri </div></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div align="justify"><span class="style15">III</span></div></td>
                            <td><p align="justify"><strong>Risiko</strong></p>
                            <p align="justify"> Dalam keadaan tertentu kegagalan pelayanan informasi dan atau konseling  dan atau konsultasi dan atau pengobatan yang dikarenakan masalah digital  (resolusi gambar, sinyal dan masalah digital lainnya) mungkin terjadi meskipun  jarang</p></td>
                          </tr>
                          <tr>
                            <td height="23" colspan="3"><ol>
                            <div align="justify"></div></td>
                          </tr>
                        </table>
                        <table width="516">
                          <tr>
                            <td width="506"><div align="justify">Melalui dokumen surat pernyataan dan persetujuan umum untuk semua  informasi dan layanan telemedicine ini saya  (sesuai nama yang ada di registrasi), telah membaca dan dengan sadar tanpa  paksaan &nbsp;memberikan kewenangan pada  petugas telemedicine PKBI untuk melakukan layanan informasi dan atau konseling  dan atau konsultasi dan atau pengobatan pada permasalahan medis dan atau non  medis&nbsp; dengan meng klik tanda/ kolom  setuju di bawah ini</div></td>
                          </tr>
                        </table>
                        <br>
                        <label class="control-label col-sm-3 pl-0"></label>
                        <input type="checkbox" name="inform-consent" v-model="consent" :disabled="jadwal_selected.length <= 0 || keluhan == '' || judul == ''">
                        <label id="inform-consent"> </label>
                        <label>Saya setuju dengan lembar persetujuan</label>
                        <br><br>
                  </div>
                </div>
            </div>
            <div class="form-group"> 
                <div class="controls col-sm-3 "></div>
                <div class="controls col-sm-9 ">
                    <input type="submit" :disabled="consent == false" name="submit" value="Kirim" class="btn btn-info">
                </div>
            </div>
        </form>
    </div>
    <div class='col-md-4 sidebar col-sm-12'>
		<?php include "sidebar.php"; ?>
	</div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue-timepicker/VueTimepicker.umd.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-select/vue-select.js') ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/vue-pagination/vue-pagination.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/tambah-konsultasi.js'); ?>"></script>