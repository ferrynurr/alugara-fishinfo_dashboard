<?php
$this->load->view('template/head');
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
?>

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
              <form action="<?= base_url('non_konsumsi') ?>" method="POST" id="form_filter">
                <div class="content_head row"> 
                    <div class="col-lg-5">
                       <button type="button" class="btn btn-default btn-sm" onclick="refresh()"> <i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button> 
                        <button type="button" class="btn btn-info btn-sm" onclick="show_import('<?= $halaman ?>')"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Unggah</button>
                       
                    </div>
                    <div class="col-lg-7">
                      <div class="row">
                        <div class="col-lg-10 col-xs-6 text-right">
                            <select class="select2" id="filter_all" name="filter_all[]" multiple="" style="width: 100%;">
                                <option value=""></option>  
                            </select> <br/>
                            <div class="pull-left">
                               <div class="btn-group" style="padding-bottom: 5px; padding-top: 5px;">
                                  <button type="button" class="btn btn-default" onclick="show_formFilter()"> Filters <span class="caret"></span>
                                  </button>
                                  <button type="button" class="btn btn-default" onclick="show_formGroup()"><span class="badge" id="count_group"></span> Group by <span class="caret"></span>
                                  </button>

                                  <button type="button" class="btn btn-default" onclick="showModal_Getfav()"> Favourites <span class="caret"></span>
                                  </button>
                               </div>
                             </div>
                        </div>
                        <div class="col-lg-2 col-xs-6 text-left">
                            <button id="btn_refresh" class="btn btn-primary btn-sm" type="submit"> <i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                        </div>
                      </div>
                       <div class="panel panel-info" id="panel_filter" style="display: none;">
                          <div class="panel-heading">
                              <div class="row">
                                  <div class="col-lg-4">
                                    <select style="width: 100%;" class="select2" id="filter_field" name="filter_field">
                                      <option value=""></option>
                                     <?php 
                                        foreach ($list_field->result() as $row)
                                        {
                                          echo '<option value="'.$row->data_type."|".$row->field."|".$row->label.'"> '.$row->label.' </option>';
                                        } 

                                        ?>
                                    </select>
                                  </div>           
                                  <div class="col-lg-8">
                                      <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" style="width: 100%;" name="filter_opr" id="filter_opr">
                                              <option value="=">=</option>
                                              <option value="like">like</option>
                                              <option value="!=">!=</option>
                                              <option value=">">></option>
                                              <option value="^"><</option>                                          
                                            </select> 
                                        </div>
                                        <div class="col-md-8">                       
                                           <div class="input-group">
                                              <input type="text" name="filter_val" id="filter_val" class="form-control" placeholder="Masukan filter ....">
                                              <span class="input-group-btn">
                                                <button class="btn btn-success" type="button" onclick="add_filterAll()"><i class="fa fa-search-plus" aria-hidden="true"></i></button>
                                              </span>
                                            </div><!-- /input-group -->
                                        </div>
                                      </div>
                                  </div>

                              </div> <!-- / .row -->                   
                          </div>
                        </div> <!-- panel -->

                        <div class="panel panel-info" id="panel_group" style="display: none;">
                          <div class="panel-heading">
                             <select id="selected_group" name="selected_group[]" multiple class="select2-group" style="width: 100%">
                                <option value=""></option>
                                 <?php 
                                        foreach ($group_field->result() as $row)
                                        {
                                          echo '<option value="'.$row->field.'"> '.$row->label.' </option>';
                                        } 

                                        ?>
                              </select>
                          </div>
                        </div>
                    </div>

                </div> <!-- end content head -->

              <!-- </form> -->
                <ul class="nav nav-tabs">
                  <li id="li_table" role="presentation"><a href="#" onclick="show_list()"><i class="fa fa-list" aria-hidden="true"></i> List</a></li>
                  <li id="li_pivot" role="presentation"><a href="#" onclick="show_pivot()"><i class="fa fa-table" aria-hidden="true"></i> Pivot</a></li>
                  <li id="li_grafik" role="presentation"><a href="#" onclick="show_grafik()"><i class="fa fa-bar-chart" aria-hidden="true"></i> Bar</a></li>
                  <li id="li_pie" role="presentation"><a href="#" onclick="show_pie()"><i class="fa fa-pie-chart" aria-hidden="true"></i> Pie</a></li>
                </ul>

                <?php
                  $this->load->view('non_konsumsi/grafik');
                  $this->load->view('non_konsumsi/table');
                  $this->load->view('non_konsumsi/pivot');
                  $this->load->view('non_konsumsi/pie');
                ?>
              </form>          
            </div>
        </div> <!-- x_panel -->
    </div> <!-- col-md -->    
  </div>
</div>
<!-- /page content -->

 <!-- modal -->
    <div class="modal fade" id="modal_add" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title"></h3>
          </div>
          <form action="#" id="form_input" class="form-horizontal">
            <div class="modal-body">
              <div class="row">
                  <div class="col-sm-6" >
                      <input type="hidden" id="kode_survey_nonkonsumsi" name="kode_survey_nonkonsumsi">
                      <div class="form-group">
                        <label class="control-label ">Tanggal*</label><br/>
                        <input type="text" name="tanggal" id="tanggal" class="form-control datepicker" placeholder="YYYY-MM-DD" required>
                      </div>

                      <div class="form-group">
                        <label class="control-label ">Pengusaha/Perusahaan*</label><br/>
                        <select id="kode_pengusaha" name="kode_pengusaha" class="select2-modal" style="width: 100%" required> 
                          <option value=""></option>
                          <?php
                            foreach ($data_pengusaha->result() as $row) {
                              echo '<option value="'.$row->kode_pengusaha.'">'.$row->nama_perusahaan.' ('.$row->no_registrasi.')</option>';
                            }
                          ?>
                        </select>
                      </div>           
                      <div class="form-group">               
                          <label class="control-label ">Harga (Rp/ekor)</label><br/>
                          <input type="number" id="harga" name="harga" class="form-control" value="0">
                      </div>
                      <div class="form-group">               
                          <label class="control-label ">Harga (Rp/kg)</label><br/>
                          <input type="number" id="harga_kg" name="harga_kg" class="form-control" value="0">
                      </div>
                      <div class="form-group">               
                          <label class="control-label ">Harga (Rp/l)</label><br/>
                          <input type="number" id="harga_l" name="harga_l" class="form-control" value="0">
                      </div>
                      <div class="form-group">               
                          <label class="control-label ">Omzet (Rp/bulan)*</label><br/>
                          <input type="number" id="omset" name="omset" class="form-control" value="0" required>
                      </div>
                  </div>
                  <div class="col-sm-6">            
                      <div class="form-group">
                            <label for="tujuan_jatim">Tujuan Jawa Timur</label><br/>      
                            <select name="tujuan_jatim[]" id="tujuan_jatim" multiple="multiple" class="form-control select2" style="width:100%">
                                <?php foreach($tujuan_jatim->result() as $kjt) : ?>
                                <option value="<?php echo $kjt->nama_kota ?>"><?php echo $kjt->nama_kota?></option>
                                <?php endforeach ?>
                            </select>
                                 
                      </div>        
                      <div class="form-group">
                            <label for="tujuan_luar_jatim">Tujuan Luar Jawa Timur</label><br/>     
                            <select name="tujuan_luar_jatim[]" id="tujuan_luar_jatim" multiple="multiple" class="form-control select2" style="width:100%">
                                <?php foreach($tujuan_luar_jatim->result() as $kjt) : ?>
                                <option value="<?php echo $kjt->nama_provinsi ?>"><?php echo $kjt->nama_provinsi ?></option>
                                <?php endforeach ?>
                            </select>
                                 
                      </div>
                      <div class="form-group">
                            <label for="tujuan_luar_negeri">Tujuan Luar Negeri</label><br/>
                             <select name="tujuan_luar_negeri[]" id="tujuan_luar_negeri" multiple="multiple" class="form-control select2" style="width:100%">
                                <?php foreach($tujuan_luar_negeri->result() as $kjt) : ?>
                                <option value="<?php echo $kjt->nama_negara ?>"><?php echo $kjt->nama_negara ?></option>
                                <?php endforeach ?>
                            </select>
                                  
                      </div>
                    
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

 var filter_all = <?= json_encode($filter_all) ?>;
 var selected_group = <?= json_encode($selected_group) ?>;

 $(document).ready(function() {
     
    $('#tb_nonkonsumsi').DataTable({
         "columnDefs": [
                          { "width": "3%", "targets": 0 }
          ],
         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All Data"]],
         "searching": false
        
    });
    $("#nonkonsumsi_nav").addClass('active');
   
    $("#tab_table").show();
    $("#li_table").addClass('active');
    $("#tab_grafik").hide();
    $("#tab_pivot").hide();
    $("#tab_pie").hide();

    // ------------ END --------------
    if(filter_all != '')
    {
        var valtex='';
        for (var i = filter_all.length - 1; i >= 0; i--) 
        {
          valtex = filter_all[i].split("|")[1];
          $('#filter_all').append('<option value="'+filter_all[i]+'" selected>'+valtex+'</option>');
          $('#fav_filter').append('<option value="'+filter_all[i]+'" selected>'+valtex+'</option>');
        }
      
    }

    if(selected_group != '')
    {
      $('#selected_group').val(selected_group);
      $('#fav_group').val(selected_group);
      $('#count_group').text($('#selected_group option:selected').length);

    }
       
  });


  function get_data(id)
  {

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit Non Konsumsi');

    $.ajax({
            url : "<?= base_url('non_konsumsi/ajax_get')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('#form_input #kode_survey_nonkonsumsi').val(data.kode_survey_nonkonsumsi);
              $('#form_input #tanggal').val(data.tanggal);
              $('#form_input #kode_pengusaha').val(data.kode_pengusaha).trigger('change');
              $('#form_input #harga').val(data.harga);
              $('#form_input #harga_kg').val(data.harga_kg);
              $('#form_input #harga_l').val(data.harga_l);
              $('#form_input #omset').val(data.omset);
              $('#form_input #tujuan_jatim').val(data.tujuan_jatim.split(",")).trigger('change');
              $('#form_input #tujuan_luar_jatim').val(data.tujuan_luar_jatim.split(",")).trigger('change');
              $('#form_input #tujuan_luar_negeri').val(data.tujuan_luar_negeri.split(",")).trigger('change');
              
  
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error getting data');
            }
    });
   
  }

  $('#form_input').submit(function(e){
      e.preventDefault(); 

          $.ajax({
              url : '<?php echo base_url('non_konsumsi/ajax_update')?>',
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
                      timer: 1000
                    })

                      setTimeout(refresh, 800);

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
                url : "<?= base_url('non_konsumsi/ajax_delete')?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status) //if success close modal and reload ajax table
                   {

  

                      Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your data has been deleted ..!',
                        showConfirmButton: false,
                        timer: 1300
                      })

                    setTimeout(refresh, 1300);
                     
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

  $('select[name="kom_kelompok"]').on('change', function() 
  {
      var id = $(this).val();
      $.ajax({
              url: "<?php echo site_url('dom_keluar/get_komoditas')?>/" + id,
              type: "GET",
              dataType: "json",

              success:function(data) {
                  $('select[name="komoditas_id"]').empty();

                  $.each(data, function(key, value) {
                    $('select[name="komoditas_id"]').append('<option value="'+ value.komoditas_id +'">'+ value.jenis_komoditas +'</option>');
                  });

                   $('select[name="komoditas_id"]').val($('#komoditas_bantu').val()).trigger('change');

              }

      });
  });


  function refresh()
  {
    window.location.href= '<?= base_url('non_konsumsi') ?>';
    // table.ajax.reload(null,false); //reload datatable ajax
  }

</script>

<?php
$this->load->view('template/modal_filter');
$this->load->view('template/foot');
?>
