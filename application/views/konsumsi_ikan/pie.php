    <style type="text/css">

    </style>     
   

     <div id="tab_pie">
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#pie1">Konsumsi Ikan</a></li>
            <li><a data-toggle="tab" href="#pie2">Kebutuhan Ikan</a></li>
            
        </ul>
        <br/>
        <div class="tab-content">  
            <div id="pie1" class="tab-pane fade in active">   
                <div class="btn-group">
                      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                         <li><a onclick="pdf_export_graph('tab_pie_1', 'Grafik-Pie-Konsumsi-Ikan')">Download PDF</a></li> 
                         <li><a href="#" onclick="btn_saveDashPie('tab_pie_1', 'Grafik Pie<br/>Konsumsi ikan')">Save to dashboard</a></li>
                      </ul>
                </div>          
                   <figure class="highcharts-figure">
                      <div id="tab_pie_1"></div>     
                   </figure>    
            </div>
          
            <div id="pie2" class="tab-pane fade"> 
                <div class="btn-group">
                      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                         <li><a onclick="pdf_export_graph('tab_pie_2', 'Grafik-Pie-Kebutuhan-Ikan')">Download PDF</a></li> 
                         <li><a href="#" onclick="btn_saveDashPie('tab_pie_2', 'Grafik Pie<br/>Kebutuhan ikan')">Save to dashboard</a></li>
                      </ul>
                </div>  
                 <figure class="highcharts-figure">
                   <div id="tab_pie_2"></div>      
                  </figure> 
            </div>
        </div>
   
   </div>

    <?php

      $data_name = array();
      $data_name2 = array();

      $isi_data = array();
      $isi_data2 = array();
      $val_lbl = array();
      $lbl_data = array();


      foreach ($data_list->result() as $val) 
      {
         
          if(count($selected_group) > 0 )
          {
       
                foreach( $selected_group as $gb )
                {
                 
                   if($gb == 'nama_kota')
                     $val_lbl[$gb][] = $val->nama_kota;
                   elseif($gb == 'tahun')
                     $val_lbl[$gb][]= $val->tahun;
               
                 
                   
                }            
           
          }
          else
          {
            $lbl_data[] = $val->nama_kota.' | '.$val->tahun;
          }

           $isi_data[]  = (float) $val->tot_konsumsi;  
           $isi_data2[]  = (float) $val->kebutuhan;

           
      } 
    // echo count($selected_group);
      if(count($selected_group) > 0 )
      {
        if(count($selected_group) == 1 )
          {
            foreach($val_lbl[$selected_group[0]] as $n) 
            {
              $lbl_data[] = $n;

            }
          }
         elseif(count($selected_group) == 2 )
          {
            for ($index = 0 ; $index < count($val_lbl[$selected_group[0]]); $index ++) {
              $lbl_data[] = $val_lbl[$selected_group[0]][$index].' | '.$val_lbl[$selected_group[1]][$index];
             
            }
          /*
            foreach(array_combine($val_lbl[$selected_group[0]], $val_lbl[$selected_group[1]]) as $f => $n) 
            {
              $lbl_data[] = $f.' - '.$n;

            }
            */
          }


      }

       for ($index = 0 ; $index < count($lbl_data); $index ++) {
            $data_name[] = array($lbl_data[$index].'<br>Kg/kapita '.number_format($isi_data[$index],2,',','.'), $isi_data[$index]);
        }


       for ($index = 0 ; $index < count($lbl_data); $index ++) {
            $data_name2[] = array($lbl_data[$index].'<br>Kg/kapita '.number_format($isi_data2[$index],2,',','.'), $isi_data2[$index]);
        }

        $simpan_catag    = json_encode($data_name);
        $simpan_catag2    = json_encode($data_name2);


    ?>
    
    <!-- JS -->
    <script type="text/javascript">
      var klikp =0;
      $(document).ready(function() {


      });

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

     
      if(klikp == 0)
      {
        $("#loader").fadeIn();
           setTimeout(function(){ 

             Highcharts.chart('tab_pie_1', {
                  chart: {
                      plotBackgroundColor: true,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: 'GRAFIK PIE<br/>Konsumsi Ikan'
                  },
                  tooltip: {
                      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                  },
                  accessibility: {
                      point: {
                          valueSuffix: '%'
                      }
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '<b>{point.name}</b> ({point.percentage:.1f} %)'
                          }
                      }
                  },
                  series: [{
                      name: 'Konsumsi ikan',
                      colorByPoint: true,
                      data: <?php  echo json_encode($data_name) ?>
                  }]
              });

              Highcharts.chart('tab_pie_2', {
                  chart: {
                      plotBackgroundColor: true,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: 'GRAFIK PIE<br/>Kebutuhan Ikan'
                  },
                  tooltip: {
                      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                  },
                  accessibility: {
                      point: {
                          valueSuffix: '%'
                      }
                  },
                  plotOptions: {
                      pie: {
                          allowPointSelect: true,
                          cursor: 'pointer',
                          dataLabels: {
                              enabled: true,
                              format: '<b>{point.name}</b> ({point.percentage:.1f} %)'
                          }
                      }
                  },
                  series: [{
                      name: 'Kebutuhan ikan',
                      colorByPoint: true,
                      data: <?php  echo json_encode($data_name2) ?>
                  }]
              });

             $("#loader").fadeOut(); 
           }, 1000);
           klikp=1;
        }
    }
    

    function btn_saveDashPie(id, title)
    {
          $('#modal_saveDashGrafik').modal('show'); // show bootstrap modal
          $('#dashgraf_name').val('');
          $('#modal_saveDashGrafik #type_grafik').val('pie');
         
          $('#modal_saveDashGrafik #isi_grafik').val('');  
          $('#modal_saveDashGrafik #title_isi').val('');
          $('#modal_saveDashGrafik #title_grafik').val(title);

          if(id == 'tab_pie_1')
             $('#modal_saveDashGrafik #label_grafik').val('<?= $simpan_catag ?>');
          else if(id == 'tab_pie_2')
            $('#modal_saveDashGrafik #label_grafik').val('<?= $simpan_catag2 ?>');
    }; 



    </script>