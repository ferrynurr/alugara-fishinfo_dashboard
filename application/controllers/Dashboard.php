<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Dashboard extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');
		

		$this->load->model('M_dashboard', 'dash');
			
	}

	public function index()
	{
		$data = array( 'title'	     => 'Dashboard',
					   'sub_title'   => '',
					   'table_save'  => $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->get('dash_table_save'),
					   'grafik_save'  => $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->get('dash_grafik_save'),
					   'datamaps'     => $this->dash->Maps(0),
		             );

		$this->load->view('v_dashboard', $data);
			

	}

	public function get_tablesave()
	{
		$data = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->get('dash_table_save');
		
		echo json_encode($data->result() );

	}

	public function dash_grafik_save($id='')
	{
		$this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'));
		if($id != '')
			$this->db->where('type', $id);
		$data = $this->db->get('dash_grafik_save');
		
		echo json_encode($data->result() );

	}

	public function getquery($id)
	{
		$this->db->where('dashtab_id', $id);
		$get = $this->db->get('dash_table_save')->row();

		//echo json_encode($data->result());
		    $list = $this->db->query($get->query);
    		$data = array();
    		foreach ($list->result() as $key => $value) {
    	
    			$row = array();

            
    		   //$row[$key] = $value;
    		 $row[] = $field->nama_ikan;
    		 $row[] = $field->volume;
    		 $row[] = $field->harga;
    		 $row[] = $field;
    		  
    		  $data[] = $row;
    		}

			## Response
			
			$results = ["sEcho" => 1,

			        	"iTotalRecords" => count($data),

			        	"iTotalDisplayRecords" => count($data),

			        	"aaData" => $data ];


			echo json_encode($results);

	}

	public function profile()
	{
		$data = array( 'title'	     => 'Detail Akun',
					   'sub_title'   => '',
					   'data_kota'	 => $this->db->order_by('nama_kota', 'asc')->get('kota')
		             );

		$this->load->view('v_profile', $data);
	}

	public function get_user()
	{
		$this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor') );
		$data = $this->db->get('surveyor');

		echo json_encode($data->row() );
	}

	public function update_profile($id)
	{
		if($id == 'bio')
		{
			$data = array('nama_surveyor'  => $this->input->post('nama_surveyor'),
	          			  'status_pegawai' => $this->input->post('status_pegawai'),
	           			  'alamat'		   => $this->input->post('alamat'),
	           			  'kode_kota'	   => $this->input->post('kode_kota'),
	           			  'no_telp'        => $this->input->post('no_telp'),
	          			  'email_surveyor' => $this->input->post('email_surveyor'),
	           			  'nip'		       => $this->input->post('nip'),
	           			  'npwp'		   => $this->input->post('npwp'),
	      				 );

	        $query = $this->dash->update('surveyor', array('kode_surveyor' => $this->session->userdata('kode_surveyor') ), $data);

	        if($query > 0)
	        {
				$session_data = array( 'nama_surveyor'  => $this->input->post('nama_surveyor'),
						               'email_surveyor' => $this->input->post('email_surveyor'),
	                                 );

				$this->session->set_userdata($session_data);
	        }
	       
		}
		elseif($id == 'login')
		{

                $data = array('password_surveyor'  => md5($this->input->post('passwd_new_conf')) );
	            $query = $this->dash->update('surveyor', array('kode_surveyor' => $this->session->userdata('kode_surveyor') ), $data);
                    
			
		}

        echo json_encode(array("status" => TRUE));

	}

    public function get_trader($id)
	{
		$this->db->where('trader_id', $id);
		$data = $this->db->get('dash_trader');

		echo json_encode($data->row() );
	}

	public function cetak_pdf()
	{
		$this->load->library('pdf');

        $data = array('head' => implode(",", $this->input->post('header') ),
        	          'isi' => $this->input->post('isi') ,
        	          'judul' => $this->input->post('judul') ,
        	         );

        //$this->pdf->setBasePath('./upload/');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = $this->input->post('judul').".pdf";
        $this->pdf->load_view('pdf/laporan', $data);
      
      //echo json_encode(array("status" => TRUE));

    }

    public function ajax_delete($id, $tbl, $jenis)
    {
       if($jenis == 'tabel')
       		$this->dash->delete($tbl, array('dashtab_id' => $id));
       elseif($jenis == 'bar' || $jenis == 'pie'){
       	    $this->dash->delete_file($tbl, array('dashgraf_id' => $id));
			$this->dash->delete($tbl, array('dashgraf_id' => $id));
			
       }



       echo json_encode(array("status" => TRUE));
    }
    

	public function ajax_saveDash()
	{
	      $data = array('dashtab_name'       =>  $this->input->post('dashtab_name'),
	                    'thead'              =>  $this->input->post('thead'),
	                    'thead_key'          =>  $this->input->post('thead_key'),
	                    'query'              =>  $this->input->post('myquery_save'),
	                    'kode_surveyor'      =>  $this->session->userdata('kode_surveyor'),
	                  );

	     $this->dash->save('dash_table_save', $data);
	     echo json_encode(array("status" => TRUE));
    }

    public function ajax_saveDashGrafik()
	{
		$katagori = $this->create_file($this->input->post('label_grafik'));
		//$series = $this->create_file($this->input->post('isi_grafik'));

	     $data = array('dashgraf_name'       =>  $this->input->post('dashgraf_name'),
	                    'data_katagori'      =>  $katagori,
	                    'data_series'        =>  $this->input->post('isi_grafik'), //$series,
	                    'title_grafik'       =>  $this->input->post('title_grafik'),
	                    'title_isi'			 =>  $this->input->post('title_isi'),
	                    'query'			     =>  $this->input->post('query_grafik'),
	                    'type'               =>  $this->input->post('type_grafik'),
	                    'kode_surveyor'      =>  $this->session->userdata('kode_surveyor'),
	                  );

	     $this->dash->save('dash_grafik_save', $data);
	     echo json_encode(array("status" => TRUE));
    }

	  public function ajax_saveFavorite()
	  {
	     $data = array('fav_name'        =>  $this->input->post('fav_name'),
	                    'kode_surveyor'  =>  $this->session->userdata('kode_surveyor'),
	                    'halaman'        =>  $this->input->post('fav_halaman'),
	                    'is_shared'      =>  $this->input->post('fav_shared'),
	                  );

	     if($this->input->post('fav_filter'))
	        $data['filter_value']   = implode(",", $this->input->post('fav_filter'));

	     if($this->input->post('fav_group'))
	        $data['group_value']   = implode(",", $this->input->post('fav_group'));

	     $this->dash->save('dash_filter_favorite', $data);
	     echo json_encode(array("status" => TRUE));
	  }

	  public function delete_favorite($id)
	  {
	    
	    $this->dash->delete(array('fav_id' => $id), 'dash_filter_favorite');
	    echo json_encode(array("status" => TRUE));

	  }

	  public function get_favorite($id)
	  {

	     $data = $this->dash->data_favorite(array('fav_id' => $id), 'dash_filter_favorite');

	     echo json_encode($data->row());

	  }

	  public function getExcel_format($id)
	  {
		$this->db->where('halaman', $id);
		$data = $this->db->get('dash_format_excel');

		echo json_encode($data->row() );
	  }

	  public function upload_excel()
	  {

	        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	     
	        if(isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) 
	        {
	         
	            $arr_file = explode('.', $_FILES['file_excel']['name']);
	            $extension = end($arr_file);
	         
	            if('csv' == $extension) {
	                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
	            } else {
	                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	            }
	         
	            $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
	             
	            $sheetData = $spreadsheet->getActiveSheet()->toArray();

	            $field = explode(",", $this->input->post('table_field'));

	            for($i = 1;$i < count($sheetData);$i++)
	            {
	            	$data = array();
	            	$col = 0;
	            	foreach ($field as $row) 
	            	{

	            		$data[$row] = $sheetData[$i][$col];

	            		$col++;
	            	}

	            	/*
	                $data = array(
	                'kode_kota'     => $sheetData[$i]['0'],
	                'tahun'         => $sheetData[$i]['1'],
	                'jum_penduduk'  => $sheetData[$i]['2'],
	                'jum_konsumsi'  => $sheetData[$i]['3'],
	                'kebutuhan'     => $sheetData[$i]['4'],
	                );*/

	               $this->db->insert($this->input->post('table_name'), $data);

	            }
	            echo json_encode(array("status" => TRUE));
	        }
	    
	  }

	public function create_file($isi)
	{
		$this->load->helper('file');
		$filename = round(microtime(true) * 1000);
	    if ( ! write_file('./assets/data_graph/'.$filename.'.txt', $isi))
  			return FALSE;
	    else
			return $filename.'.txt';
	}

	public function download_all()
	{
		$this->load->library('pdf');
		$data['tabel'] = $this->db->get('dash_table_save');
		//$data['grafik'] = $this->db->get('dash_grafik_save');
		
		//$this->pdf->setBasePath('./assets_pdf/');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "[Tabel] Laporan Dashboard Fishinfo.pdf";
        $this->pdf->load_view('pdf/laporan_dashboard', $data);
        //$this->load->view('pdf/laporan_dashboard', $data);
	}

	public function get_DataMaps($id)
	{
		//$post = array('dt_lat' => $lat, 'dt_lng' => $lng );
		//$post = array('dt_lat' => '-7.136232185451579', 'dt_lng' => '111.8682861328125 ');
		$data = $this->dash->Maps($id);

		echo json_encode($data->result());
		//echo date('Y-m-d', strtotime('-6 day', strtotime(date('Y-m-d')) ));

	}

	public function delete_check()
	{
		  if($this->input->post('tbl'))
		  {
			   $id = $this->input->post('checkbox_value');

			   for($count = 0; $count < count($id); $count++)
			   {
			    // $this->dash->delete($id[$count]);
			     $this->dash->delete($this->input->post('tbl'), array($this->input->post('id_row') => $id[$count] ));
			   }
		  }
		   echo json_encode(array("status" => TRUE));

	}



}
