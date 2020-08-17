<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Konsumsi_ikan extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');

		$this->load->model('M_konsumsi_ikan', 'konsumsi');	
					
	}

	public function index()
	{
	    $data = array('title'	         => 'Konsumsi Ikan',
                    'data_kota'      => $this->db->order_by('nama_kota')->get('kota'),
                    );
    
      $data['data_list'] = $this->konsumsi->get_datatables();


      $this->load->view('v_konsumsi_ikan', $data);
   }

  public function ajax_add()
  {

      $data = array('kode_kota'        =>  $this->input->post('kode_kota'),
                    'tahun'            =>  $this->input->post('tahun'),
                    'jum_penduduk'     =>  $this->input->post('jum_penduduk'),
                    'jum_konsumsi'     =>  $this->input->post('jum_konsumsi'),
                    'kebutuhan'        =>  $this->input->post('kebutuhan'),
                  );
      

         $this->konsumsi->save('dash_konsumsi_ikan', $data);
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {

        $data = array('kode_kota'        =>  $this->input->post('kode_kota'),
                      'tahun'            =>  $this->input->post('tahun'),
                      'jum_penduduk'     =>  $this->input->post('jum_penduduk'),
                      'jum_konsumsi'     =>  $this->input->post('jum_konsumsi'),
                      'kebutuhan'        =>  $this->input->post('kebutuhan'),
                    );
      

         $this->konsumsi->update('dash_konsumsi_ikan', $data, array('konsumsi_id' => $this->input->post('konsumsi_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->konsumsi->delete('dash_konsumsi_ikan', array('konsumsi_id' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->konsumsi->get_byID(array('a.konsumsi_id' => $id));
       echo json_encode($query->row());
  }

  public function export()
  {

    $title = 'LAPORAN DATA KONSUMSI IKAN';
    $data = $this->konsumsi->get_dataExport($this->input->post('kode_kota'), $this->input->post('tahun') );
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator('FISHINFO DASHBOARD')
    ->setTitle($title);
    $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

    foreach(range('A','F') as $columnID) {
          $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Add some data
    $spreadsheet->setActiveSheetIndex(0)
       ->setCellValue('A1', 'No')
       ->setCellValue('B1', 'Kab/Kota')
       ->setCellValue('C1', 'Tahun')
       ->setCellValue('D1', 'Jumlah penduduk')
       ->setCellValue('E1', 'konsumsi ikan (kg/kapita/tahun)')
       ->setCellValue('F1', 'Kebutuhan Ikan (Kg)')
    ;

    // Miscellaneous glyphs, UTF-8
    $i=2; 
    $no=1;

    foreach($data->result() as $row) 
    {

      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $no)
        ->setCellValue('B'.$i, $row->nama_kota)
        ->setCellValue('C'.$i, $row->tahun)
        ->setCellValue('D'.$i, $row->jum_penduduk)
        ->setCellValue('E'.$i, $row->jum_konsumsi)
        ->setCellValue('F'.$i, $row->kebutuhan) 
      ;

      $i++; 
      $no++;
    }


    $spreadsheet->getActiveSheet()->setTitle($title);
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.ms-excel'); // generate excel file
    header('Content-Disposition: attachment;filename="'. $title .'.xlsx"'); 
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = new Xlsx($spreadsheet); // instantiate Xlsx
    $writer->save('php://output');
    exit;
  }






}
