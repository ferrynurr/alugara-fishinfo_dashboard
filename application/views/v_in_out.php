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
              <form action="<?= base_url('in_out/').$jenis ?>" method="POST" id="form_filter">
                <div class="content_head row"> 
                    <div class="col-lg-5">
                       <button type="button" class="btn btn-default btn-sm" onclick="refresh()"> <i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button> 
                        <button type="button" class="btn btn-info btn-sm" onclick="show_import('<?= $halaman ?>')"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Unggah</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>

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
                  $this->load->view('in_out/grafik');
                  $this->load->view('in_out/table');
                  $this->load->view('in_out/pivot');
                  $this->load->view('in_out/pie');
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
            <div class="modal-body row">        
              <div class="col-sm-6" >
                  <input type="hidden" id="in_out_id" name="in_out_id">
                  <div class="form-group">
                    <label class="control-label ">Trader*</label><br/>
                    <input type="text" name="trader_name" id="trader_name" class="form-control" placeholder="Masukan Nama Trader ..." required>
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Tanggal*</label><br/>
                    <input type="text" name="tgl" id="tgl" class="form-control datepicker" placeholder="YYYY-MM-DD">
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Kelompok Komoditas*</label><br/>
                    <select id="kom_kelompok" name="kom_kelompok" class="select2-modal" style="width: 100%" required> 
                      <option value=""></option>
                      <?php
                        foreach ($data_kom_kelompok->result() as $row) {
                          echo '<option value="'.$row->komoditas_kel_id.'">'.$row->nama_komoditas_kel.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Jenis Komoditas*</label><br/>
                    <input type="hidden" name="komoditas_bantu" id="komoditas_bantu">
                    <select id="komoditas_id" name="komoditas_id" class="select2-modal" style="width: 100%" required> 
                      <option value=""></option>
                    </select>
                  </div>
                 
              </div>
              <div class="col-sm-6" >
                 <div class="form-group row">
                    <div class="row">
                      <div class="col-sm-8">
                        <label class="control-label ">Jumlah*</label><br/>
                        <input type="number" id="jumlah_awal" name="jumlah_awal" class="form-control" value="0" required>
                      </div>
                      <div class="col-sm-4">
                         <label> Satuan* </label>
                            <select id="satuan_awal" name="satuan_awal" class="select2-modal" style="width: 100%" required> 
                              <option value=""></option>
                              <?php
                                foreach ($data_satuan->result() as $row) {
                                  echo '<option value="'.$row->kode_satuan.'">'.$row->kode_satuan.'</option>';
                                }
                              ?>
                            </select>
                          
                      </div>
                    </div>
                  </div>
                  <?php 

                      $satuan_label = '(Rp)';
                      $astuj_label  = 'Daerah Asal';
                     
                      if($jenis == 'dom_masuk')
                      {
                           $satuan_label = '(Rp)';
                           $astuj_label  = 'Daerah Asal';
                      }
                      elseif($jenis == 'dom_keluar')
                      {
                           $satuan_label = '(Rp)';
                           $astuj_label  = 'Daerah Tujuan';
                      }
                      elseif($jenis == 'ekspor')
                      {
                           $satuan_label = '(USD)';
                           $astuj_label  = 'Negara Tujuan';
                      }
                      elseif($jenis == 'impor')
                      {
                           $satuan_label = '(USD)';
                           $astuj_label  = 'Negara Asal';
                      }

                  ?>
                  <div class="form-group">               
                      <label class="control-label ">Nilai <?= $satuan_label ?>*</label><br/>
                      <input type="number" id="nilai" name="nilai" class="form-control" value="0" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label "><?= $astuj_label ?></label><br/>
                    <input type="text" id="astuj_name" name="astuj_name" class="form-control">
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
  var uri_hadler = "<?= $jenis ?>";
  var save_method;
 $(document).ready(function() {
     
    $('#tb_in_out').DataTable({
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All Data"]],
      "searching": false
    });

    $("#<?= $jenis ?>_nav").addClass('active');
   
    
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



  function add_data()
  {
    save_method = 'add';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Tambah Data <?= $title ?>');
    $('#form_input input[type="text"]').val('');
    $('#form_input input[type="number"]').val('0');
    $('#form_input textarea').val('');
    $('#form_input .select2-modal').val('0').trigger('change');
  }

  function get_data(id)
  {
    save_method = 'update';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit <?= $title ?>');

    $.ajax({
            url : "<?= base_url('in_out/ajax_get')?>/"+id+'/'+uri_hadler,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {


              if(uri_hadler == 'dom_masuk')
              {
                  $('#form_input #in_out_id').val(data.dom_masuk_id);
                  $('#form_input #astuj_name').val(data.asal);
                  
              }
              else if(uri_hadler == 'dom_keluar')
              {
                  $('#form_input #in_out_id').val(data.dom_keluar_id);
                  $('#form_input #astuj_name').val(data.tujuan);
              }
              else if(uri_hadler == 'ekspor')
              {
                   $('#form_input #in_out_id').val(data.ekspor_id);
                   $('#form_input #astuj_name').val(data.tujuan);
              }
              else if(uri_hadler == 'impor')
              {
                   $('#form_input #in_out_id').val(data.impor_id);
                   $('#form_input #astuj_name').val(data.asal);
              }

              
              $('#form_input #trader_name').val(data.trader_name);
              $('#form_input #tgl').val(data.tgl);
              $('#form_input #kom_kelompok').val(data.komoditas_kel_id).trigger('change');
              $('#form_input #komoditas_id').val(data.komoditas_id).trigger('change');
              $('#form_input #komoditas_bantu').val(data.komoditas_id);

              $('#form_input #satuan_awal').val(data.satuan_awal).trigger('change');
              $('#form_input #jumlah_awal').val(data.jumlah_awal);
              $('#form_input #nilai').val(data.nilai);

            },
            error: function (request, textStatus, errorThrown)
            {
                alert(request.responseText);
                alert('Error getting data');
            }
    });
   
  }

  $('#form_input').submit(function(e){
      e.preventDefault(); 
        var url='';
          if(save_method == 'add')
          {
              url = "<?php echo base_url('in_out/ajax_add/')?>"+uri_hadler;

          }else if(save_method == 'update'){
              url = "<?php echo base_url('in_out/ajax_update/')?>"+uri_hadler;

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
              error: function (request, textStatus, errorThrown)
              {
                alert(request.responseText);
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
                url : "<?= base_url('in_out/ajax_delete')?>/"+id+'/'+uri_hadler,
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


  $('select[name="kom_kelompok"]').on('change', function() 
  {
      var id = $(this).val();
      $.ajax({
              url: "<?php echo site_url('in_out/get_komoditas')?>/" + id,
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
    window.location.href= '<?= base_url('in_out/').$jenis ?>';
    // table.ajax.reload(null,false); //reload datatable ajax
  }


</script>

<?php
$this->load->view('template/modal_filter');
$this->load->view('template/foot');
?>
