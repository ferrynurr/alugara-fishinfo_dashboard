<?php
$this->load->view('template/head');
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
?>

<style type="text/css">
  .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    margin-left: 4px;
  }

   .btn-group{
    padding-top: 15px; padding-bottom: 15px;
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
              <form action="<?= base_url('omset') ?>" method="POST" id="form_filter">
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
                  $this->load->view('omset/table');
                  $this->load->view('omset/grafik'); 
                  $this->load->view('omset/pivot');
                  $this->load->view('omset/pie');
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
              <div class="col-lg-6 col-md-6">
                  <input type="hidden" id="omset_id" name="omset_id">
                  <div class="form-group">
                    <label class="control-label ">Trader*</label><br/>
                    <div class="input-group">
                      <input type="hidden" id="trader_id" name="trader_id">
                      <input type="text" class="form-control" id="trader_tampil" name="trader_tampil" placeholder="Pilih Trader..." readonly required>
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="get_pengusaha()"><i class="fa fa-search"></i> Pilih</button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label ">kegiatan*</label><br/>
                     <textarea type="text" id="kegiatan" name="kegiatan" class="form-control" placeholder="masukan kegiatan ..." required></textarea>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Lokasi</label><br/>
                      <div class="form-group">
                          <label class="radio-inline">
                            <input type="radio" name="lok_id" id="lok_rd1" onclick="get_lokasi('jatim')" checked> JATIM
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="lok_id" id="lok_rd2" onclick="get_lokasi('luar')"> Luar JATIM
                          </label>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <div id="panel_jatim">
                            <select class="select2-modal" name="kode_kota" id="kode_kota"  style="width: 100%">
                              <option value="0">-- Pilih Kota --</option>
                              <?php foreach ($data_kota->result() as $row) {
                                    echo '<option value="'.$row->kode_kota.'">'.$row->nama_kota.'</option>';
                              } ?>
                            </select>
                          </div>
                          <div id="panel_luar">
                            <select class="select2-modal" name="kode_provinsi" id="kode_provinsi"  style="width: 100%">
                              <option value="0">-- Pilih Provinsi --</option>
                              <?php foreach ($data_provinsi->result() as $row) {
                                    echo '<option value="'.$row->kode_provinsi.'">'.$row->nama_provinsi.'</option>';
                              } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                    <label class="control-label ">Tanggal Mulai</label><br/>
                    <input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control datepicker" placeholder="yyyy-mm-dd">
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Tanggal Selesai</label><br/>
                    <input type="text" id="tgl_selesai" name="tgl_selesai" class="form-control datepicker" placeholder="yyyy-mm-dd">
                  </div>
                  <div class="form-group">
                    <label class="control-label ">Jenis</label><br/>
                    <select id="jenis" name="jenis" class="select2-modal" style="width: 100%"> 
                      <option value=""></option>
                      <option value="pameran">Pameran</option>
                      <option value="bazar">Bazar</option>
                      <option value="lainya">Lainya..</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Omset (Rp)* </label><br/>
                    <input type="number" id="omset" name="omset" class="form-control"  placeholder="masukan omset ..." required>
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
  //alert('asu');
  var save_method;
 $(document).ready(function() {
     
    $('#tb_omset').DataTable({
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All Data"]],
      "searching": false
    });
    $("#omset_nav").addClass('active');
   
    
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
    
    /*
    var theadArray = [];

    $('#tb_omset thead th').each(function() {
        theadArray.push($(this).text());
    });


    $('#modal_saveDash #thead').val(theadArray);
    $('#modal_saveDash #tbody').val(<?= json_encode($tbodyArray) ?>);
    */

    $('#panel_jatim').show(); 
    $('#panel_luar').hide();
   
       
  });


function get_lokasi(id)
{
  if(id == 'jatim')
  {
    $('#panel_jatim').show();
    $('#panel_luar').hide();
    $('#kode_provinsi').val('0').trigger('change');
  }  
  else if(id == 'luar')
  {
    $('#panel_jatim').hide();
    $('#panel_luar').show();
    $('#kode_kota').val('0').trigger('change');
  }

}


  function add_data()
  {
    save_method = 'add';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Tambah Omset');
    $('#form_input input[type="text"]').val('');
    $('#form_input input[type="number"]').val('0');
    $('#form_input textarea').val('');
    $('#form_input .select2-modal').val('0').trigger('change');
  }

  function get_data(id)
  {
    save_method = 'update';

    $('#modal_add').modal('show');
    $('#modal_add .modal-title').text('Edit Omset');

    $.ajax({
            url : "<?= base_url('omset/ajax_get')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('#form_input #omset_id').val(data.omset_id);
              $('#form_input #trader_id').val(data.trader_id);
              $('#form_input #trader_tampil').val(data.nama_trader);
              $('#form_input #kegiatan').val(data.kegiatan);
              $('#form_input #tgl_mulai').val(data.tgl_mulai);
              $('#form_input #tgl_selesai').val(data.tgl_selesai);
              $('#form_input #jenis').val(data.jenis).trigger('change');
              $('#form_input #omset').val(data.omset);

              if(data.nama_kota)
              {
                  $('#lok_rd1').prop('checked',true);
                  $('#panel_jatim').show();
                  $('#panel_luar').hide();
                  $('#kode_provinsi').val('0').trigger('change');
                  $('#kode_kota').val(data.kode_kota).trigger('change');
              }

              if(data.nama_provinsi)
              {
                $('#lok_rd2').prop('checked',true);
                $('#panel_jatim').hide();
                $('#panel_luar').show();
                $('#kode_kota').val('0').trigger('change');
                $('#kode_provinsi').val(data.kode_provinsi).trigger('change');
              }

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
              url = "<?php echo base_url('omset/ajax_add')?>";

          }else if(save_method == 'update'){
              url = "<?php echo base_url('omset/ajax_update')?>";

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
                url : "<?= base_url('omset/ajax_delete')?>/"+id,
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
    window.location.href= '<?= base_url('omset') ?>';
    // table.ajax.reload(null,false); //reload datatable ajax
  }


</script>

<?php
$this->load->view('template/modal_filter');
$this->load->view('template/foot');
?>
