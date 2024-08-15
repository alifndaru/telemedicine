<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>LIhat Pesan Masuk</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart('administrator/detail_pesanmasuk/'.$rows['id_hubungi'],$attributes); 
          echo "<div class='col-md-12'>";
                    if (isset($_POST['submit'])){
                       echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button> <strong>Success!</strong> - Email success Terkirim ke $_POST[b].
                              </div>";
                    }
                  echo "<table class='table table-condensed table-bordered'>
                  <tbody>

                    <tr><th width='120' scope='row'>Nama Pengirim</th>  <td><input type='text' class='form-control' name='a' value='$rows[nama]' readonly='on'></td></tr>
                    <tr><th width='120' scope='row'>Email Pengirim</th> <td><input type='text' class='form-control' name='b' value='$rows[email]' readonly='on'></td></tr>
                   
                    <tr><th scope='row'>Isi Pesan</th>                    <td><textarea class='form-control' name='isi' style='height:120px'  readonly='on'>$rows[pesan]</textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    
                    
                  </div>
            </div></div></div>";
            echo form_close();