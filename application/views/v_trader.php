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
                             <li><a onclick="excel_export('tb_traderr', 'Laporan Data <?= $title ?>')">Download Excel</a></li> 
                             <li><a onclick="pdf_export('tb_traderr', 'Laporan Data <?= $title ?>')">Download PDF</a></li> 
                          </ul>
                      </div>
                      <table id="tb_traderr" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                           <!-- <th width="4%">#</th> -->
                            <th>No</th>
                            <th>Kode Trader</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Pemilik</th>
                            <th>#</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            foreach ($data->result() as $val) {
                              $no++;

                              echo '<tr>';
                              //echo '<td><input type="checkbox" class="delete_checkbox" value="'.$val->trader_id.'" /></td>';
                              echo '<td>'.$no.'</td>';
                              echo '<td>'.$val->trader_id.'</td>'; 
                              echo '<td>'.$val->nama_trader.'</td>'; 
                              echo '<td>'.$val->alamat_trader.'</td>';
                              echo '<td>'.$val->nama_kota.'</td>';
                              echo '<td>'.$val->telp_trader.'</td>';
                              echo '<td>'.$val->email_trader.'</td>';
                              echo '<td>'.$val->pemilik_trader.'</td>';
                              echo '<td>
                                      <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->trader_id."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                                      <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->trader_id."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    </td>';
                                
                              echo '</tr>';

                            }
                          ?>
                       
                        </tbody>
                        <!--<tfoot>
                          <tr>
                            <th><button type="button" name="delete_all" id="delete_all" onclick="delete_check('dash_trader', 'trader_id')" class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</button></th>
                          </tr>
                        </tfoot>-->
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
          <form action="#" id="form_trader" class="form-horizontal">
            <div class="modal-body row">        
              <div class="col-sm-10 col-sm-offset-1" >
                  <input type="hidden" id="trader_id" name="trader_id">
                  <div class="form-group">
                    <label class="control-label ">Nama Trader :</label><br/>
                    <input type="text" id="nama_trader" name="nama_trader" class="form-control" placeholder="Masukan Nama Trader ..." required> 
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Alamat :</label><br/>
                    <textarea type="text" id="alamat_trader" name="alamat_trader" class="form-control" placeholder="Masukan Alamat Trader ..."></textarea> 
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Kota :</label><br/>
                    <select id="kode_kota" name="kode_kota" class="select2-modal" style="width: 100%"> 
                      <option value=""></option>
                      <?php
                        foreach ($data_kota->result() as $row) {
                          echo '<option value="'.$row->kode_kota.'">'.$row->nama_kota.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label "> Telepon:</label><br/>
                    <input type="text" id="telp_trader" name="telp_trader" class="form-control" placeholder="Masukan No.Telepon/HP Trader ..."> 
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Email :</label><br/>
                    <input type="email" id="email_trader" name="email_trader" class="form-control" placeholder="Masukan E-mail Trader ..."> 
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Nama Pemilik :</label><br/>
                    <input type="text" id="pemilik_trader" name="pemilik_trader" class="form-control" placeholder="Masukan Nama Pemilik ..."> 
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
     
    $('#tb_traderr').DataTable({
       "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All Data"]],
        "order": [[ 1, "asc" ]]
    });
    $("#trader_nav").addClass('active');
       
  });


  function add_data()
  {
    save_method = 'add';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Tambah Trader');
    $('#form_trader input[type="text"]').val('');
    $('#form_trader input[type="email"]').val('');
    $('#form_trader textarea').val('');
    $('#form_trader .select2-modal').val('').trigger('change');
  }

  function get_data(id)
  {
    save_method = 'update';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit Trader');

    $.ajax({
            url : "<?= base_url('trader/ajax_get')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('#form_trader #trader_id').val(data.trader_id);
              $('#form_trader #nama_trader').val(data.nama_trader);
              $('#form_trader #alamat_trader').val(data.alamat_trader);
              $('#form_trader #kode_kota').val(data.kode_kota).trigger('change');
              $('#form_trader #telp_trader').val(data.telp_trader);
              $('#form_trader #email_trader').val(data.email_trader);
              $('#form_trader #pemilik_trader').val(data.pemilik_trader);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error getting data');
            }
    });
   
  }
 
  $('#form_trader').submit(function(e){
      e.preventDefault(); 

          if(save_method == 'add')
          {
              url = "<?php echo base_url('trader/ajax_add')?>";

          }else if(save_method == 'update'){
              url = "<?php echo base_url('trader/ajax_update')?>";

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
                url : "<?= base_url('trader/ajax_delete')?>/"+id,
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
    window.location.href= '<?= base_url('trader') ?>';
  }

</script>

<?php
$this->load->view('template/foot');
?>
