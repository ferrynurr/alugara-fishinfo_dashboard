
 <!-- modal save favorite -->
<div class="modal fade" id="modal_Addfavorite" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
       <form action="#" id="form_saveFav" class="form-horizontal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Filter Setting</h3>
          </div>
          <div class="modal-body row">
            <div class="col-sm-10 col-sm-offset-1" >
               <input type="hidden" id="fav_halaman" name="fav_halaman" class="form-control" value="<?= $halaman ?>">
               <div style="display: none;">
                   <select name="fav_filter[]" id="fav_filter" class="select2" multiple></select>
                   <select name="fav_group[]" id="fav_group" class="select2" multiple>

                     <option value=""></option>
                     <?php 
                      foreach ($group_field->result() as $row)
                      {
                        echo '<option value="'.$row->field.'"> '.$row->label.' </option>';
                      } 

                      ?>
                   </select>
               </div>
               <div class="form-group">
                  <label class="control-label ">NAME :</label><br/>
                  <input type="text" id="fav_name" name="fav_name" class="form-control" placeholder="Masukan Nama Filter ..." required> 
                </div>
                <span>
                   <input type="radio" name="fav_shared" id="option1" value="0" checked> Use by default<br/>
                   <input type="radio" name="fav_shared" id="option2" value="1"> Share with all user
                </span>

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


<!-- modal get favorite -->
<div class="modal fade" id="modal_Getfavorite" role="dialog">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"><span class="fa fa-heart"></span> Favorite Filter</h3>
      </div>
      <div class="modal-body form">

        <!-- inputan bantu untuk simpan sementara load filter dari database -->
        <input type="hidden" name="bantu_filter" id="bantu_filter">
        <input type="hidden" name="bantu_group" id="bantu_group">


        <form action="#" id="form_addntb" class="form-horizontal">
        <div class="col-sm-10 col-sm-offset-1" >
           <div class="table-responsive" style="padding: 10px;" id="tab_table">
              <table id="tb_filter_fav" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no=0;
                    foreach ($favorite_filter->result() as $val) 
                    {
                      $no++;
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$val->fav_name.'</td>';
                      echo '<td><button type="button" onclick="delete_fav('.$val->fav_id.')" class="btn btn-danger btn-sm" ><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus</button>
                            <button type="button" id="btn-apply'.$val->fav_id.'" onclick="apply_fav('.$val->fav_id.')" class="btn btn-primary btn-sm"><i class="fa fa-external-link" aria-hidden="true"></i> Terapkan</button></td>';
                      echo '</tr>';
               
                    }
                  ?>
               
                </tbody>
              </table>
            </div>

        </div>
        </form>
              
        
      </div>
      <div class="modal-footer">
          <button type="button" id="btnSave" onclick="showModal_Addfav()" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Current Filter</button>             
         
      </div>
    </div>
  </div>
</div> <!-- end modal -->

<!-- modal save DASH -->
  <div class="modal fade" id="modal_saveDash" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <form action="#" id="form_saveDash" class="form-horizontal">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Save to Dashboard</h3>
            </div>
            <div class="modal-body row">
              <div class="col-sm-10 col-sm-offset-1">
                 <div class="form-group">
                    <label class="control-label ">NAME :</label><br/>
                    <input type="text" id="dashtab_name" name="dashtab_name" class="form-control" placeholder="Masukan Nama Dahboard ..." required> 
                  </div>
                  <input type="text" name="thead" id="thead">
                  <input type="text" name="thead_key" id="thead_key">
                
                  <input type="text" name="myquery_save" id="myquery_save" value="<?php echo $myQuery ?>">
                  

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

  <!-- modal save grafik -->
  <div class="modal fade" id="modal_saveDashGrafik" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <form action="#" id="form_saveDashGrafik" class="form-horizontal">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Save to Dashboard</h3>
            </div>
            <div class="modal-body row">
              <div class="col-sm-10 col-sm-offset-1">
                 <div class="form-group">
                    <label class="control-label ">NAME :</label><br/>
                    <input type="text" id="dashgraf_name" name="dashgraf_name" class="form-control" placeholder="Masukan Nama Dahboard ..." required> 
                  </div>
                  <input type="hidden" name="type_grafik" id="type_grafik">
                  <input type="hidden" name="label_grafik" id="label_grafik">
                  <input type="hidden" name="isi_grafik" id="isi_grafik">
                  <input type="hidden" name="title_grafik" id="title_grafik"> 
                  <input type="hidden" name="title_isi" id="title_isi"> 
                  <input type="hidden" name="query_grafik" id="query_grafik" value="<?php echo $myQuery ?>">

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
  
  // show modal tambah fovorite
  function showModal_Addfav()
  {
    $('#modal_Getfavorite').modal('hide'); // show bootstrap modal
    $('#modal_Addfavorite').modal('show'); // show bootstrap modal
    $('#fav_name').val('');


  }

  //list favorite
  function showModal_Getfav()
  {
    $('#modal_Getfavorite').modal('show'); // show bootstrap modal
    $('#fav_name').val('');

  }

  // simpan favorite
  $('#form_saveFav').submit(function(e){
      e.preventDefault(); 
      if( filter_all == '' && selected_group == '')
      {
         Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Tidak ada data yang difilter',
                      showConfirmButton: false,
                      timer: 1600
                  })
      }
      else
      {
          $.ajax({
              url : "<?= base_url('dashboard/ajax_saveFavorite')?>",
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
                    $('#modal_Addfavorite').modal('hide');
                     
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
               error: function (request, status, error)
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

      }

  });

  // terapkan favorite
  function apply_fav(id)
  {
   // alert(id);

    $('#btn-apply'+id).attr('disabled', true);
    $('#btn-apply'+id).html('<i class="fa fa-external-link" aria-hidden="true"></i> Menerapkan...');

     $.ajax({
          url : "<?= base_url('dashboard/get_favorite')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
             $('#bantu_group').val(data.group_value);
             $('#bantu_filter').val(data.filter_value);

            setTimeout(function() // wajib timeout agar $('#bantu_filter') & $('#bantu_group') terisi Oleh AJAX terlebih dahulu sebelum di reload form
            { 
              var toArray_filter = $('#bantu_filter').val().split(",");
              var toArray_group  = $('#bantu_group').val().split(",");

              var arrayFilter = [];
              var arrayGroup = [];

               
                if($('#bantu_filter').val() != '')
                {
                  for(var i = 0; i < toArray_filter.length; i++){
                     // arrayFilter.push('<input type="text" name="filter_all[]" value="'+toArray_filter[i]+'" />');
                      arrayFilter.push(toArray_filter[i]);
                  }
                }

                if($('#bantu_group').val() != '')
                {
                  for(var i = 0; i < toArray_group.length; i++){
                     // arrayGroup.push('<input type="text" name="selected_group[]" value="'+toArray_group[i]+'" />');
                     arrayGroup.push(toArray_group[i]);
                  }
                }


              
                var uri1 = "<?= $this->uri->segment('1') ?>";
                var uri2 = "<?= $this->uri->segment('2') ?>";

                var url = '<?= base_url() ?>'+uri1+'/'+uri2;
                /*
                var form = $('<form action="' + url + '" method="post">' +arrayFilter+' '+arrayGroup+'</form>');
                $('body').append(form);
                $(form).submit(); //send POST via submit
                */
                $.redirect(url, 
                {
                     filter_all: arrayFilter,
                     selected_group: arrayGroup,
                  
                },  "POST");

                $('#btn-apply'+id).attr('disabled', false);
                $('#btn-apply'+id).html('<i class="fa fa-external-link" aria-hidden="true"></i> Terapkan');  
              }, 1000);  
   
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               $('#btn-apply'+id).attr('disabled', false);
               $('#btn-apply'+id).html('<i class="fa fa-external-link" aria-hidden="true"></i> Terapkan');  

               Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: request.responseText,
                    showConfirmButton: false,
                    timer: 1300
                })


            }
               
      });  

         

  }

  // hapus favorite
  function delete_fav(id)
  {
    Swal.fire({
        title: 'Yakin Ingin Hapus ?',
        text: "Filter yang telah dihapus tidak akan lagi ditampilkan di semua user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url : "<?= base_url('dashboard/delete_favorite')?>/"+id,
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
                error: function (request, status, error)
                {
                    alert('Error deleting data');
                }
            });

        
        }
      })
  }

  // simpan dashboard tabel
  $('#form_saveDash').submit(function(e){
      e.preventDefault(); 
          $.ajax({
              url : "<?php echo base_url('dashboard/ajax_saveDash')?>",
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
                    $('#modal_saveDash').modal('hide');
                     
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
               error: function (request, status, error)
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

 // simpan dashboard grafik
  $('#form_saveDashGrafik').submit(function(e){
      e.preventDefault(); 
          $.ajax({
              url : "<?php echo base_url('dashboard/ajax_saveDashGrafik')?>",
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
                    $('#form_saveDashGrafik').modal('hide');
                     
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
               error: function (request, status, error)
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
  

 var num1 = 1;
 function show_formFilter()
 {
   $("#panel_group").hide(); 
   if(num1 == 1)
   {
      $('#panel_filter').show(); 
      num1 = 2
   }
   else{
      $('#panel_filter').hide();
      num1 = 1
   }
 }

  var num2 = 1;
  function show_formGroup()
  {
    $('#panel_filter').hide();
      if(num2 == 1){
        $("#panel_group").show();
       
        num2 = 2
      }
      else{
        $("#panel_group").hide(); 
        
        num2 = 1;
      }

       $("#selected_gruop").val('').trigger('change');
  }

  function add_filterAll()
  {
    var vkols = $('#filter_field').val().split("|");
    // alert (vkols[0]);
    var vkoltype = vkols[0];
    var vkolom = vkols[1];
    var vopr   = $('#filter_opr').val();
    var vnilai = $('#filter_val').val();
    var topr   = $('#filter_opr option:selected').text();
    var tnilai = $('#filter_val').val();
    var tkolom = $('#filter_field option:selected').text();

    var elem_all = document.getElementById("filter_all");
    //var filter_volume = $('#filter_volume').val();
    var data_val;var data_text;

    // alert (vnilai);

    if (vopr=='like')
      data_val = vkolom+" "+vopr+" '~"+vnilai+"~'";
    else {
      if (vkoltype=='text' || vkoltype=='date')
        data_val = vkolom+" "+vopr+" '"+vnilai+"'";
      else
        data_val = vkolom+" "+vopr+" "+vnilai;
    }

    data_text = tkolom+" "+topr+" "+tnilai;

    var ada=false;
    if ($('#filter_all').val() != null){
      var tsopr   = $('#filter_all option:selected').text();
      var bufstr = $('#filter_all').val().toString();
      // alert(tsopr);
      var filtall = bufstr.split(",");
      // alert (filtall.length);
      for (var i = filtall.length - 1; i >= 0; i--) {
          var trend = filtall[i];
          var curkol = trend.split(" ")[0];
          // alert(curkol);
          if (curkol==vkolom){
            var curval = trend.split("|")[0];
            var curtext = trend.split("|")[1];

            data_val = curval+" OR "+data_val;
            data_text = curtext+" OR "+data_text;

            var wanted_option = $('#filter_all option[value="'+ trend +'"]');
            wanted_option.prop('selected', false);
            $('#filter_all').trigger('change.select2');

            elem_all.remove(i);
            break;
          }
      }
    }
    
    $('#filter_all').append('<option value="'+data_val+"|"+data_text+'" selected>'+data_text+'</option>');

    $('#filter_opr').val('');
    $('#filter_val').val('');
    $('#filter_field').val('').trigger('change');
  }


  function savetoDash()
  {
    $('#modal_saveDash').modal('show'); // show bootstrap modal
    $('#dashtab_name').val('');
    $('#modal_saveDash #thead_key').val($('#field_db').val());
    $('#modal_saveDash #thead').val($('#field_label').val());
  }


  function show_list()
  {
     $("#tab_table").show();
     $("#tab_grafik").hide();
     $("#tab_pivot").hide();
     $("#tab_pie").hide();
     $("#li_table").addClass('active');
     $("#li_grafik").removeClass('active');  
     $("#li_pie").removeClass('active');
     $("#li_pivot").removeClass('active');
  }

/*
  function show_grafik()
  {
     $("#tab_table").hide();
     $("#tab_grafik").show();
     $("#tab_pivot").hide();
     $("#tab_pie").hide();
     $("#li_table").removeClass('active');
     $("#li_pivot").removeClass('active');
     $("#li_pie").removeClass('active');
     $("#li_grafik").addClass('active');

  }

  function show_pie()
  {
     $("#tab_table").hide();
     $("#tab_grafik").hide();
     $("#tab_pivot").hide();
     $("#tab_pie").show();
     $("#li_table").removeClass('active');
     $("#li_grafik").removeClass('active');
     $("#li_pivot").removeClass('active');
     $("#li_pie").addClass('active');

  }
  */

  function show_pivot()
  {
     $("#tab_table").hide();
     $("#tab_grafik").hide();
     $("#tab_pie").hide();
     $("#tab_pivot").show();
     $("#li_table").removeClass('active');
     $("#li_grafik").removeClass('active');  
     $("#li_pie").removeClass('active');
     $("#li_pivot").addClass('active');

  }



  </script>