              <div id="tab_table">

                <div class="btn-group">
                  <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                     <ul class="dropdown-menu">
                       <li><a onclick="excel_export('tb_harga_konsumsi', 'Laporan Data <?= $title ?>')">Download Excel</a></li> 
                       <li><a onclick="pdf_export('tb_harga_konsumsi', 'Laporan Data <?= $title ?>')">Download PDF</a></li> 
                       <li><a href="#" onclick="savetoDash()">Save to dashboard</a></li>
                    </ul>
                </div>

                 
                 
                <div class="table-responsive" style="padding: 10px" >
                  <table id="tb_harga_konsumsi" class="table table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr class="noExl">
                        <?php 

                         $array_db_field = array();
                        // $grouping =  array();
                         $array_db_label = array('No');
                         echo '<th>No</th>';

                         if(count($selected_group) > 0)
                         {
                           // $grouping = $selected_group;
                           
                            foreach($selected_group as $gb)
                            {
                                if($gb == 'tanggal')
                                {
                                    echo '<th>Tanggal</th>';
                                    array_push($array_db_label, "Tanggal");
                                    array_push($array_db_field, "tanggal|date");
                                }                                  
                                if($gb == 'nama_surveyor')
                                {
                                    echo '<th>Surveyor</th>';
                                    array_push($array_db_label, "Surveyor");
                                    array_push($array_db_field, "nama_surveyor|text");
                                }
                                if($gb == 'nama_kota')
                                {
                                    echo '<th>Kota/Kab</th>';
                                    array_push($array_db_label, "Kota/Kab");
                                    array_push($array_db_field, "nama_kota|text");
                                }
                                if($gb == 'nama_ikan')
                                {
                                    echo '<th>Ikan</th>';
                                    array_push($array_db_label, "Ikan");
                                    array_push($array_db_field, "nama_ikan|text");
                                }

                            }


                            echo '<th>Volume (Kg)</th>';
                            echo '<th>Harga (Rp/kg)</th>'; 
                            array_push($array_db_label, "Volume (Kg)", "Harga (Rp/kg)");
                            array_push($array_db_field, "volume|number", "harga|float");
                         }
                         else
                         {
                            echo '<th>Tanggal</th>';
                            echo '<th>Surveyor</th>';
                            echo '<th>Kota/Kab</a></th>'; 
                            
                            if($jenis == 'tb_list_eceran')
                            {
                              echo '<th>Pasar</a></th>';
                              array_push($array_db_field, "nama_pasar|text");
                              array_push($array_db_label, "Pasar");
                            }

                            echo '<th>Ikan</th>';
                            echo '<th>Volume (Kg)</th>';
                            echo '<th>Harga (Rp/kg)</th>'; 
                            echo '<th>#</th>';

                            array_push($array_db_field, "tanggal|date", "nama_surveyor|text", "nama_kota|text", "nama_ikan|text", "volume|number", "harga|float");
                            array_push($array_db_label, "Tanggal", "Surveyor", "Kota/Kab", "Ikan", "Volume (Kg)", "Harga (Rp/kg)");
                         } 


                          echo '<div style="display:none"><input id="field_db" type="text" value="'.implode(",", $array_db_field).'"></div>';
                          echo '<div style="display:none"><input id="field_label" type="text" value="'.implode(",", $array_db_label).'"></div>';
                        ?>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no=0;

                        foreach ($data_list->result() as $val) 
                        {
                          $no++;
                          $vol_data = 0; 
                          $harga_data = 0;

                          if($val->volume)
                             $vol_data = number_format($val->volume,0,',','.');

                          if($val->harga)
                             $harga_data = number_format($val->harga,2,',','.');

                          echo '<tr>';
                          echo '<td>'.$no.'</td>';

                          if(count($selected_group) > 0)
                          { 
                            foreach($selected_group as $gb)
                            {
                              if($gb == 'tanggal')
                                echo '<td>'.(!empty($val->tanggal) ? date("d-M-Y", strtotime($val->tanggal)) : '-').'</td>';
                              if($gb == 'nama_surveyor')
                                echo '<td>'.(!empty($val->nama_surveyor) ? $val->nama_surveyor : '-').'</td>';
                              if($gb == 'nama_kota')
                                 echo '<td>'.$val->nama_kota.'</td>';
                              if($gb == 'nama_ikan')
                                echo '<td>'.(!empty($val->nama_ikan) ? $val->nama_ikan : '-').'</td>';

                            }
                              
                              echo '<td>'.$vol_data.'</td>';
                              echo '<td>'.$harga_data.'</td>';
                              
                          }
                          else
                          {
                              echo '<td>'.date("d-M-Y", strtotime($val->tanggal)).'</td>';
                              echo '<td>'.$val->nama_surveyor.'</td>';
                              echo '<td>'.$val->nama_kota.'</td>';

                              if($jenis == 'tb_list_eceran')
                              {
     
                                  echo '<td>'.(!empty($val->nama_pasar) ? $val->nama_pasar : '-').'</td>';

                              }

                              echo '<td>'.(!empty($val->nama_ikan) ? $val->nama_ikan : '-').'</td>';
                              echo '<td>'.$vol_data.'</td>';
                              echo '<td>'.$harga_data.'</td>'; 

                              echo '<td class="row_optional">
                                  <a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="delete_data('."'".$val->kode_survey_pasar."'".')"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                                  <a class="btn btn-primary btn-sm" href="javascript:void()" title="Edit" onclick="get_data('."'".$val->kode_survey_pasar."'".')"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </td>';
                          }

                          echo '</tr>';

                        }
                      ?>
                   
                    </tbody>
                  </table>
                </div>
              </div> 



