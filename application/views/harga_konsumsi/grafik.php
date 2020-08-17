   
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

    
      $volume = array();
      $harga =  array();
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
                   if($gb == 'nama_ikan')
                     $val_lbl[$gb][]= $val->nama_ikan;
                   if($gb == 'nama_surveyor')
                     $val_lbl[$gb][] = $val->nama_surveyor;
                   if($gb == 'tanggal')
                     $val_lbl[$gb][] = $val->tanggal;
                   
                }            
           
          }
          else
          {
            $lbl_data[] = $val->nama_kota.'-'.$val->nama_ikan;
          }

          $volume[] = (float) $val->volume;
          $harga[]  = (float) $val->harga;
           
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

    // echo json_encode($lbl_data);
     //echo var_dump($val_lbl);

      $simpan_catag    = json_encode($lbl_data);
      $simpan_lbl_data = 'Volume (Rg),Harga (Rp/kg)';
      $simpan_data     = 'volume,harga';//json_encode($data1).'|'.json_encode($data2);
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
                Highcharts.chart('grafik_bar', {
                  chart: {
                      type: 'column',
                  },

                  title: {
                      text: 'Grafik Bar<br/><?= $title ?>'
                  },
                  subtitle: {
                      text: 'www.fishinfojatim.net'
                  },
                  xAxis: {
                      categories: <?= json_encode($lbl_data) ?>,
                      crosshair: true
                   },

                  yAxis: [{
                      className: 'highcharts-color-0',
                      title: {
                          text: 'Volume (Kg)'
                      }
                  }, {
                      className: 'highcharts-color-1',
                      opposite: true,
                      title: {
                          text: 'Harga (Rp/kg)'
                      }
                  }],

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
                      name: 'Volume (kg)',
                      data: <?= json_encode($volume) ?>
                  }, { 
                      name: 'Harga (Rp/kg)',
                      data: <?= json_encode($harga) ?>,
                      yAxis: 1
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