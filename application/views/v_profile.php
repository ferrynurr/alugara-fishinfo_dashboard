<?php
$this->load->view('template/head');
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                    <h2 class="x_title-h2">Profil Pengguna</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="content_head">              
                <form action="#" id="form_input" enctype="multipart/form-data">
                  
                    <div class="form-group">
                      <label for="nama_surveyor">Nama*</label>
                      <input type="text" class="form-control" name="nama_surveyor" id="nama_surveyor" placeholder="Masukan Nama..." required>
                    </div>
                    <div class="form-group">
                      <label for="status_pegawai">Golongan</label><br/>
                      <select class="select2-pilih" id="status_pegawai" name="status_pegawai" style="width: 50%">
                         <option value=""></option>
                         <option value="pns1">PNS - Gol 1</option> 
                         <option value="pns2">PNS - Gol 2</option>
                         <option value="pns3">PNS - Gol 3</option> 
                         <option value="pns4">PNS - Gol 4</option>
                         <option value="non-pns">NON - PNS</option>
                      </select>
                    </div> 
                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat..."></textarea>
                    </div>
                    <div class="form-group">
                      <label for="kota">Kota</label><br/>
                      <select class="select2-pilih" id="kode_kota" name="kode_kota" style="width: 50%">
                         <option value=""></option>
                         <?php
                          foreach ($data_kota->result() as $row) {
                            echo '<option value="'.$row->kode_kota.'">'.$row->nama_kota.'</option>';
                          }

                         ?>
                        
                      </select>
                    </div> 
                    <div class="form-group">
                      <label for="no_telp">No.Telpon/Hp</label>
                      <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukan No.Telpon/HP..." >
                    </div>
                    <div class="form-group">
                      <label for="email_surveyor">E-mail</label>
                      <input type="email" class="form-control" name="email_surveyor" id="email_surveyor" placeholder="Masukan E-mail..." >
                    </div>
                    <div class="form-group">
                      <label for="nip">NIP</label>
                      <input type="text" class="form-control" name="nip" id="nip" placeholder="Masukan NIP..." >
                    </div>
                    <div class="form-group">
                      <label for="npwp">NPWP</label>
                      <input type="text" class="form-control" name="npwp" id="npwp" placeholder="Masukan NPWP..." >
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                    </div>
                </form>  
              </div>
            </div>
        </div> <!-- x_panel -->
    </div> <!-- col-md -->    
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                    <h2 class="x_title-h2">Ubah Kata Sandi</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="content_head">              
                <form action="#" id="form_inputLogin" enctype="multipart/form-data">
                    
                    <div class="form-group">
                      <label for="kode_surveyor">Kode</label>
                      <input type="text" class="form-control" name="kode_surveyor" id="kode_surveyor" value="<?= $this->session->userdata('kode_surveyor') ?>" readonly>
                    </div>                
                    <div class="form-group">
                      <label for="passwd_new">Kata Sandi Baru</label>
                      <input type="password" class="form-control" name="passwd_new" id="passwd_new" placeholder="Masukan Kata Sandi baru..." onkeyup="check_sandi()" required>
                      <div id="info_sandi1"></div>
                    </div>
                    <div class="form-group">
                      <label for="passwd_new_conf">Konfirmasi Kata Sandi Baru</label>
                      <input type="password" class="form-control" name="passwd_new_conf" id="passwd_new_conf" placeholder="Konfirmasi Kata Sandi baru..." onkeyup="check_sandi()" required>
                      <div id="info_sandi2"></div>
                    </div>
                    <div class="pull-right">
                        <button id="btn_lgSave" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                    </div>
                </form>  
              </div>
            </div>
        </div> <!-- x_panel -->
    </div> <!-- col-md -->
  </div>
</div>
<!-- /page content -->

<script type="text/javascript">

  $(document).ready(function() {
      $.ajax({
              url : "<?= base_url('dashboard/get_user')?>",
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                  $('[name="nama_surveyor"]').val(data.nama_surveyor);                      
                  $('[name="status_pegawai"]').val(data.status_pegawai).trigger('change');
                  $('[name="alamat"]').val(data.alamat);
                  $('[name="no_telp"]').val(data.no_telp);
                  $('[name="email_surveyor"]').val(data.email_surveyor);
                  $('[name="nip"]').val(data.nip);
                  $('[name="npwp"]').val(data.npwp);
                  $('[name="kode_kota"]').val(data.kode_kota).trigger('change');

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
      });

      $("#btn_lgSave").attr('disabled', true);
      $("#pengaturan_nav").addClass('active');
  });

  $('#form_input').submit(function(e)
  {
      e.preventDefault(); 
      $.ajax({
          url : '<?php echo base_url('dashboard/update_profile/bio')?>',
          type: 'POST',
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache: false,
          async: false,
          dataType: 'json',
          success: function(data)
          {
              if(data.status) //if success close modal and reload ajax table
              {
                
                  Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Data saved successfully ',
                      showConfirmButton: false,
                      timer: 1600
                  });

                  setTimeout(function(){
                    reload_table();
                  }, 1500);
              }
            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
                  Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Failed to save data',
                      showConfirmButton: false,
                      timer: 1600
                  })
          }

      });

  });

  $('#form_inputLogin').submit(function(e)
  {
          e.preventDefault(); 
          $.ajax({
              url : '<?php echo base_url('dashboard/update_profile/login')?>',
              type: 'POST',
              data: new FormData(this),
              processData: false,
              contentType: false,
              cache: false,
              async: false,
              dataType: 'json',
              success: function(data)
              {
                  if(data.status) //if success close modal and reload ajax table
                  {
                    
                      Swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Data saved successfully ',
                          showConfirmButton: false,
                          timer: 1600
                      });

                      setTimeout(function(){
                        reload_table();
                      }, 1500);
                  }
                
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                      Swal.fire({
                          position: 'center',
                          icon: 'error',
                          title: 'Failed to save data',
                          showConfirmButton: false,
                          timer: 1600
                      })
              }

          });


  });

 function check_sandi() 
 {
  
   var pswd1 = $("#passwd_new").val();
   var pswd2 = $("#passwd_new_conf").val();

   if(pswd2 != pswd1)
   {
      $("#info_sandi1").html('<span style="color: red;"><i class="fa fa-times" aria-hidden="true"></i> Tidak Sesuai</span>'); 
      $("#info_sandi2").html('<span style="color: red;"><i class="fa fa-times" aria-hidden="true"></i> Tidak Sesuai</span>');
      $("#btn_lgSave").attr('disabled', true);

   }else{
      $("#info_sandi1").html('<span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i> Sesuai</span>'); 
      $("#info_sandi2").html('<span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i> Sesuai</span>');
      $("#btn_lgSave").attr('disabled', false);
   }
   

 }

</script>

<?php
$this->load->view('template/foot');
?>
