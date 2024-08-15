<div id="slider" class="col-xs-12" style="padding-left: 0px; padding-right: 0px;">  
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> &nbsp; Banner Slider</h3>
            <hr>
        </div>
        <div class="box-body">
            <?php 
                $no = 1;
                foreach ($record as $row) { ?>
                    <div class='slider-title'><h4>Slider <?= $no; ?></h4></div>
                    <table class='table table-bordered table-striped'>
                        <tbody>
                            <tr>
                                <td width=120px>Image</td>
                                <td>
                                    <img class='thumbnail' style='margin-bottom: 5px !important;' width='300' :src="image<?=$no;?>">
                                    <input type="file" ref="file<?=$no;?>" v-model="file<?=$no;?>">
                                </td>
                            </tr>

                            <tr><td>Title</td><td><input type='text' v-model="title<?=$no;?>" class='form-control'></td></tr>
                            <tr><td>Sub Title</td><td><input type='text' v-model="subtitle<?=$no;?>" class='form-control'></td></tr>
                            <tr><td>Status</td><td>
                                <select class="status-slider" v-model="status<?=$no;?>">
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak aktif</option>
                                </select>
                            </td></tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <br>
                                    <button type='button' @click="submit(<?=$row['id'];?>)" class='btn btn-warning'>Update</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>
                <?php $no++; }
            ?>
        </div>
    </div>
</div>

<script src="<?php echo base_url('asset/admin/plugins/vue/vue.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/axios/axios.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/plugins/lodash/lodash.min.js'); ?>"></script>
<script src="<?php echo base_url('asset/admin/slider.js'); ?>"></script>