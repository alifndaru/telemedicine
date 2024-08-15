<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Banner Link</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart('administrator/edit_banner',$attributes); 
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$rows[id_banner]'>
                    <tr><th scope='row'>Main Menu</th>               <td><select name='aa' class='form-control' required>
                                                                            <option value='' selected>- Pilih -</option>";
                                                                            $record = $this->model_app->view('banner_kategori');
                                                                            foreach ($record->result_array() as $row){
                                                                              if ($rows['id_banner_kategori']==$row['id_banner_kategori']){
                                                                                echo "<option value='$row[id_banner_kategori]' selected>$row[banner_kategori]</option>";
                                                                              }else{
                                                                                echo "<option value='$row[id_banner_kategori]'>$row[banner_kategori]</option>";
                                                                              }
                                                                            }
                    echo "</td></tr>
                    <tr><th width='120px' scope='row'>Judul</th>    <td><input type='text' class='form-control' name='a' value='$rows[judul]' required></td></tr>
                    <tr><th width='120px' scope='row'>Url</th>    <td><input type='url' class='form-control' name='b' value='$rows[url]' required></td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='index.php'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();
