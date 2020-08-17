  <div id="tab_table" class="table-responsive">

    <div class="btn-group" style="padding-bottom: 10px;">
      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
         <li><a onclick="excel_export('tb_nonkonsumsi', 'Laporan Data <?= $title ?>')">Download Excel</a></li> 
         <li><a onclick="pdf_export('tb_nonkonsumsi', 'Laporan Data <?= $title ?>')">Download PDF</a></li> 
         <li><a href="#" onclick="savetoDash()">Save to dashboard</a></li>
      </ul>
    </div>
    
      <table id="tb_nonkonsumsi" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
              <?php 

                $array_db_field = array();
                $array_db_label = array('No');

               if($selected_group)
                    $grouping =  implode(",",$selected_group);
               else 
                    $grouping =  '';

               $array_grouping = explode(",", $grouping);

                echo '<th>No</th>';
                if(count($selected_group) > 0)
                { 
                  /*

                  foreach ($array_grouping as $row) {
                     echo '<th>'.ucwords(str_replace('_', ' ', $row)).'</th>';
                     array_push($array_db_label, ucwords(str_replace('_', ' ', $row)));
                     array_push($array_db_field, $row."|text");
                  }

                  
                    if($grouping == 'nama_surveyor')
                    {
                        echo '<th>Surveyor</th>';
                        array_push($array_db_label, "Surveyor");
                        array_push($array_db_field, "nama_surveyor|text");

                    }
                    elseif($grouping == 'nama_perusahaan')
                    {
                        echo '<th>Perusahaan</th>';
                        array_push($array_db_label, "Perusahaan");
                        array_push($array_db_field, "nama_perusahaan|text");
                       
                    }
                    else if($grouping == 'nama_komoditi')
                    {
                        echo '<th>Kelompok Komoditi</th>';
                        array_push($array_db_label, "Kelompok Komoditi");
                        array_push($array_db_field, "nama_komoditi|text");

                    }
                    else
                    {
                        echo '<th>Surveyor</th>';
                        echo '<th>Perusahaan</th>';
                        echo '<th>Kelompok Komoditi</th>';
                        array_push($array_db_label, "Surveyor", "Perusahaan", "Kelompok Komoditi");
                        array_push($array_db_field, "nama_surveyor|text",  "nama_perusahaan|text", "nama_komoditi|text");
                    }*/

                  foreach($selected_group as $gb)
                  {
                                                  
                      if($gb == 'nama_surveyor')
                      {
                          echo '<th>Surveyor</th>';
                          array_push($array_db_label, "Surveyor");
                          array_push($array_db_field, "nama_surveyor|text");
                      }                     
                       if($gb == 'tanggal')
                      {
                          echo '<th>Tanggal</th>';
                          array_push($array_db_label, "Tanggal");
                          array_push($array_db_field, "tanggal|text");
                      } 
                      if($gb == 'nama_perusahaan')
                      {
                          echo '<th>Perusahaan</th>';
                          array_push($array_db_label, "Perusahaan");
                          array_push($array_db_field, "nama_perusahaan|text");
                      }     
                      if($gb == 'nama_komoditi')
                      {
                          echo '<th>Kelompok Komoditi</th>';
                          array_push($array_db_label, "Kelompok Komoditi");
                          array_push($array_db_field, "nama_komoditi|text");
                      }


                  }

                  echo '<th>Harga (Rp/Ekor)</th>'; 
                  echo '<th>Harga (Rp/Kg)</th>'; 
                  echo '<th>Harga (Rp/L)</th>';
                  echo '<th>Omzet (Rp/Bulan)</th>';

                  array_push($array_db_label, "Harga (Rp/Ekor)", "Harga (Rp/Kg)", "Harga (Rp/L)", "Omzet (Rp/Bulan)");
                  array_push($array_db_field, "harga|float", "harga_kg|float", "harga_l|float", "omset|float");
                  
                }else{
                  echo '<th>Surveyor</th>';
                  echo '<th>Tanggal</th>';
                  echo '<th>Perusahaan</th>';
                  echo '<th>Kelompok Komoditi</th>';
                  echo '<th>Jenis Komoditi</th>';
                  echo '<th>Jenis Ikan Hias</th>';
                  echo '<th>Tujuan JATIM</th>';  
                  echo '<th>Tujuan Luar JATIM</th>';  
                  echo '<th>Tujuan Luar Negeri</th>'; 
                  echo '<th>Harga (Rp/Ekor)</th>'; 
                  echo '<th>Harga (Rp/Kg)</th>'; 
                  echo '<th>Harga (Rp/L)</th>';
                  echo '<th>Omzet (Rp/Bulan)</th>';
                  echo '<th>#</th>';

                  array_push($array_db_label, "Surveyor", "Tanggal", "Perusahaan", "Kelompok Komoditi", "Jenis Komoditi", "Jenis Ikan Hias", "Tujuan JATIM", "Tujuan Luar JATIM", "Tujuan Luar Negeri", "Harga (Rp/Ekor)", "Harga (Rp/Kg)", "Harga (Rp/L)", "Omzet (Rp/Bulan)");
                  array_push($array_db_field, "nama_surveyor|text", "tanggal|date", "nama_perusahaan|text", "nama_komoditi|text", "jenis_komoditi|text", "nama_ikan_hias|text", "tujuan_jatim|text", "tujuan_luar_jatim|text", "tujuan_luar_negeri|text", "harga|float", "harga_kg|float", "harga_l|float", "omset|float");
                } 

                 echo '<div style="display:none"><input id="field_db" type="text" value="'.implode(",", $array_db_field).'"></div>';
                 echo '<div style="display:none"><input id="field_label" type="text" value="'.implode(",", $array_db_label).'"></div>';

              ?>
           
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
          //  $array_grouping = explode(",", $grouping);

            foreach ($data_list->result() as $val) {
              $no++;

              echo '<tr>';
              echo '<td>'.$no.'</td>';

               if(count($selected_group) > 0)
                { 
                  /*
                  foreach ($array_grouping as $row) {
                   


                    $x = array("MONTH", "(", ")");
                    $y = array("", "", "");

                    $newphrase = str_replace($x, $y, $row);
                    if($newphrase == 'tanggal')
                       echo '<td>'.date("M-Y", strtotime($val->$newphrase)).'</td>';
                     else
                      echo '<td>'.$val->$newphrase.'</td>';

                  }
                
                    if($grouping == 'nama_surveyor')
                    {
                       echo '<td>'.$val->nama_surveyor.'</td>';

                    }
                    elseif($grouping == 'nama_perusahaan')
                    {
                        echo '<td>'.$val->nama_perusahaan.'</td>';
                       
                    }
                    else if($grouping == 'nama_komoditi')
                    {
                         echo '<td>'.$val->nama_komoditi.'</td>';

                    }
                    else
                    {
                       echo '<td>'.$val->nama_surveyor.'</td>';
                       echo '<td>'.$val->nama_perusahaan.'</td>';
                       echo '<td>'.$val->nama_komoditi.'</td>';
                    }*/

                    foreach($selected_group as $gb)
                    {

                       if($gb == 'nama_surveyor')
                      {
                         echo '<td>'.(!empty($val->nama_surveyor) ? $val->nama_surveyor : '-').'</td>';
                      }                     
                       if($gb == 'tanggal')
                      {
                          echo '<td>'.(!empty($val->tanggal) ? date("d-M-Y", strtotime($val->tanggal)) : '-').'</td>';
                      } 
                      if($gb == 'nama_perusahaan')
                      {
                         echo '<td>'.(!empty($val->nama_perusahaan) ? $val->nama_perusahaan : '-').'</td>';
                      }     
                      if($gb == 'nama_komoditi')
                      {
                         echo '<td>'.(!empty($val->nama_komoditi) ? $val->nama_komoditi : '-').'</td>';
                      }

                    }

                  echo '<td>'.number_format($val->harga,2,',','.').'</td>';
                  echo '<td>'.number_format($val->harga_kg,2,',','.').'</td>';
                  echo '<td>'.number_format($val->harga_l,2,',','.').'</td>';
                  echo '<td>'.number_format($val->omset,2,',','.').'</td>';
                  
                }
                else{
                  echo '<td>'.$val->nama_surveyor.'</td>';
                  echo '<td>'.date("d-M-Y", strtotime($val->tanggal)).'</td>';
                  echo '<td>'.(!empty($val->nama_perusahaan) ? $val->nama_perusahaan : '-').'</td>'; 
                  echo '<td>'.$val->nama_komoditi.'</td>'; 
                  echo '<td>'.(!empty($val->jenis_komoditi) ? $val->jenis_komoditi : '-').'</td>'; 
                  echo '<td>'.(!empty($val->nama_ikan_hias) ? $val->nama_ikan_hias : '-').'</td>';
                  echo '<td>'.(!empty($val->tujuan_jatim) ? $val->tujuan_jatim : '-').'</td>'; 
                  echo '<td>'.(!empty($val->tujuan_luar_jatim) ? $val->tujuan_luar_jatim : '-').'</td>'; 
                  echo '<td>'.(!empty($val->tujuan_luar_negeri) ? $val->tujuan_luar_negeri : '-').'</td>'; 
                  echo '<td>'.(!empty($val->harga) ? number_format($val->harga,2,',','.') : '0').'</td>';
                  echo '<td>'.(!empty($val->harga_kg) ? number_format($val->harga_kg,2,',','.') : '0').'</td>';
                  echo '<td>'.(!empty($val->harga_l) ? number_format($val->harga_l,2,',','.') : '0').'</td>';
                  echo '<td>'.(!empty($val->omset) ? number_format($val->omset,2,',','.') : '0').'</td>';
           
                  echo '<td>
                            <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->kode_survey_nonkonsumsi."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->kode_survey_nonkonsumsi."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          </td>';

                } 

              echo '</tr>';

            }
          ?>
       
        </tbody>
      </table>
  </div>