<?php
$this->load->view('template/head');
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
?>

<style type="text/css">

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
                      <button id="btn_add" class="btn btn-success btn-sm" onclick="add_data()"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>                           
                  </div>
                  <div class="pull-right">   
                      <button type="button" class="btn btn-info btn-sm" onclick="show_import('<?= $halaman ?>')"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Unggah</button>                      
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive" style="padding: 10px;">
                      <br/>
                      <div class="btn-group" style="padding-bottom: 10px;">
                          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                             <li><a onclick="excel_export('tb_komoditaskel', 'Laporan Data <?= $title ?>')">Download Excel</a></li> 
                             <li><a onclick="pdf_export('tb_komoditaskel', 'Laporan Data <?= $title ?>')">Download PDF</a></li> 
                          </ul>
                      </div>
                      <table id="tb_komoditaskel" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>ID Kelompok</th>
                            <th>Kelompok</th>
                            <th>Jenis</th>
                            <th>#</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            foreach ($data->result() as $val) {
                              $no++;
                              $jenis_name='';

                              if($val->jenis_tabel == 'dom_masuk')
                                $jenis_name = 'Domestik Masuk';
                              elseif($val->jenis_tabel == 'dom_keluar')
                                $jenis_name = 'Domestik Keluar';
                              elseif($val->jenis_tabel == 'ekspor')
                                $jenis_name = 'Ekspor';
                              elseif($val->jenis_tabel == 'impor')
                                $jenis_name = 'Impor';

                              echo '<tr>';
                              echo '<td>'.$no.'</td>';
                              echo '<td>'.$val->komoditas_kel_id.'</td>';
                              echo '<td>'.$val->nama_komoditas_kel.'</td>';
                              echo '<td>'.$jenis_name.'</td>';
                              echo '<td>
                                      <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->komoditas_kel_id."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                                      <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->komoditas_kel_id."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    </td>';
                                
                              echo '</tr>';

                            }
                          ?>
                       
                        </tbody>
                      </table>
                    </div>  
                  </div>
                </div>               
            </div>         
        </div> <!-- x_panel -->
    </div> <!-- col-md -->    
  </div>
</div>
<!-- /page content -->

 <!-- modal save favorite -->
    <div class="modal fade" id="modal_add" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title"></h3>
          </div>
          <form action="#" id="form_komoditaskel" class="form-horizontal">
            <div class="modal-body row">        
              <div class="col-sm-10 col-sm-offset-1" >
                  <input type="hidden" id="komoditas_kel_id" name="komoditas_kel_id">
                  <div class="form-group">
                    <label class="control-label ">Nama Kelompok :</label><br/>
                    <input type="text" id="nama_komoditas_kel" name="nama_komoditas_kel" class="form-control" placeholder="Masukan Nama Kelompok Komoditas ..." required> 
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Jenis:</label><br/>
                    <select id="jenis_tabel" name="jenis_tabel" class="select2-modal" style="width: 100%" required> 
                        <option value=""></option>
                        <option value="dom_masuk">Domestik Masuk</option> 
                        <option value="dom_keluar">Domestik Keluar</option> 
                        <option value="ekspor">Ekspor</option> 
                        <option value="impor">Impor</option>

                       
                      </select>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="ion ion-android-done-all" aria-hidden="true"></i> Save</button>             
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div> <!-- end modal -->


<script type="text/javascript">


var save_method;

 $(document).ready(function() {
     
    $('#tb_komoditaskel').DataTable({
       "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All Data"]],
       "columnDefs": [
                        { "width": "20%", "targets": 2 },
                        { "width": "10%", "targets": 0 }
                     ],
    });
    $("#komokel_nav").addClass('active');
       
  });


  function add_data()
  {
    save_method = 'add';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Tambah Kelompok Komoditas');
    $('#form_komoditaskel input[type="text"]').val('');
    $('#form_komoditaskel #jenis_tabel').val('').trigger('change');
  }

  function get_data(id)
  {
    save_method = 'update';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit Kelompok Komoditas');

    $.ajax({
            url : "<?= base_url('komoditas_kelompok/ajax_get')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

              $('#form_komoditaskel #nama_komoditas_kel').val(data.nama_komoditas_kel);
              $('#form_komoditaskel #komoditas_kel_id').val(data.komoditas_kel_id);
               $('#form_komoditaskel #jenis_tabel').val(data.jenis_tabel).trigger('change');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error getting data');
            }
    });
   
  }
 
  $('#form_komoditaskel').submit(function(e){
      e.preventDefault(); 

          if(save_method == 'add')
          {
              url = "<?php echo base_url('komoditas_kelompok/ajax_add')?>";

          }else if(save_method == 'update'){
              url = "<?php echo base_url('komoditas_kelompok/ajax_update')?>";

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
                url : "<?= base_url('komoditas_kelompok/ajax_delete')?>/"+id,
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


  function refresh()
  {
    window.location.href= '<?= base_url('komoditas_kelompok') ?>';
  }

</script>

<?php
$this->load->view('template/foot');
?>
