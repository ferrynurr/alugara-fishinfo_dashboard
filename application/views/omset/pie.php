    <style type="text/css">

    </style>     
   
    <div id="tab_pie">
        <div class="btn-group">
          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Action <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
             <li><a onclick="pdf_export_graph('grafik_pie', 'Grafik Pie <?= $title ?>')">Download PDF</a></li> 
             <li><a href="#" id="btn-savegraph-pie">Save to dashboard</a></li>
          </ul>
        </div>

        <figure class="highcharts-figure">
          <div id="grafik_pie"></div>
        </figure>
   </div>

    <?php

    $data_name = array();


      $isi_data = array();

      $val_lbl = array();
      $lbl_data = array();


      foreach ($data_list->result() as $val) 
      {
         
          if(count($selected_group) > 0 )
          {
       
                foreach( $selected_group as $gb )
                {
                 
                   if($gb == 'nama_trader')
                     $val_lbl[$gb][] = $val->nama_trader;
                   elseif($gb == 'jenis')
                     $val_lbl[$gb][]= $val->jenis;
               
                 
                   
                }            
           
          }
          else
          {
            $lbl_data[] = $val->nama_trader.' | '.$val->jenis;
          }

           $isi_data[]  = (float) $val->omset;

           
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
            $data_name[] = array($lbl_data[$index].'<br>Rp. '.number_format($isi_data[$index],2,',','.'), $isi_data[$index]);
        }




        $simpan_catag    = json_encode($data_name);



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
             Highcharts.chart('grafik_pie', {
                  chart: {
                      plotBackgroundColor: true,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                  },
                  title: {
                      text: 'GRAFIK PIE<br/><?= $title ?>'
                  },
                  subtitle: {
                          text: 'Source: www.fishinfojatim.net'
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
                      name: 'Omset',
                      colorByPoint: true,
                      data: <?php  echo json_encode($data_name) ?>
                  }]
              });
             $("#loader").fadeOut(); 
           }, 1000);
           klikp=1;
        }
    }
    
    $("#btn-savegraph-pie").click(function(){
          $('#modal_saveDashGrafik').modal('show'); // show bootstrap modal
          $('#dashgraf_name').val('');
          $('#modal_saveDashGrafik #type_grafik').val('pie');
          $('#modal_saveDashGrafik #label_grafik').val('<?= $simpan_catag ?>');
          $('#modal_saveDashGrafik #isi_grafik').val('');  
          $('#modal_saveDashGrafik #title_isi').val('');
          $('#modal_saveDashGrafik #title_grafik').val('Grafik Pie<br/><?= $title ?>');
    }); 

    </script>