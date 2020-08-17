  <div id="tab_table" class="table-responsive">

    <div class="btn-group" style="padding-top: 15px;padding-bottom: 10px;">
      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
         <li><a onclick="excel_export('tb_konsumsi_ikan', 'Laporan Data <?= $title ?>')">Download Excel</a></li> 
         <li><a onclick="pdf_export('tb_konsumsi_ikan', 'Laporan Data <?= $title ?>')">Download PDF</a></li> 
         <li><a href="#" onclick="savetoDash()">Save to dashboard</a></li>
      </ul>
    </div>
    
      <table id="tb_konsumsi_ikan" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
              <?php 

                $array_db_field = array();
                $array_db_label = array('No');

                echo '<th>No</th>';
                if(count($selected_group) > 0)
                { 
                  foreach($selected_group as $gb)
                  {
                      if($gb == 'nama_kota')
                      {
                          echo '<th>Kota/Kab</th>';
                          array_push($array_db_label, "Kota/Kab");
                          array_push($array_db_field, "nama_kota|text");
                         
                      }
                      else if($gb == 'tahun')
                      {
                          echo '<th>Tahun</th>';
                          array_push($array_db_label, "Tahun");
                          array_push($array_db_field, "tahun|text");

                      }

                  }


                  echo '<th>Konsumsi Ikan (kg/kapita/tahun)</th>';
                  echo '<th>Kebutuhan Ikan (kg)</th>';
                  array_push($array_db_label, "Konsumsi Ikan (kg/kapita/tahun)", "Kebutuhan Ikan (kg)");
                  array_push($array_db_field, "tot_konsumsi|text", "kebutuhan|number");
                  
                }else{
                  echo '<th>Kota/Kab</th>';
                  echo '<th>Tahun</th>';
                  echo '<th>Jumlah Penduduk</th>'; 
                  echo '<th>Konsumsi Ikan (kg/kapita/tahun)</th>';
                  echo '<th>Kebutuhan Ikan (kg)</th>';
                  echo '<th>#</th>';

                  array_push($array_db_label, "Kota/Kab", "Tahun", "Jumlah Penduduk", "Konsumsi Ikan (kg/kapita/tahun)", "Kebutuhan Ikan (kg)");
                  array_push($array_db_field, "nama_kota|text", "tahun|text", "jum_penduduk|number", "tot_konsumsi|text", "kebutuhan|number");
                } 

                 echo '<div style="display:none"><input id="field_db" type="text" value="'.implode(",", $array_db_field).'"></div>';
                 echo '<div style="display:none"><input id="field_label" type="text" value="'.implode(",", $array_db_label).'"></div>';

              ?>
           
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;

            foreach ($data_list->result() as $val) {
              $no++;

              echo '<tr>';
              echo '<td>'.$no.'</td>';

              if(count($selected_group) > 0)
                { 
                  foreach($selected_group as $gb)
                   {
                      if($gb == 'nama_kota')
                          echo '<td>'.$val->nama_kota.'</td>';
                      if($gb == 'tahun')
                          echo '<td>'.$val->tahun.'</td>';

                   }

                  echo '<td>'.number_format($val->tot_konsumsi,0,',','.').'</td>';
                  echo '<td>'.number_format($val->kebutuhan,0,',','.').'</td>';
                  
                }else{
                  echo '<td>'.$val->nama_kota.'</td>';
                  echo '<td>'.$val->tahun.'</td>';
                  echo '<td>'.number_format($val->jum_penduduk,0,',','.').'</td>';
                  echo '<td>'.$val->tot_konsumsi.'</td>';        
                  echo '<td>'.number_format($val->kebutuhan,0,',','.').'</td>';
           
                  echo '<td>
                            <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->konsumsi_id."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->konsumsi_id."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          </td>';

                } 

              echo '</tr>';

            }
          ?>
       
        </tbody>
      </table>
  </div>