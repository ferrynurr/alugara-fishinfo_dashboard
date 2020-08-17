  <div id="tab_table" class="table-responsive">

    <div class="btn-group" style="padding-bottom: 10px;">
      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
         <li><a onclick="excel_export('tb_in_out', 'Laporan Data <?= $title ?>')">Download Excel</a></li> 
         <li><a onclick="pdf_export('tb_in_out', 'Laporan Data <?= $title ?>')">Download PDF</a></li> 
         <li><a href="#" onclick="savetoDash()">Save to dashboard</a></li>
      </ul>
    </div>
    
      <table id="tb_in_out" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
              <?php 

                $array_db_field = array();
                $array_db_label = array('No');
                $label_nilai   = ''; 
                $label_astuj   = '';
                $isi_asyuj     = '';
                $value_astuj   = '';
                $pk_id         = '';

  

                if( $jenis == 'dom_masuk')
                {
                     $label_nilai   = 'Nilai (Rp)'; 
                     $label_astuj   = 'Daerah Asal';
                     $isi_asyuj     = 'asal|text';
                     $value_astuj   = 'asal';
                     $pk_id         = 'dom_masuk_id';
                }
                elseif( $jenis == 'dom_keluar')
                {
                      $label_nilai   = 'Nilai (Rp)'; 
                      $label_astuj   = 'Daerah Tujuan';
                      $isi_asyuj     = 'tujuan|text';
                      $value_astuj   = 'tujuan';
                      $pk_id         = 'dom_keluar_id';
                }
                elseif( $jenis == 'impor' )
                {
                     $label_nilai   = 'Nilai (USD)'; 
                     $label_astuj   = 'Negara Asal';
                     $isi_asyuj     = 'asal|text';
                     $value_astuj   = 'asal';
                     $pk_id         = 'impor_id';
                }
                elseif( $jenis == 'ekspor')
                {
                      $label_nilai   = 'Nilai (USD)'; 
                      $label_astuj   = 'Negara Tujuan';
                      $isi_asyuj     = 'tujuan|text';
                      $value_astuj   = 'tujuan';
                      $pk_id         = 'ekspor_id';
                }

                echo '<th>No</th>';
                if(count($selected_group) > 0)
                { 

                    foreach($selected_group as $gb)
                    {
                        if($gb == 'trader_name')
                        {
                            echo '<th>Trader</th>';
                            array_push($array_db_label, "Trader");
                            array_push($array_db_field, "trader_name|text");
                        }
                         if($gb == 'jenis_komoditas')
                        {
                            echo '<th>Jenis Komoditas</th>';
                            array_push($array_db_label, "Jenis Komoditas");
                            array_push($array_db_field, "jenis_komoditas|text");

                        }
                        if($gb == 'nama_komoditas_kel')
                        {
                            echo '<th>Kelompok Komoditas</th>';
                            array_push($array_db_label, "Kelompok Komoditas");
                            array_push($array_db_field, "nama_komoditas_kel|text");

                        }
                    }
      


                  echo '<th>Jumlah</th>';
                  echo '<th>Satuan Jumlah</th>';
                  echo '<th>'.$label_nilai.'</th>';
                  array_push($array_db_label, "Jumlah", "Satuan Jumlah", $label_nilai);
                  array_push($array_db_field, "jumlah_awal|number", "satuan_awal|text", "nilai|float");
                  
                }else{
                  echo '<th>Trader</th>';
                  echo '<th>Tanggal</th>';
                  echo '<th>Jenis Komoditas</th>';
                  echo '<th>Kelompok Komoditas</th>';
                  echo '<th>Jumlah</th>'; 
                  echo '<th>Satuan Jumlah</th>'; 
                  echo '<th>'.$label_nilai.'</th>';
                  echo '<th>'.$label_astuj.'</th>';
                  echo '<th>#</th>';

                  array_push($array_db_label, "Trader", "Tanggal", "Jenis Komoditas", "Kelompok Komoditas", "Jumlah", "Satuan Jumlah", $label_nilai, $label_astuj);
                  array_push($array_db_field, "trader_name|text", "tgl|date", "jenis_komoditas|text", "nama_komoditas_kel|text", "jumlah_awal|number", "satuan_awal|text", "nilai|float", $isi_asyuj);
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
                       if($gb == 'trader_name')
                        {
                           echo '<td>'.$val->trader_name.'</td>';
                        }
                        else if($gb == 'jenis_komoditas')
                        {
                            echo '<td>'.$val->jenis_komoditas.'</td>';

                        }
                        else if($gb == 'nama_komoditas_kel')
                        {
                           echo '<td>'.$val->nama_komoditas_kel.'</td>';

                        }
                    }
                   
                   

                  echo '<td>'.number_format($val->jumlah_awal,0,',','.').'</td>';
                  echo '<td>'.$val->satuan_awal.'</td>';
                  echo '<td>'.number_format($val->nilai,2,',','.').'</td>';
                  
                }else{

                  echo '<td>'.$val->trader_name.'</td>';
                  echo '<td>'.date("d-M-Y", strtotime($val->tgl)) .'</td>';
                  echo '<td>'.$val->jenis_komoditas.'</td>'; 
                  echo '<td>'.$val->nama_komoditas_kel.'</td>';
                  echo '<td>'.number_format($val->jumlah_awal,0,',','.').'</td>'; 
                  echo '<td>'.$val->satuan_awal.'</td>';
                  echo '<td>'.number_format($val->nilai,2,',','.').'</td>';
                  echo '<td>'.$val->$value_astuj.'</td>'; 
                  echo '<td>
                            <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->$pk_id."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->$pk_id."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          </td>';

                } 

              echo '</tr>';

            }
          ?>
       
        </tbody>
      </table>
  </div>