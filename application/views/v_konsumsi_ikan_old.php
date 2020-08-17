<?php
$this->load->view('template/head');
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
?>

<style type="text/css">
  .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    margin-left: 4px;
  }



</style>

<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                    <h2 class="x_title-h2"><?= $title ?></h2>
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
                  <div class="pull-left">
                      <button id="btn_refresh" class="btn btn-default btn-sm" onclick="refresh()"> <i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>                           
                  </div>
                  <div class="pull-right">
                      <button id="btn_add" class="btn btn-success btn-sm" onclick="add_data()"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah</button> 
                      <button class="btn btn-warning btn-sm" onclick="show_import()"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Unggah</button>
                      <button class="btn btn-primary btn-sm" onclick="show_export()"> <i class="fa fa-download" aria-hidden="true"></i> Unduh</button>                          
                  </div>
                </div> 
                <br/> <br/>
                <ul class="nav nav-tabs">
                  <li id="li_table" role="presentation"><a href="#" onclick="show_list()"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                  <li id="li_pivot" role="presentation"><a href="#" onclick="show_pivot()"><i class="fa fa-table" aria-hidden="true"></i> Pivot</a></li>
                  <li id="li_grafik" role="presentation"><a href="#" onclick="show_grafik()"><i class="fa fa-bar-chart" aria-hidden="true"></i> Grafik</a></li>
                </ul>

                <?php
                  $this->load->view('konsumsi_ikan/grafik');
                  $this->load->view('konsumsi_ikan/table');
                ?>
                           
            </div>
        </div> <!-- x_panel -->
    </div> <!-- col-md -->    
  </div>
</div>
<!-- /page content -->

 <!-- modal tambah -->
    <div class="modal fade" id="modal_add" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title"></h3>
          </div>
          <form action="#" id="form_input" class="form-horizontal">
            <div class="modal-body">        
                  <input type="hidden" id="konsumsi_id" name="konsumsi_id">
                  <div class="form-group">
                    <label class="control-label ">Kota/Kab*</label><br/>
                    <select id="kode_kota" name="kode_kota" class="select2-modal" style="width: 100%" required> 
                      <option value=""></option>
                      <?php
                        foreach ($data_kota->result() as $row) {
                          echo '<option value="'.$row->kode_kota.'">'.$row->nama_kota.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label "> Tahun*</label><br/>
                    <input type="number" id="tahun" name="tahun" class="form-control tahun" placeholder="yyyy" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label "> Jumlah penduduk*</label><br/>
                    <input type="number" id="jum_penduduk" name="jum_penduduk" class="form-control" placeholder="masukan jumlah penduduk ..." onkeyup="hitung_kebutuhanIkan()" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label "> Konsumsi Ikan (kg/kapita/tahun)* </label><br/>
                    <input type="number" id="jum_konsumsi" name="jum_konsumsi" class="form-control" placeholder="masukan angka konsumsi ikan ..." onkeyup="hitung_kebutuhanIkan()" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label"> Kebutuhan Ikan (kg) </label><br/>
                    <input type="number" id="kebutuhan" name="kebutuhan" class="form-control" readonly>
                  </div>
              
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="ion ion-android-done-all" aria-hidden="true"></i> Simpan</button>             
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div> <!-- end modal -->

 <!-- modal unduh -->
   <div class="modal fade" id="modal_export" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title"></h3>
          </div>
          <form action="<?= base_url('Konsumsi_ikan/export') ?>" method="POST" class="form-horizontal" id="form_export">
            <div class="modal-body">  
                <div class="form-group">
                  <label class="control-label">Kota/Kab*</label><br/>
                  <select id="kode_kota" name="kode_kota" class="select2-modal" style="width: 100%" required> 
                    <option value=""></option>
                    <option value="all"> -- Semua Kab/Kota --</option>
                    <?php
                      foreach ($data_kota->result() as $row) {
                        echo '<option value="'.$row->kode_kota.'">'.$row->nama_kota.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label "> Tahun</label><br/>
                  <input type="number" id="tahun" name="tahun" class="form-control tahun" placeholder="yyyy">
                </div>
     
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i> Unduh</button>             
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div> <!-- end modal -->


<script type="text/javascript">

 var save_method;
 $(document).ready(function() {
     
    $('#tb_konsumsi_ikan').DataTable({});
    $("#ketersediaan_nav").addClass('active');
   // alert(filter_group);
   
    
    $("#tab_table").show();
    $("#li_table").addClass('active');
    $("#tab_grafik").hide();


    // ------------ END --------------

       
  });

  function hitung_kebutuhanIkan()
  {
    var x   = $('#jum_penduduk').val();
    var y   = $('#jum_konsumsi').val();

    var jum = y * x;
    $('#kebutuhan').val(jum);

  }


  function add_data()
  {
    save_method = 'add';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Tambah Konsumsi Ikan');
    $('#form_input input[type="text"]').val('');
    $('#form_input input[type="number"]').val('');
    $('#form_input .select2-modal').val('').trigger('change');
  }

  function get_data(id)
  {
    save_method = 'update';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit Konsumsi Ikan');

    $.ajax({
            url : "<?= base_url('Konsumsi_ikan/ajax_get')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('#form_input #konsumsi_id').val(data.konsumsi_id);
              $('#form_input #kode_kota').val(data.kode_kota).trigger('change');
              $('#form_input #tahun').val(data.tahun);
              $('#form_input #jum_penduduk').val(data.jum_penduduk);
              $('#form_input #jum_konsumsi').val(data.jum_konsumsi);
              $('#form_input #kebutuhan').val(data.kebutuhan);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error getting data');
            }
    });
   
  }

  $('#form_input').submit(function(e){
      e.preventDefault(); 

          if(save_method == 'add')
          {
              url = "<?php echo base_url('Konsumsi_ikan/ajax_add')?>";

          }else if(save_method == 'update'){
              url = "<?php echo base_url('Konsumsi_ikan/ajax_update')?>";

          }

          $.ajax({
              url : url,
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
                    $('#modal_add').modal('hide');
                     
                     Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Data saved successfully',
                      showConfirmButton: false,
                      timer: 1600
                    })

                      setTimeout(refresh, 1000);

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

  function delete_data(id)
  {
      Swal.fire({
        title: 'Yakin Ingin Hapus ?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url : "<?= base_url('Konsumsi_ikan/ajax_delete')?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status) //if success close modal and reload ajax table
                   {

                     Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )

                    setTimeout(refresh, 1000);
                     
                   }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        
        }
      })
  }


  function show_export()
  {
    $('#modal_export').modal('show');
    $('#modal_export .modal-title').text('Filter Unduh Data');
    $('#form_export input[type="text"]').val('');
    $('#form_export input[type="number"]').val('');
    $('#form_export .select2-modal').val('').trigger('change');
  }

  function show_list()
  {
     $("#tab_table").show();
     $("#tab_grafik").hide();
     $("#li_table").addClass('active');
     $("#li_grafik").removeClass('active');
  }

  function show_grafik()
  {
     $("#tab_table").hide();
     $("#tab_grafik").show();
     $("#li_table").removeClass('active');
     $("#li_grafik").addClass('active');

  }

  function refresh()
  {
    window.location.href= '<?= base_url('konsumsi_ikan') ?>';
    // table.ajax.reload(null,false); //reload datatable ajax
  }

</script>

<?php
$this->load->view('template/foot');
?>
