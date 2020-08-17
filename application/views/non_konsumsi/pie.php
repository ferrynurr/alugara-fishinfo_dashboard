    <style type="text/css">

    </style>    

  <div id="tab_pie">
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#pie1">Harga (Rp/Pcs)</a></li>
            <li><a data-toggle="tab" href="#pie2">Harga (Rp/KG)</a></li>
            <li><a data-toggle="tab" href="#pie3">Harga (Rp/L)</a></li>
            <li><a data-toggle="tab" href="#pie4">Omzet</a></li>
        </ul>
        <br/>
        <div class="tab-content"> 
            <div id="pie1" class="tab-pane fade in active">
                <div class="btn-group">
                      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                         <li><a onclick="pdf_export_graph('tab_pie_1', 'Grafik Pie Non-konsumsi Harga (Rp/Pcs)')">Download PDF</a></li> 
                         <li><a href="#" onclick="btn_saveDashPie('tab_pie_1', 'Grafik Pie <br/>Non-konsumsi Harga (Rp/Pcs)')">Save to dashboard</a></li>
                      </ul>
                </div> 
                <div id="tab_pie_1"></div>
               
            </div>
          
            <div id="pie2" class="tab-pane fade">
                    <div class="btn-group">
                          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                             <li><a onclick="pdf_export_graph('tab_pie_2', 'Grafik Pie Non-konsumsi Harga (Rp/KG)')">Download PDF</a></li> 
                             <li><a href="#" onclick="btn_saveDashPie('tab_pie_2', 'Grafik Pie <br/>Non-konsumsi Harga (Rp/KG)')">Save to dashboard</a></li>
                          </ul>
                    </div> 
                    <div id="tab_pie_2"></div>
                 
            </div>
            

            <div id="pie3" class="tab-pane fade">
                     <div class="btn-group">
                          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                             <li><a onclick="pdf_export_graph('tab_pie_3', 'Grafik Pie Non-konsumsi Harga (Rp/L)')">Download PDF</a></li> 
                             <li><a href="#" onclick="btn_saveDashPie('tab_pie_3', 'Grafik Pie<br/>Non-konsumsi Harga (Rp/L)')">Save to dashboard</a></li>
                          </ul>
                    </div>               
                    <div id="tab_pie_3"></div>
                
            </div>
           

            <div id="pie4" class="tab-pane fade">
                      <div class="btn-group">
                          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                             <li><a onclick="pdf_export_graph('tab_pie_4', 'Grafik Pie Omset Non-konsumsi (Rp/bulan)')">Download PDF</a></li> 
                             <li><a href="#" onclick="btn_saveDashPie('tab_pie_4', 'Grafik Pie <br/>Omset Non-konsumsi (Rp/bulan)')">Save to dashboard</a></li>
                          </ul>
                    </div>                 
                    <div id="tab_pie_4"></div>
                
            </div>
        </div>
   
   </div>



    <?php


 
      $data_1 = array();
      $data_2 = array();
      $data_3 = array();
      $data_4 = array();


       $val_lbl = array();
      $lbl_data = array();
      foreach ($data_list->result() as $val) 
      {

          if(count($selected_group) > 0 )
          {
       
                foreach( $selected_group as $gb )
                {
                 

                   if($gb == 'nama_surveyor')
                     $val_lbl[$gb][] = $val->nama_surveyor;
                   elseif($gb == 'tanggal')
                     $val_lbl[$gb][]= $val->tanggal;
                   elseif($gb == 'nama_perusahaan')
                     $val_lbl[$gb][] = $val->nama_perusahaan;
                   elseif($gb == 'nama_komoditi')
                     $val_lbl[$gb][] = $val->nama_komoditi;
                   
                   
                }            
           
          }
          else
          {
            $lbl_data[] = $val->nama_perusahaan.'-'.$val->jenis_komoditi;
          }

           $isi_data[]  = (float) $val->harga;
           $isi_data2[]  = (float) $val->harga_kg;
           $isi_data3[]  = (float) $val->harga_l;
           $isi_data4[]  = (float) $val->omset;

           
           
           /*
            $label_1   = $label.'<br/>'. number_format($val->harga,0,',','.').'';
            $series_1  = (float) $val->harga;
            $data_1[]  = array('name' => $label_1, 'y' => $series_1);
            
            $label_2   = $label.'<br/>'. number_format($val->harga_kg,0,',','.').'';
            $series_2  = (float) $val->harga_kg;
            $data_2[]  = array('name' => $label_2, 'y' => $series_2);
           

            $label_3   = $label.'<br/>'. number_format($val->harga_l,0,',','.').'';
            $series_3  = (float) $val->harga_l;
            $data_3[]  = array('name' => $label_3, 'y' => $series_3);

            $label_4   = $label.'<br/>'. number_format($val->omset,0,',','.').'';
            $series_4  = (float) $val->omset;
            $data_4[]  = array('name' => $label_4, 'y' => $series_4);
                */
           
      } 

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
          }


      }

       for ($index = 0 ; $index < count($lbl_data); $index ++) {
            $data_harga[] = array($lbl_data[$index].'<br>Rp. '.number_format($isi_data[$index],2,',','.'), $isi_data[$index]);
        }

       for ($index = 0 ; $index < count($lbl_data); $index ++) {
            $data_harga_kg[] = array($lbl_data[$index].'<br>Rp. '.number_format($isi_data2[$index],2,',','.'), $isi_data2[$index]);
        }

        for ($index = 0 ; $index < count($lbl_data); $index ++) {
            $data_harga_l[] = array($lbl_data[$index].'<br>Rp. '.number_format($isi_data3[$index],2,',','.'), $isi_data3[$index]);
        }

       for ($index = 0 ; $index < count($lbl_data); $index ++) {
            $data_omset[] = array($lbl_data[$index].'<br>Rp. '.number_format($isi_data4[$index],2,',','.'), $isi_data4[$index]);
        }

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
                    text: 'Grafik Pie<br/>Harga Non-Konsumsi (Rp/Pcs)'
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
                    name: 'Rp/ekor',
                    colorByPoint: true,
                    data: <?php  echo json_encode($data_harga) ?>
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
                    text: 'Grafik Pie<br/>Harga Non-Konsumsi (Rp/KG)'
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
                    name: 'Rp/kg',
                    colorByPoint: true,
                    data: <?php  echo json_encode($data_harga_kg) ?>
                }]
            });

          Highcharts.chart('tab_pie_3', {
                chart: {
                    plotBackgroundColor: true,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Grafik Pie<br/>Harga Non-Konsumsi (Rp/L)'
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
                    name: 'Rp/L',
                    colorByPoint: true,
                    data: <?php  echo json_encode($data_harga_l) ?>
                }]
            });

            Highcharts.chart('tab_pie_4', {
                chart: {
                    plotBackgroundColor: true,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Grafik Pie<br/>Omzet Rata-rata Produk Perikanan Non-Konsumsi (Rp/Bulan)'
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
                    name: 'Rp/Tahun',
                    colorByPoint: true,
                    data: <?php  echo json_encode($data_omset) ?>
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
             $('#modal_saveDashGrafik #label_grafik').val('<?php  echo json_encode($data_harga) ?>');
          else if(id == 'tab_pie_2')
            $('#modal_saveDashGrafik #label_grafik').val('<?php  echo json_encode($data_harga_kg) ?>');
          else if(id == 'tab_pie_3')
             $('#modal_saveDashGrafik #label_grafik').val('<?php  echo json_encode($data_harga_l) ?>');
          else if(id == 'tab_pie_4')
            $('#modal_saveDashGrafik #label_grafik').val('<?php  echo json_encode($data_omset) ?>');
    }; 

    </script>

