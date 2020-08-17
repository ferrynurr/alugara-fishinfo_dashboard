   <br/>
    <div id="tab_grafik">

       <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" onclick="tab_grafik('grafik_bar1', 'GRAFIK BAR <br/> Harga <?= $title ?> (Rp/pcs)', 'harga')" href="#home">Harga (Rp/Pcs)</a></li>
            <li><a data-toggle="tab" onclick="tab_grafik('grafik_bar2', 'GRAFIK BAR <br/> Harga <?= $title ?> (Rp/Kg)', 'harga_kg')" href="#menu1">Harga (Rp/KG)</a></li>
            <li><a data-toggle="tab" onclick="tab_grafik('grafik_bar3', 'GRAFIK BAR <br/> Harga <?= $title ?> (Rp/L)', 'harga_l')" href="#menu2">Harga (Rp/L)</a></li>
            <li><a data-toggle="tab" onclick="tab_grafik('grafik_bar4', 'GRAFIK BAR <br/> Omset Rata-rata Produk Perikanan <?= $title ?> (Rp/bulan)', 'omset', )" href="#menu3">Omset</a></li>
        </ul>
        <br/>
        <div class="tab-content"> 
           <div class="btn-group">
              <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                 <li><a id="btn-pdf">Download PDF</a></li> 
                 <li><a href="#" id="btn-savegraph">Save to dashboard</a></li>
              </ul>
            </div>

            <div id="home" class="tab-pane fade in active">
              <figure class="highcharts-figure">
                <div id="grafik_bar1"></div>
              </figure>
               
            </div>
          
            <div id="menu1" class="tab-pane fade">         
              <figure class="highcharts-figure">
                <div id="grafik_bar2"></div>
              </figure>
                 
            </div>
            

            <div id="menu2" class="tab-pane fade">
              <figure class="highcharts-figure">
                <div id="grafik_bar3"></div>
              </figure>
                
            </div>
           

            <div id="menu3" class="tab-pane fade">
              <figure class="highcharts-figure">
                <div id="grafik_bar4"></div>
              </figure>
                
            </div>
        </div>

   </div>



    <?php

      $label = array();
      $data1 = array();
      $data2 =  array();
      $data3 =  array();

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
                   if($gb == 'tanggal')
                     $val_lbl[$gb][]= $val->tanggal;
                   if($gb == 'nama_perusahaan')
                     $val_lbl[$gb][] = $val->nama_perusahaan;
                   if($gb == 'nama_komoditi')
                     $val_lbl[$gb][] = $val->nama_komoditi;
                   
                }            
           
          }
          else
          {
            $lbl_data[] = $val->nama_perusahaan.'<br/>('.$val->nama_ikan_hias;
          }

          //$volume[] = (float) $val->volume;
          //$harga[]  = (float) $val->harga;

            $data1[] = (float) $val->harga;
            $data2[] = (float) $val->harga_kg;
            $data3[] = (float) $val->harga_l;
            $data4[] = (float) $val->omset;
           
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
   
     // $simpan_lbl_data = 'Omset (Rp)';
     // $simpan_data     = 'omset';//json_encode($data1).'|'.json_encode($data2);

    ?>
    
    <!-- JS -->

<script type="text/javascript">

  var tab_val = 'grafik_bar1';
  var tab_txt = 'GRAFIK BAR<br/> Harga <?= $title ?> (Rp/pcs)';
  var tab_x   = 'harga';
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
      
         $('#grafik_bar1').highcharts({

                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'GRAFIK BAR<br/> Harga <?= $title ?> (Rp/pcs)'
                    },
                    subtitle: {
                        text: 'Source: www.fishinfojatim.net'
                    },

                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                borderRadius: 5,
                                borderWidth: 1,
                            }
                        }
                    },

                    xAxis: {
                        categories: <?= json_encode($lbl_data) ?>,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ' Harga (Rp)'
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
      
                  series: [{ 
                                name: 'Harga Ikan Non-konsumsi (Rp/pcs)',
                                data: <?= json_encode($data1) ?>
                            }]
                });
          

           $('#grafik_bar2').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'GRAFIK BAR<br/> Harga <?= $title ?> (Rp/Kg)'
                    },
                    subtitle: {
                        text: 'Source: www.fishinfojatim.net'
                    },

                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                borderRadius: 5,
                                borderWidth: 1,
                            }
                        }
                    },

                    xAxis: {
                        categories: <?= json_encode($lbl_data) ?>,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ' Harga (Rp)'
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
      
                  series: [{ 
                                name: 'Harga Ikan Non-konsumsi (Rp/Kg)',
                                data: <?= json_encode($data2) ?>
                            }]
                });

           $('#grafik_bar3').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'GRAFIK BAR<br/> Harga <?= $title ?> (Rp/L)'
                    },
                    subtitle: {
                        text: 'Source: www.fishinfojatim.net'
                    },

                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                borderRadius: 5,
                                borderWidth: 1,
                            }
                        }
                    },

                    xAxis: {
                        categories: <?= json_encode($lbl_data) ?>,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: ' Harga (Rp)'
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
      
                  series: [{ 
                                name: 'Harga Ikan Non-konsumsi (Rp/L)',
                                data: <?= json_encode($data3) ?>
                            }]
                });


           $('#grafik_bar4').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'GRAFIK BAR<br/> Omzet Rata-rata Produk Perikanan Non-konsumsi (Rp/Bulan)'
                    },
                    subtitle: {
                        text: 'Source: www.fishinfojatim.net'
                    },

                    plotOptions: {
                        series: {
                            dataLabels: {
                                enabled: true,
                                borderRadius: 5,
                                borderWidth: 1,
                            }
                        }
                    },

                    xAxis: {
                        categories: <?= json_encode($lbl_data) ?>,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Omzet (Rp)'
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
      
                  series: [{ 
                                name: 'Omzet',
                                data: <?= json_encode($data4) ?>
                            }]
                });

            $("#loader").fadeOut(); 
         }, 1000);
         klikg=1;
      }
  }

  function tab_grafik(id, txt, tipe)
  {
   tab_val = id;
   tab_txt = txt;
   tab_x = tipe;
  }

  $("#btn-savegraph").click(function(){
        $('#modal_saveDashGrafik').modal('show'); // show bootstrap modal
        $('#dashgraf_name').val('');
        $('#modal_saveDashGrafik #type_grafik').val('bar');
        $('#modal_saveDashGrafik #label_grafik').val('<?= $simpan_catag ?>');
        $('#modal_saveDashGrafik #isi_grafik').val(tab_x);  
        $('#modal_saveDashGrafik #title_isi').val(tab_x+' (Rp)');
        $('#modal_saveDashGrafik #title_grafik').val(tab_txt);
  }); 

    $("#btn-pdf").click(function(){
        $('#btn-pdf').attr('onclick', pdf_export_graph(tab_val, tab_txt));
  }); 




</script>