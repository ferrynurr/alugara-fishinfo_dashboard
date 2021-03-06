    <style type="text/css">

    </style>     

    <!-- HTML -->
    <br/>
   
    <div id="tab_grafik">
        <div class="btn-group">
          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Action <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
             <li><a onclick="pdf_export_graph('grafik_bar', 'Grafik Bar <?= $title ?>')">Download PDF</a></li> 
             <li><a href="#" id="btn-savegraph">Save to dashboard</a></li>
          </ul>
        </div>

        <figure class="highcharts-figure">
          <div id="grafik_bar"></div>
        </figure>
   </div>

    <?php

      $label = array();
      $satuan = '';
      $data_value =  array();
           $val_lbl = array();
      $lbl_data = array();
     
       

      foreach ($data_list->result() as $val) 
      {
         
          if(count($selected_group) > 0 )
          {
       
                foreach( $selected_group as $gb )
                {
                 
                   if($gb == 'trader_name')
                     $val_lbl[$gb][] = $val->trader_name;
                   if($gb == 'jenis_komoditas')
                     $val_lbl[$gb][]= $val->jenis_komoditas;
                   if($gb == 'nama_komoditas_kel')
                     $val_lbl[$gb][] = $val->nama_komoditas_kel;

                   
                }            
           
          }
          else
          {
            $lbl_data[] = $val->trader_name.'-'.$val->jenis_komoditas;
          }

          $data_value[] = (float) $val->nilai;
        //  $harga[]  = (float) $val->harga;
           
      } 
    // echo count($selected_group);
      if(count($selected_group) > 0 )
      {
        foreach($val_lbl[$selected_group[0]] AS $x)
        {
          if(count($selected_group) == 2)
          {
              foreach($val_lbl[$selected_group[1]] as $y)
              {
                $lbl_data[] = $x.' - '.$y;
              }
          }
          elseif(count($selected_group) == 1)
          {
             $lbl_data[] = $x;
          }
         
          
        }
      }

      $simpan_catag    = json_encode($lbl_data);
      $simpan_lbl_data = $satuan_nilai;
      $simpan_data     = 'nilai';//json_encode($data1).'|'.json_encode($data2);

 
      

    ?>
    
    <!-- JS -->
    <script type="text/javascript">
      var klikg =0;

      $(document).ready(function() {

      });

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

       if(klikg == 0)
       {
          $("#loader").fadeIn();
             setTimeout(function(){ 

                 $('#grafik_bar').highcharts({
                          chart: {
                              type: 'column'
                          },
                          title: {
                              text: 'GRAFIK BAR<br/><?= $title ?>'
                          },

                          xAxis: {
                              categories: <?= json_encode($lbl_data) ?>,
                              crosshair: true
                          },
                          yAxis: {
                              min: 0,
                              title: {
                                  text: '<?= $satuan_nilai ?>'
                              }
                          },
                          tooltip: {
                              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name} <?= $satuan_nilai ?> : </td>' +
                                  '<td style="padding:0"><b>{point.y} </b></td></tr>',
                              footerFormat: '</table>',
                              shared: true,
                              useHTML: true
                          },
                           plotOptions: {
                              series: {
                                  dataLabels: {
                                      enabled:true,
                                      borderRadius: 5,
                                      borderWidth: 1,

                                 }
                              }
                          },
                          series: [{
                            
                              name: 'Nilai',
                              data: <?= json_encode($data_value) ?>

                          }]
                      });

             $("#loader").fadeOut(); 
           }, 1000);
           klikg=1;
        }
    }
    
    $("#btn-savegraph").click(function(){
          $('#modal_saveDashGrafik').modal('show'); // show bootstrap modal
          $('#dashgraf_name').val('');
          $('#modal_saveDashGrafik #type_grafik').val('bar');
          $('#modal_saveDashGrafik #label_grafik').val('<?= $simpan_catag ?>');
          $('#modal_saveDashGrafik #isi_grafik').val('<?= $simpan_data ?>');  
          $('#modal_saveDashGrafik #title_isi').val('<?= $simpan_lbl_data ?>');
          $('#modal_saveDashGrafik #title_grafik').val('Grafik Bar<br/><?= $title ?>');
    }); 

    </script>