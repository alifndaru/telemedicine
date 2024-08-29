<?php
if ($this->session->flashdata('error')) {
    echo "<div class='alert alert-danger'>" . $this->session->flashdata('error') . "</div>";
}
echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Voucher</h3>
                </div>
              <div class='box-body'>";
$attributes = array('class' => 'form-horizontal', 'role' => 'form');
echo form_open_multipart('administrator/tambah_voucher', $attributes);
echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Code Voucher</th>    
                    <td><input type='text' class='form-control' name='kode_voucher' required></td></tr>
                    <tr><th width='120px' scope='row'>Start Date</th>    
                    <td><input type='date' class='form-control' name='start_date' required></td></tr>
                    <tr><th width='120px' scope='row'>End Date</th>    
                    <td><input type='date' class='form-control' name='end_date' required></td></tr>
                    <tr><th scope='row'>Aktif</th>                          
                    <td><input type='radio' name='aktif' value='Y' checked> Ya &nbsp; <input type='radio' name='aktif' value='N'> Tidak</td></tr>
                   </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                  </div>
            </div></div></div>";
echo form_close();
