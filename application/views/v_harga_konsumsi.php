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
              <form action="<?= base_url('Harga_konsumsi/').$jenis ?>" method="POST" id="form_filter">
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
                  $this->load->view('harga_konsumsi/grafik');
                  $this->load->view('harga_konsumsi/table');
                  $this->load->view('harga_konsumsi/pivot');
                  $this->load->view('harga_konsumsi/pie');
                ?>
              </form>          
            </div>
        </div> <!-- x_panel -->
    </div> <!-- col-md -->    
  </div>
</div>
<!-- /page content -->

  <!-- modal edit -->
  <div class="modal fade" id="modal_add" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title"></h3>
        </div>
        <form action="#" id="form_input" class="form-horizontal">
          <div class="modal-body row">        
            <div class="col-sm-12" >
                <input type="hidden" id="kode_survey_pasar" name="kode_survey_pasar">
                <div class="form-group">
                  <label class="control-label ">Tanggal*</label><br/>
                  <input type="text" name="tanggal" id="tanggal" class="form-control datepicker" placeholder="YYYY-MM-DD" required>
                </div>
                <div class="form-group">
                  <label class="control-label ">Kota*</label><br/>
                  <select id="kode_kota" name="kode_kota" class="select2-modal" style="width: 100%" required> 
                    <option value=""></option>
                    <?php
                      foreach ($data_kota->result() as $row) {
                        echo '<option value="'.$row->kode_kota.'">'.$row->nama_kota.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <?php if($jenis == 'tb_list_eceran'){ ?>
                  <div class="form-group">
                    <label class="control-label ">Pasar*</label><br/>
                    <input type="hidden" name="pasar_bantu" id="pasar_bantu">
                    <select id="id_pasar" name="id_pasar" class="select2-modal" style="width: 100%"> 
                      <option value=""></option>
                    </select>
                  </div>
                  <?php } ?>                  
                <div class="form-group">
                  <label class="control-label ">Ikan*</label><br/>
                  <select id="kode_ikan" name="kode_ikan" class="select2-modal" style="width: 100%" required> 
                    <option value=""></option>
                    <?php
                      foreach ($data_ikan->result() as $row) {
                        echo '<option value="'.$row->kode_ikan.'">'.$row->nama_ikan.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label ">Volume (kg)*</label><br/>
                  <input type="number" name="volume" id="volume" class="form-control" value="0">
                </div>
                <div class="form-group">
                  <label class="control-label ">Harga (Rp/kg)*</label><br/>
                  <input type="number" name="harga" id="harga" class="form-control" value="0">
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
  var jenis_harga = <?= json_encode($jenis) ?>;

 $(document).ready(function() {

    $('#tb_harga_konsumsi').DataTable({
       "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All Data"]],
       "searching": false
    }); 


    if(jenis_harga == 'tb_list_eceran')
      $("#eceran_konsumsi_nav").addClass('active');
    else
      $("#grosir_konsumsi_nav").addClass('active');
    
    // alert(filter_group);
    
    $("#tab_table").show();
    $("#li_table").addClass('active');
    $("#tab_grafik").hide();
    $("#tab_pivot").hide();
    $("#tab_pie").hide();

    // ------- SET HISTORY FILTER ----

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
  /*  
    var theadArray = [];

    $('#tb_harga_konsumsi thead th').each(function() {
        theadArray.push($(this).text());
    });


    $('#modal_saveDash #thead').val(theadArray);
    $('#modal_saveDash #tbody').val(<?= json_encode($tbodyArray) ?>);
   */

    //alert(tbodyArray);

  });



  function get_data(id)
  {

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit Harga Konsumsi');

    $.ajax({
            url : "<?= base_url('harga_konsumsi/ajax_get')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

              $('#form_input #kode_survey_pasar').val(data.kode_survey_pasar);
              $('#form_input #tanggal').val(data.tanggal);
              $('#form_input #kode_kota').val(data.kode_kota).trigger('change');
              $('#form_input #pasar_bantu').val(data.id_pasar);
              $('#form_input #kode_ikan').val(data.kode_ikan).trigger('change');
              $('#form_input #volume').val(data.volume);
              $('#form_input #harga').val(data.harga);

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
              url : '<?= base_url('harga_konsumsi/ajax_update')?>',
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
                url : "<?= base_url('harga_konsumsi/ajax_delete')?>/"+id,
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

  $('select[name="kode_kota"]').on('change', function() {

        var ID = $(this).val();

            $.ajax({
                url: "<?php echo site_url('harga_konsumsi/get_pasar')?>/" + ID,
                type: "GET",
                dataType: "json",

                success:function(data) {

                    $('select[name="id_pasar"]').empty();

                    $.each(data, function(key, value) {

                        $('select[name="id_pasar"]').append('<option value="'+ value.id_pasar +'">'+ value.nama_pasar +'</option>');

                    });

                    $('select[name="id_pasar"]').val($('#pasar_bantu').val()).trigger('change');

                },
              error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error get data from ajax');
                  }

            });
  });


  function refresh()
  {
    window.location.href= '<?= base_url('Harga_konsumsi/').$jenis ?>';
    // table.ajax.reload(null,false); //reload datatable ajax
  }

</script>

<?php
$this->load->view('template/modal_filter');
$this->load->view('template/foot');
?>
