        <footer>
          <center>
			       &copy 2020 Dashboard Fishinfo | DKP Jawa Timur. All rights reserved <br/>Developed by <a style="color: blue;" title="PT. ALUGARA INOVASI UTAMA" href="https://alugarainovasi.com">AIU</a>
          </center>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

     <!-- modal -->
    <div class="modal fade" id="modal_trader" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">PILIH TRADER</h3>
          </div>
          <form action="#" id="form_trader" class="form-horizontal">
            <div class="modal-body row">        
              <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                  <div class="table-responsive" id="tab_table">
                    <table id="tb_trader" class="table table-hover" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Trader</th>
                          <th>Alamat</th> 
                          <th>Kota</th> 
                          <th>Telp</th> 
                          <th>Pemilik</th> 
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no=0;
                              $this->db->select('a.*, b.nama_kota');
                              $this->db->from('dash_trader as a');
                              $this->db->join('kota as b', 'b.kode_kota = a.kode_kota','left'); 
                              $this->db->order_by('b.nama_kota', 'asc');
                              $data_trader = $this->db->get();

                            foreach ($data_trader->result() as $val) 
                            {
                              $no++;

                              echo '<tr>';
                              echo '<td>'.$no.'</td>';
                              echo '<td>'.$val->nama_trader.'</td>';
                              echo '<td>'.$val->alamat_trader.'</td>';
                              echo '<td>'.$val->nama_kota.'</td>';
                              echo '<td>'.$val->telp_trader.'</td>';
                              echo '<td>'.$val->pemilik_trader.'</td>';


                              echo '<td>
                                        <a class="btn btn-primary btn-sm" href="javascript:void()" title="Pilih" onclick="set_pengusaha('."'".$val->trader_id."'".')"> <i class="fa fa-check" aria-hidden="true"></i> Pilih</a>
                                      </td>';

                              echo '</tr>';

                            }
                          
                        ?>
                     
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
             
            </div>
          </form>
        </div>
      </div>
    </div> <!-- end modal -->

    <!-- modal upload excel -->
    <div class="modal fade" id="modal_unggah">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="#" id="form_unggah">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Unggah Data dari Excel</h4>
                    </div>
                    <div class="modal-body" style="padding: 30px;">
                        <div class="form-group">
                            <label for="tanggal">Pilih File</label><br/>
                            <input type="hidden" name="table_name" id="table_name">
                            <input type="hidden" name="table_field" id="table_field">
                            <input type="file" class="form-control" id="file_excel" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required><br/>
                            <span style="color: green;"><i>*Format file: ( xlsx / csv )</i></span><br/>
                            
                            <a id="url_excel" target="_blank" href="#" download><u><i> <b> <i class="fa fa-download" aria-hidden="true"></i> Unduh Contoh Format</b> </i></u></a>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btn-unggah" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end modal -->

   
    <script type="text/javascript">
      
      $(window).load(function() {
          $("#loader").fadeOut("slow"); //tutup loader (lokasi di sidebar.php) selesai diload
      });

      $(document).ready(function() 
      {

            $('#tb_filter_fav').DataTable({
              "searching": false,
            });


            $('.select2').select2({
                placeholder: 'Filter ...',
                allowClear: true,
            });

            $('.select2-filter').select2({
              placeholder: 'Output Filter ...',
              allowClear: true,
            });

            $('.select2-group').select2({
              placeholder: 'Group ...',
              maximumSelectionLength: 2,
              allowClear: true,
            });

           $('.select2-fav').select2({
              placeholder: 'Favorit ...',
              allowClear: true,
            });

            $('.select-operator').select2({
              placeholder: 'Operator ...',
              allowClear: true,
            });

            $('.select2-pilih').select2({
              placeholder: 'Pilih ...',
              allowClear: true,
            });

            $('.select2-modal').each(function () {
                $(this).select2({
                    placeholder: 'Please Select ...',
                    allowClear: true,
                    dropdownParent: $(this).parent()
                });
            });

            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "top auto",
                todayBtn: true,
                todayHighlight: true,
            });

            $('.tahun').datepicker({
                minViewMode: 2,
                format: 'yyyy',
                autoclose: true,
            });

            $('#tb_trader').DataTable({});
            
            $('.delete_checkbox').click(function(){
              if($(this).is(':checked'))
              {
               $(this).closest('tr').addClass('removeRow');
              }
              else
              {
               $(this).closest('tr').removeClass('removeRow');
              }
            });
                     
        });


        function reload_table()
        {
             $("#btn_refresh").html('<i class="fa fa-refresh" aria-hidden="true"></i> Refreshing...');
             $("#btn_refresh").prop('disabled', true);
             
            setTimeout(function() {
              window.location.reload();
            }, 600);
             
        }


        function readURL(input, id)
        {
          var gb = input.files;

          for (var i = 0; i < gb.length; i++){

              var gbPreview = gb[i];
              var imageType = /image.*/;
              var preview   = document.getElementById("img-preview");
              var reader = new FileReader();
              if (gbPreview.type.match(imageType)) {
                  $("#img_label").hide();
                  $("#img-preview").show();
                  preview.file = gbPreview;
                  reader.onload = (function(element) {
                      return function(e) {
                          element.src = e.target.result;
                      };
                  })(preview);

                  reader.readAsDataURL(gbPreview);
              }else{
                  $('#img_label').show();
                  $("#img-preview").hide();
                  
                  alert("Type file tidak sesuai. Khusus image.");
              }
          }
      }

      function perbaikan()
      {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Halaman masih dalam perbaikan!',
        })
      }

      function get_pengusaha()
      {
        //$('#modal_add').modal('hide');
        $('#modal_trader').modal('show');

      }

      function set_pengusaha(id)
      {
        $('#modal_trader').modal('hide');
        $('#modal_add').modal('hide');

        setTimeout(function() {
          $('#modal_add').modal('show');
        }, 400);

        

        $('#form_input #trader_id').val(id);
        

        $.ajax({
                url : "<?= base_url('Dashboard/get_trader')?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                 $('#form_input #trader_tampil').val(data.nama_trader);
                }
        });
      }

      function excel_export(tbl, namafile)
      {
           $("#"+tbl).table2excel({
            exclude: ".table", // mytable is the table ID or Div ID
            name: "Worksheet Name",
            filename: namafile+".xls", // my excel file is the name of download file name, you can change it
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true,
            preserveColors: false
          });
      }

     function pdf_export(id, namafile) 
     {
            var theadArray = [];
            var tbodyArray = [];

            $('#'+id+' thead th').each(function() {
                theadArray.push($(this).text());
            });

            //var arr = [];
            var $table = $('#'+id);

            $table.find('tbody tr').each(function(){
                var rowValues = [];
                $(this).find('td').each(function(i) {
                    rowValues[i] = $(this).text();
                });
                tbodyArray.push(rowValues);
            });

             $.redirect("<?= base_url('dashboard/cetak_pdf') ?>", 
                {
                   header: theadArray,
                   isi: tbodyArray,
                   judul: namafile
                }, 
            "POST", "_blank");

      }

      function pdf_export_graph(id, namafile) 
      {
         $("#loader").fadeIn();
           setTimeout(function()
           { 
              var grafik = $('#'+id).highcharts();

               
                 grafik.exportChartLocal({
                    type: 'application/pdf',
                    filename: namafile
                });    
                 $("#loader").fadeOut(); 
           }, 1000);    
      };

      function show_import(id)
      {
         $('#modal_unggah').modal('show');
         $('#file_excel').val('');

         $.ajax({
                url : "<?= base_url('dashboard/getExcel_format')?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
        
                  $("#url_excel").attr("href", "<?= base_url('assets/format_import/') ?>"+data.url_file);
                  $("#table_name").val(data.table_name);
                  $("#table_field").val(data.table_field);
                     
                   
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data');
                }
          });

      }

      $('#form_unggah').submit(function(e){
          e.preventDefault(); 
              $('#btn-unggah').prop('disabled', true)
              $('#btn-unggah').html('<i class="fa fa-cloud-upload" aria-hidden="true"></i> Mengunggah...');
              $.ajax({
                  url : '<?= base_url('dashboard/upload_excel')?>',
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
                          $('#modal_unggah').modal('hide');

                          Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data Uploaded successfully',
                            showConfirmButton: false,
                            timer: 1600
                          })

                          setTimeout(refresh, 1000);

                      }else{
                          Swal.fire({
                              position: 'center',
                              icon: 'warning',
                              title: 'Format Tidak sesuai ketentuan',
                              showConfirmButton: false,
                              timer: 1600
                          })
                      }
                  },
                  error: function (request, status, error)
                  {
                      alert(request.responseText);
                  }
                  /*
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert(jqXHR.textStatus);
                         Swal.fire({
                              position: 'center',
                              icon: 'error',
                              title: 'Failed to upload data',
                              showConfirmButton: false,
                              timer: 1600
                          })
                  }*/
              });

             $('#btn-unggah').prop('disabled', false)
             $('#btn-unggah').html('<i class="fa fa-cloud-upload" aria-hidden="true"></i> Unggah');

      });
   

  function delete_check(tbl_val, row_val)
  {
      var checkbox = $('.delete_checkbox:checked');
      if(checkbox.length > 0)
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
            if (result.value) 
            {            
               var checkbox_value = [];
               $(checkbox).each(function(){
                checkbox_value.push($(this).val());
               });

               $.ajax({
                  url : "<?= base_url('dashboard/delete_check')?>",
                  method:"POST",
                  data:{
                          checkbox_value: checkbox_value,
                          tbl: tbl_val,
                          id_row: row_val
                        },
                  dataType: "JSON",
                  success:function(data)
                  {
                      if(data.status) //if success close modal and reload ajax table
                       {

                         Swal.fire(
                            'Deleted!',
                            'Berhasil Terhapus',
                            'success'
                          )

                        setTimeout(refresh, 1000);
                         
                       }
                  },
                   error: function (request, textStatus, errorThrown)
                    {
                        alert(request.responseText);  
                    }

               })
            
            }
          })
      }
      else
      {
         Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Tidak Ada Data Yang Dipilih',
              showConfirmButton: false,
              timer: 1500
          })
      }
   }

   function bypass_login(url)
   {
      var passwd = "<?= $this->session->userdata('passwd_user') ?>";
      var us = "<?= $this->session->userdata('kode_surveyor') ?>";

        window.open("http://fishinfojatim.net/pages/bypass_login/"+us+"/"+passwd+"?url="+url);
    }


    </script>

    
    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets/gentelella/vendors/fastclick/lib/fastclick.js') ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url('assets/gentelella/vendors/nprogress/nprogress.js') ?>"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url('assets/gentelella/vendors/Chart.js/dist/Chart.min.js') ?>"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url('assets/gentelella/vendors/gauge.js/dist/gauge.min.js') ?>"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url('assets/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url('assets/gentelella/vendors/iCheck/icheck.min.js') ?>"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url('assets/gentelella/vendors/skycons/skycons.js') ?>"></script>
    <!-- Flot -->
    <script src="<?php echo base_url('assets/gentelella/vendors/Flot/jquery.flot.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/Flot/jquery.flot.pie.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/Flot/jquery.flot.time.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/Flot/jquery.flot.stack.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/Flot/jquery.flot.resize.js') ?>"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url('assets/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/flot.curvedlines/curvedLines.js') ?>"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url('assets/gentelella/vendors/DateJS/build/date.js') ?>"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url('assets/gentelella/vendors/jqvmap/dist/jquery.vmap.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') ?>"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url('assets/gentelella/vendors/moment/min/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>

    <!-- data tables -->
    <script src="<?php echo base_url('assets/gentelella/vendors/DataTables-1.10/media/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/gentelella/vendors/DataTables-1.10/media/js/dataTables.bootstrap.min.js') ?>"></script>

    <!-- Date Picker -->
    <script src=" <?php echo base_url('assets/gentelella/vendors/datepicker/bootstrap-datepicker.js')?>"></script> 

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url('assets/gentelella/build/js/custom.min.js') ?>"></script>

    <!-- Table to excel -->
    <script src=" <?php echo base_url('assets/gentelella/vendors/jquery-table2excel/src/jquery.table2excel.js')?>"></script> 

        <!-- Table to excel -->
    <script src=" <?php echo base_url('assets/gentelella/vendors/jspdf/dist/jspdf.min.js')?>"></script> 
  
    <script src=" <?php echo base_url('assets/gentelella/vendors/html2canvas/dist/html2canvas.min.js')?>"></script> 

    <script src=" <?php echo base_url('assets/gentelella/vendors/jquery.redirect/jquery.redirect.js')?>"></script> 

  </body>
</html>