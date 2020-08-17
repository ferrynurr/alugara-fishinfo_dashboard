  <div id="tab_table" class="table-responsive">

    <div class="btn-group" >
      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
         <li><a onclick="excel_export('tb_omset', 'Laporan Data Omset')">Download Excel</a></li> 
         <li><a onclick="pdf_export('tb_omset', 'Laporan Data Omset')">Download PDF</a></li> 
         <li><a href="#" onclick="savetoDash()">Save to dashboard</a></li>
      </ul>
    </div>
    
      <table id="tb_omset" class="table table-hover" cellspacing="0" width="100%">
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
                      if($gb == 'nama_trader')
                      {
                          echo '<th>Trader</a></th>';
                          array_push($array_db_label, "Trader");
                          array_push($array_db_field, "nama_trader|text");
                      }
                      if($gb == 'jenis')
                      {
                          echo '<th>jenis</a></th>';
                          array_push($array_db_label, "Jenis");
                          array_push($array_db_field, "jenis|text");

                      }
                  }
                    

                  echo '<th>Omset (Rp)</th>';
                  array_push($array_db_label, "Omzet (Rp)");
                  array_push($array_db_field, "omset|float");
                  
                }else{
                  echo '<th>Trader</th>';
                  echo '<th>Kegiatan</th>';
                  echo '<th>Tanggal Mulai</th>'; 
                  echo '<th>Tanggal Selesai</th>';
                  echo '<th>Jenis</th>';
                  echo '<th>Lokasi Jatim</th>'; 
                  echo '<th>Lokasi Luar Jatim</th>'; 
                  echo '<th>Omzet (Rp)</th>';
                  echo '<th>#</th>';

                  array_push($array_db_label, "Trader", "Kegiatan", "Tanggal Mulai", "Tanggal Selesai", "Jenis", "Lokasi Jatim", "Lokasi Luar Jatim", "Omzet (Rp)");
                  array_push($array_db_field, "nama_trader|text", "kegiatan|text", "tgl_mulai|date", "tgl_selesai|date", "jenis|text", "nama_kota|text", "nama_provinsi|text", "omset|float");
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
                      if($gb == 'nama_trader')
                          echo '<td>'.$val->nama_trader.'</td>';
                      if($gb == 'jenis')
                          echo '<td>'.$val->jenis.'</td>';

                    }


                  echo '<td style="mso-number-format:"#.000" ">'.number_format($val->omset,2,',','.').'</td>';
                  
                }else{
                  echo '<td>'.$val->nama_trader.'</td>';
                  echo '<td>'.$val->kegiatan.'</td>';
                  echo '<td>'.date("d-M-Y", strtotime($val->tgl_mulai)) .'</td>';
                  echo '<td>'.date("d-M-Y", strtotime($val->tgl_selesai)) .'</td>';
                  echo '<td>'.$val->jenis.'</td>';
                  echo '<td>'.(!empty($val->nama_kota) ? $val->nama_kota : '-').'</td>';
                  echo '<td>'.(!empty($val->nama_provinsi) ? $val->nama_provinsi : '-').'</td>';
                  echo '<td>'.number_format($val->omset,2,',','.').'</td>';
           
                  echo '<td>
                            <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->omset_id."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->omset_id."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          </td>';

                } 

              echo '</tr>';

            }
          ?>
       
        </tbody>
      </table>
  </div>