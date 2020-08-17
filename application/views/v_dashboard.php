
<?php
$this->load->view('template/head');
?>

 <link href="<?php echo base_url('assets/gentelella/vendors/leaflet/leaflet.css') ?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url('assets/gentelella/vendors/leaflet/leaflet1.css') ?>" rel="stylesheet" type="text/css"/>
 <script src="<?php echo base_url('assets/gentelella/vendors/leaflet/leaflet.js') ?>"></script>

<?php
$this->load->view('template/sidebar');
$this->load->view('template/topbar');
?>

<style type="text/css">
  #mapid { height: 400px; }

  /*Legend specific*/
.legend {
    line-height: 18px;
    color: #555;
}
.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
}

@media print {
  .brek {page-break-inside: avoid;}
}

</style>

<!-- page content -->
<div class="right_col" role="main">
      <center>

         <div class="btn-group">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Action all <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
               <li><a id="btn-downloadPDF">Download Table</a></li> 
               <li><a onclick="unduh_grafik()">Download Grafik</a></li> 
            </ul>
          </div>
       </center><br/>
         <div class="row" id="konten">
           <div class="col-lg-12 col-xs-12">      
              <div class="x_panel" id="maps_panel">
                  <div class="x_title">
                      <h2 class="x_title-h3 text-center"></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a title="Minimize" class="collapse-link"><i class="fa fa-chevron-up"></i></a> 
                        <li><a title="Close" class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <CENTER><h2>PETA SEBARAN VOLUME DAN HARGA IKAN KONSUMSI DI JAWA TIMUR</h2></CENTER><br/>

                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                      <button id="btg1" type="button" class="btn btn-default" onclick="map_filter('Eceran')">Eceran</button>
                      <button id="btg2" type="button" class="btn btn-default" onclick="map_filter('Grosir')">Grosir</button>
                      <button id="btg3" type="button" class="btn btn-default" onclick="refresh()">Semua Data</button>
                    </div>

                     <div id="mapid"></div>

                       <div style="visibility: hidden;">
                        <select id="umkm_select" class="select2" style="width: 120px;display: none;">
                            <?php foreach ($datamaps->result() as $value) {?>
                                <option id=<?php echo $value->kode_kota; ?>><?php echo $value->tot_volume ?></option>
                            <?php } ?>
                        </select>
                      </div>
                     

                  </div>
              </div>      
           </div>
                  <?php

                     foreach( $table_save->result() as $row ) 
                     {
                        echo '<div class="tabel_panel col-lg-6"><div class="x_panel" style="height:650px;">
                                <div class="x_title">
                                        <h2 class="x_title-h3 text-center">'.$row->dashtab_name.'</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                          <li><a title="Minimize" class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                          </li>
                                          <li><a title="Remove" style="color:#e86d6d;" onclick="delete_dash('.$row->dashtab_id.', '."'tabel'".')"><i class="fa fa-close"></i></a>
                                          </li>
                                        </ul>
                                        <div class="clearfix"></div>

                                </div>
                                <div class="x_content">';
                                    echo '<div class="btn-group">
                                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                           <li><a onclick="excel_export('."'tbsave_".$row->dashtab_id."'".', '."'".$row->dashtab_name."'".')">Download Excel</a></li> 
                                           <li><a onclick="pdf_export('."'tbsave_".$row->dashtab_id."'".', '."'".$row->dashtab_name."'".')">Download PDF</a></li>
                                        </ul>
                                      </div><br/><br/>';
                                    $th_data = explode(",", $row->thead );
                                    echo '<table id="tbsave_'.$row->dashtab_id.'" class="table table-hover" cellspacing="0" width="100%">';
                                    
                                    echo '        <thead>';
                                    echo '            <tr>';

                                    foreach ($th_data as $th_val) {
                                      echo '<th>'.$th_val.'</th>';
                                    }
                                    echo '            </tr>';
                                    echo '        </thead>';

                                    echo '        <tbody>'; 

                                    $td_field = explode(",",$row->thead_key);

                                    $saring_persen  = str_replace("~","%",$row->query);
                                    $saring_kurang  = str_replace("^","<",$saring_persen);
                                   // echo $saring_kurang;
                                    $td_data = $this->db->query($saring_kurang);
                                    $nomor = 0;
                                    foreach ($td_data->result() as $td_val) 
                                    {
                                      $nomor++;
                                      echo '<tr>';
                                      echo '<td>'.$nomor.'</td>';
                                      
                                      foreach ($td_field  as $field_val) 
                                      {
                                        $pecah = explode("|", $field_val);

                                        if( $td_val->{$pecah[0]} != '')
                                        {
                                            if($pecah[1] == 'number')
                                             echo '<td>'.number_format($td_val->{$pecah[0]},0,',','.').'</td>';
                                            elseif($pecah[1] == 'float')
                                                echo '<td>'.number_format($td_val->{$pecah[0]},2,',','.').'</td>';
                                            elseif($pecah[1] == 'text')
                                              echo '<td>'.$td_val->{$pecah[0]}.'</td>';
                                            elseif($pecah[1] == 'date')
                                              echo '<td>'.date("d-M-Y", strtotime($td_val->{$pecah[0]})).'</td>';
                                        }else
                                        {
                                            echo '<td>-</td>';
                                        }
                                       
                                      }
                                      echo '</tr>';
                                    }
                                   
                                    echo '        </tbody>';
                                    echo '</table>';
                            echo '</div></div></div>';

                      }
                      ?>

                      <script type="text/javascript">
                        var tipebar = [];
                        var tipepie = [];
                      </script>
                      <?php
                   
                      foreach ($grafik_save->result() as $row) 
                      {
                        if($row->type == 'bar')
                        {
                         
                            echo '<div class="col-lg-6"><div class="x_panel brek" style="height:650px;">
                                    <div class="x_title">
                                            <h2 class="x_title-h3 text-center">'.$row->dashgraf_name.'</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                              <li><a title="Minimize" class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                              </li>
                                              <li><a title="Remove" style="color:#e86d6d;" onclick="delete_dash('.$row->dashgraf_id.', '."'".$row->type."'".')"><i class="fa fa-close"></i></a>
                                              </li>
                                            </ul>
                                            <div class="clearfix"></div>

                                    </div>
                                    <div class="x_content">';
                                        echo '<div class="btn-group">
                                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                             <li><a onclick="pdf_export_graph('."'grafik_bar_".$row->dashgraf_id."'".', '."'Grafik Bar ".$row->dashgraf_name."'".')">Download PDF</a></li> 

                                            </ul>
                                          </div><br/><br/>';


                                        echo '<figure class="highcharts-figure">
                                                <div id="grafik_bar_'.$row->dashgraf_id.'"></div>
                                              </figure>';
                                echo '</div></div></div>';

                                $get_kayagori_txt  = read_file('./assets/data_graph/'.$row->data_katagori);
                               // $series_read = explode("|", read_file('./assets/data_graph/'.$row->data_series) );
                                $tit_label   = explode(",", $row->title_isi);
                                $series_data = explode(",", $row->data_series);
  
                                $data1 = array();
                                $data2 =  array();

                                $saring_persen  = str_replace("~","%",$row->query);
                                $saring_kurang  = str_replace("^","<",$saring_persen);
                                $bar_query = $this->db->query($saring_kurang);

                                foreach ($bar_query->result() as $val) 
                                {            
             
                                     $data1[] = (float) $val->{$series_data[0]}; 
                                     
                                     if(count($tit_label) > 1)
                                       $data2[] = (float) $val->{$series_data[1]};
                                            
                                }
                             //echo json_encode($series_data);
                          ?>

                          <script type="text/javascript">
                            
                            tipebar.push('grafik_bar_<?= $row->dashgraf_id ?>'); 
                             var graph = Highcharts.chart('grafik_bar_<?= $row->dashgraf_id ?>', {
                                chart: {
                                    type: 'column',
                                    //styledMode: true
                                },

                                title: {
                                    text: '<?= $row->title_grafik ?>'
                                },
                               
                                xAxis: {
                                    categories: <?= $get_kayagori_txt ?>,
                                    crosshair: true
                                 },

                                yAxis: [ 
                                    <?php 
                                      $nom=0; 
                                      foreach ($tit_label as $lab) 
                                      {                                          
                                          echo '{ 
                                                    className: "highcharts-color-'.$nom.'",
                                                    title: { text: "'.$lab.'" },';
                                          if($nom == 1)
                                            echo 'opposite: true';
                                                    
                                          echo  '  },';
                                          
                                        
                                        $nom++;
                                      } 
                                    ?>

                                  ],

                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled:true,
                                            borderRadius: 5,
                                            borderWidth: 1,
                                           

                                       }
                                    }
                                },
              
                              series: [
                                        <?php 
               
                                          echo '{ name: "'.$tit_label[0].'",
                                                  data: '.json_encode($data1).', } ,';
                                          if(count($tit_label) > 1 )
                                            echo '{ name: "'.$tit_label[1].'", data: '.json_encode($data2).', yAxis: 1,}';
                                    
                                        ?>
                             ]

                            });

                            $('#export-pdf').click(function () {
                                      Highcharts.exportCharts([graph], {
                                          type: 'application/pdf'
                                      });
                            });

                          </script>

                      <?php } 

                      if($row->type == 'pie')
                        {

                            echo '<div class="col-lg-6"><div class="x_panel" style="height:650px;">
                                    <div class="x_title">
                                            <h2 class="x_title-h3 text-center">'.$row->dashgraf_name.'</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                              <li><a title="Minimize" class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                              </li>
                                              <li><a title="Remove" style="color:#e86d6d;" onclick="delete_dash('.$row->dashgraf_id.', '."'".$row->type."'".')"><i class="fa fa-close"></i></a>
                                              </li>
                                            </ul>
                                            <div class="clearfix"></div>

                                    </div>
                                    <div class="x_content">';
                                        echo '<div class="btn-group">
                                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                             <li><a onclick="pdf_export_graph('."'grafik_pie_".$row->dashgraf_id."'".', '."'Grafik Pie ".$row->dashgraf_name."'".')">Download PDF</a></li> 

                                            </ul>
                                          </div><br/><br/>';


                                        echo '<figure class="highcharts-figure">
                                                <div id="grafik_pie_'.$row->dashgraf_id.'"></div>
                                              </figure>';
                            echo '</div></div></div>';

                            $get_pieData_txt  = read_file('./assets/data_graph/'.$row->data_katagori);

                     ?>

                     <script type="text/javascript">
                        tipepie.push('grafik_pie_<?= $row->dashgraf_id ?>'); 
                         var pie =  Highcharts.chart('grafik_pie_<?= $row->dashgraf_id ?>', {
                                      chart: {
                                          plotBackgroundColor: true,
                                          plotBorderWidth: null,
                                          plotShadow: false,
                                          type: 'pie'
                                      },
                                      title: {
                                          text: '<?= $row->title_grafik ?>'
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
                                          name: 'percent',
                                          colorByPoint: true,
                                          data: <?= $get_pieData_txt ?>
                                      }]
                                  });
                     </script>   

                    <?php } } ?>
              
          </div> <!-- ROW -->

          <br />
          <div id="editor"></div>
 
          


</div>
<!-- /page content -->

  <!-- modal edit -->
  <div class="modal fade" id="modal_view_img" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title"></h3>
        </div>
         <div class="modal-body">
            <div class="pull-left">
              <!--
              <a id="downloadimage" class="btn btn-success btn-sm"  href="#"><i class="fa fa-download" aria-hidden="true"></i> Download Gambar</a> -->
             <button type="button" onclick="btntoPDF()" class="btn btn-warning btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download PDF</button>
              
            </div>

            <div class="pull-right">
              
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>

            </div><br/><br/>
            

           
          </div>    

          <div class="modal-footer" id="img-viewer">        
            <div class="text-center">
               <img id="gmb" src="#" class="img-thumbnail" alt="Please Loading ...."style="width: 320px; height: 900px;">

          </div>
         
      </div>
    </div>
  </div> <!-- end modal -->

<script type="text/javascript">
  

   $(document).ready(function() 
   {
      $("#dashboard_nav").addClass('active');

            $.ajax({
                url: "<?php echo site_url('dashboard/get_tablesave')?>" ,
                type: "GET",
                dataType: "json",
                success:function(data) {

                  // alert('success');
                    $.each(data, function(key, value) {
                       // alert(value.dashtab_id);
                        $('#tbsave_'+value.dashtab_id).DataTable({
                          "searching": false,
                           "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All Data"]],
                           "columnDefs": [
                                              { "width": "3%", "targets": 0 }
                                          ],
                           "scrollY": "50vh",
                           "scrollX": "100%",
                           "pageLength" : 5,
                           "scrollCollapse": true,
                        }); 
                    });


                },
              error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error get data from ajax');
                  }

            });


        var info = L.control();

        $.getJSON("<?php echo base_url('assets/data_maps/kab_kot_yp.geojson') ?>",function(data){
            L.geoJson(data, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(newMap);
        });

        //### Revisi Yustaf
        var newMap = L.map('mapid', { zoomControl:true, scrollWheelZoom: false }).setView([-7.656023,113.4628653], 8, );

        var positron = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}.png', {
                //attribution: 'Â©OpenStreetMap, Â©CartoDB'
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, © <a href="https://carto.com/attribution/">CARTO</a>',
        }).addTo(newMap);

        /* var positron = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZmVycnludXJyIiwiYSI6ImNqeDNtNmxvdjAwaW4zenBneHZzMzdxazYifQ.cZWA6kKj10GpHzPhBzYuoQ'
          }).addTo(newMap);
        */
        
        info.onAdd = function (newMap) {
          this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
          this.update();
          return this._div;
        };
        
        // method that we will use to update the control based on feature properties passed
        info.update = function (props) {
            var exists = false;
            var x=0;
            if (props){
                exists = isExist(props.kabupate_1);
                // alert (1);
                if (exists==true){
                    var vol =  document.getElementById("umkm_select").options.namedItem(props.kabupate_1).text;

                    x =  Intl.NumberFormat('id', {}).format(vol);

                }

            }
            this._div.innerHTML = '<h4>Total Volume</h4>' +  (props ?
                '<b>' + props.kabupaten + '</b><br />' + x + ' Kg'
                : 'Arahkan ke Kota/kabupaten');
        };
        
        info.addTo(newMap);
        newMap.createPane('labels');
        newMap.getPane('labels').style.zIndex = 650;
        newMap.getPane('labels').style.pointerEvents = 'none';

        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (newMap) {

            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, 5, 500, 1000, 4000, 7000, 10000, 50000],
                labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getLegend(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }

            return div;
        };

        legend.addTo(newMap);

       function getColor(d) {
          var exists = $("#umkm_select option")
                 .filter(function (i, o) { return o.id == d; })
                 .length > 0;
          var x=0;
          if (exists==true){
              x = document.getElementById("umkm_select").options.namedItem(d).text;
          }

          return getLegend(x);
       }

       function style(feature) {
            return {
                //### Revisi Yustaf
                fillColor: getColor(feature.properties.kabupate_1),
                //###
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

                  //alert('te');
        function highlightFeature(e) {
          var layer = e.target;
          info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
          //geojson.resetStyle(e.target);
          info.update();
        }

        function isExist(d) {
          var exists = $("#umkm_select option")
                 .filter(function (i, o) { return o.id == d; })
                 .length > 0;
          return exists;
        }



        function getLegend(x) {
          return x > 50000  ? '#800026' :
               x > 10000  ? '#BD0026' :
               x > 7000  ? '#E31A1C' :
               x > 4000  ? '#FC4E2A' :
               x > 1000   ? '#FD8D3C' :
               x > 500  ? '#FEB24C' :
               x > 5    ? '#FED976' :
                    '#FFEDA0';/**/
        }


        function onEachFeature(feature, layer) {
              layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: detailFeature
              });


                  $.ajax({
                              url : "<?= base_url('dashboard/get_DataMaps/')?>"+feature.properties.kabupate_1,
                              type: "GET",
                              dataType: "json",
                              success: function(data)
                              {
                         
                               var rego = [];
                               var iwak = [];

                                 $.each(data, function(key, val) {
                                  var hr =  val.avg_harga.split('.')[0];
                                  var formatulang = Intl.NumberFormat('id', {}).format(hr);
                                  
                                   iwak.push({
                                        nama  : val.nama_ikan, 
                                        harga : formatulang
                                    });
                                  });

                                var html = '<div style="height: 130px; width:200px; overflow: auto;"><div style="text-align:center;">Harga Rata-Rata<br/>'+feature.properties.kabupaten+'</div><br/>';

                                  if(data != ''){
                                     var no=1;
                                     for (var i = 0; i < iwak.length; i++) {
                                          html+= '<b style="font-size:12px">'+no+'). ';
                                          html+= iwak[i].nama+" : ";
                                          html+= 'Rp.'+iwak[i].harga+'</b>';
                                          html+= '<br/>';
                                          no++;
                                      }
                                  }
                                  else 
                                     html+= '<center style="color:red;">(Belum Ada Data)</center>';

                                html+='</div>';

                                layer.bindPopup(html);

                              }
                   });


        }

        function detailFeature()
        {

        }

        var input_get = '<?= $this->input->get('maps_data') ?>';

        if(input_get)
        {
            if(input_get == 'Eceran')
            {
               $('#btg1').addClass('active');
               $('#btg1').html('Eceran <i style="color: blue;" class="fa fa-check" aria-hidden="true"></i>');
            }
            if(input_get == 'Grosir')
            {
               $('#btg2').addClass('active');
               $('#btg2').html('Grosir <i style="color: blue;" class="fa fa-check" aria-hidden="true"></i>');
            }
        }
        else{
          $('#btg3').addClass('active');
          $('#btg3').html('Semua Data <i style="color: blue;" class="fa fa-check" aria-hidden="true"></i>');
        }

   });

  function map_filter(id){

      var url = '<?= base_url('dashboard') ?>';

      $.redirect(url, 
      {
           maps_data: id,
        
      },  "GET");

  }
  
  $('#btn-downloadPDF').click(function(){
    $("#loader").fadeIn();
    setTimeout(function()
    { 
        window.open(
          '<?= base_url('dashboard/download_all') ?>',
          '_blank' // <- This is what makes it open in a new window.
        );
        $("#loader").fadeOut(); 
    }, 1000); 
    

  });
  
/*  
var id_kon;
 function unduh_grafik()
 {
    $("#maps_panel").hide();
    $('.tabel_panel').hide();

    $("#gmb").attr("src", '');
    //var newData;
    html2canvas(document.querySelector("#konten")).then(canvas => {
        //document.body.appendChild(canvas)
         $("#editor").append(canvas);
         var myImage = canvas.toDataURL("image/png");

         var newData = myImage.replace(/^data:image\/png/, "data:application/octet-stream"); 
        //  var newData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");

         $("#downloadimage").attr("download", "Grafik_dashboard.png").attr("href", newData);
         $("#gmb").attr("src", newData);
         $("#editor").remove();
        id_kon = myImage;

    });



     $('#modal_view_img').modal('show');
     $('#modal_view_img .modal-title').text('Images Preview');
     $("#maps_panel").show();
     $('.tabel_panel').show();

 }
 */



var counter = 0;

var imgurls = [];


Highcharts.downloadURL = function(dataURL, filename) {
    if (dataURL.length > 2000000) {
        dataURL = Highcharts.dataURLtoBlob(dataURL);
        if (!dataURL) {
            throw 'Data URL length limit reached';
        }
    }
    imgurls.push(dataURL);
    counter++;
};



function unduh_grafik()
{
    $("#loader").fadeIn();
    setTimeout(function()
    { 

            var jum = tipepie.length + tipebar.length;

            var pdff = new jsPDF('l', 'mm', 'a4');

            tipepie.forEach(function(entry) {
              //console.log(entry);
               $('#'+entry).highcharts().exportChartLocal('image/svg+xml');
            });

            tipebar.forEach(function(entry) {
              //console.log(entry);
               $('#'+entry).highcharts().exportChartLocal('image/svg+xml');
            });
             
            var interval = setInterval(function() {
                  if (counter === jum) {
                      clearInterval(interval);
                      imgurls.forEach(function(img) {
                          //pdff.addImage(img, 'SVG', 10, 10);
                          
                          pdff.addImage(img, 'SVG', 10, 10, 270, 170);
                          pdff.addPage();
                      });
                      pdff.save('[Grafik] Laporan Dashboard Fishinfo.pdf');
                  }
              }, 100);
             $("#loader").fadeOut(); 
    }, 1000); 
}

/*
 function btntoPDF(){
      var images = document.getElementById("gmb");

       //var doc = new jsPDF(); //210mm wide and 297mm high

       
                
      // doc.addImage(, 'PNG', divWidth, divHeight);
      // doc.save('sample.pdf');


            //var doc = new jsPDF('p', 'pt', [220, 600]); //A4
            var doc = new jsPDF('p', 'pt', 'a4'); //A4
            var width = doc.internal.pageSize.width;    
            var height = doc.internal.pageSize.height;
            var options = {
                 pagesplit: false
            };
            //doc.text(10, 20, 'Crazy Monkey');
            var h1=10;
            var aspectwidth1= (height-h1)*(9/16);
            doc.addImage(images, 'JPEG', 10, h1, 200, (height-h1));
             //doc.addImage(images, 'JPEG', 70, h1, 215, 400);
            doc.addPage();
            doc.save('sample.pdf');

 }
 */

  function delete_dash(id, jenis)
  {
    var link;

    if(jenis == 'tabel')
        link = "<?= base_url('dashboard/ajax_delete')?>/"+id+'/dash_table_save/'+jenis;
    else if(jenis == 'bar' || jenis == 'pie')
        link = "<?= base_url('dashboard/ajax_delete')?>/"+id+'/dash_grafik_save/'+jenis;

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
                url : link,
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
      });
  }

  function refresh()
  {
    window.location.href= '<?= base_url('dashboard') ?>';
    // table.ajax.reload(null,false); //reload datatable ajax
  }
  

</script>

<?php
$this->load->view('template/foot');
?>
