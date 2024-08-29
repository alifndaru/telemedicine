<?php
echo "<div class='col-md-12'>
    <div class='box box-info'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Edit Voucher</h3>
        </div>
        <div class='box-body'>";
if ($this->session->flashdata('error')) {
    echo "<div class='alert alert-danger'>" . $this->session->flashdata('error') . "</div>";
}
$attributes = array('class' => 'form-horizontal', 'role' => 'form');
echo form_open_multipart('administrator/edit_voucher', $attributes);
echo "<div class='col-md-12'>
    <table class='table table-condensed table-bordered'>
    <tbody>
        <input type='hidden' name='voucher_id' value='" . $voucher['voucher_id'] . "'>
        <tr><th width='120px' scope='row'>Kode Voucher</th><td><input type='text' class='form-control' name='kode_voucher' value='" . $voucher['kode_voucher'] . "' required></td></tr>
        <tr><th scope='row'>Start Date</th><td><input type='date' class='form-control' name='start_date' value='" . $voucher['start_date'] . "' required></td></tr>
        <tr><th scope='row'>End Date</th><td><input type='date' class='form-control' name='end_date' value='" . $voucher['end_date'] . "' required></td></tr>
        <tr><th scope='row'>Aktif</th><td>";
if ($voucher['aktif'] == 'Y') {
    echo "<input type='radio' name='aktif' value='Y' checked> Ya &nbsp; <input type='radio' name='aktif' value='N'> Tidak";
} else {
    echo "<input type='radio' name='aktif' value='Y'> Ya &nbsp; <input type='radio' name='aktif' value='N' checked> Tidak";
}
echo "</td></tr>
        <tr><th width='120px' scope='row'>Nilai Persentase</th>    
        <td><input type='number' class='form-control' name='nilai' value='" . $voucher['nilai'] . "' required min='0' max='100' step='0.01' placeholder='0-100%'></td></tr>
    </tbody>
    </table>
</div>
<div class='box-footer'>
    <button type='submit' name='submit' class='btn btn-info'>Update</button>
    <a href='" . base_url('administrator/voucher') . "'><button type='button' class='btn btn-default pull-right'>Batal</button></a>
</div>
</div></div></div>";
echo form_close();
