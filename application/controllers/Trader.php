<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

date_default_timezone_set("Asia/Jakarta");

class Trader extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');

		$this->load->model('M_trader', 'trader');	
					
	}

  public function index()
  {
     
     $data = array('title'       => 'Trader',
                   'data_kota'   => $this->db->order_by('nama_kota', 'asc')->get('kota'),
                   'data'        => $this->trader->get_datatables(),
                   'halaman'     => 'trader'
    );


     $this->load->view('v_trader', $data);

  }

  public function ajax_add()
  {

      $data = array('nama_trader'           =>  $this->input->post('nama_trader'),
                    'alamat_trader'         =>  $this->input->post('alamat_trader'),
                    'kode_kota'             =>  $this->input->post('kode_kota'),
                    'telp_trader'           =>  $this->input->post('telp_trader'),
                    'email_trader'          =>  $this->input->post('email_trader'),
                    'pemilik_trader'        =>  $this->input->post('pemilik_trader'),

                  );
      

         $this->trader->save('dash_trader', $data);
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {

      $data = array('nama_trader'           =>  $this->input->post('nama_trader'),
                    'alamat_trader'         =>  $this->input->post('alamat_trader'),
                    'kode_kota'             =>  $this->input->post('kode_kota'),
                    'telp_trader'           =>  $this->input->post('telp_trader'),
                    'email_trader'          =>  $this->input->post('email_trader'),
                    'pemilik_trader'        =>  $this->input->post('pemilik_trader'),

                  );
      

         $this->trader->update('dash_trader', $data, array('trader_id' => $this->input->post('trader_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->trader->delete('dash_trader', array('trader_id' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->trader->get_byID(array('a.trader_id' => $id));
       echo json_encode($query->row());
  }

  public function export()
  {

    $title = 'LAPORAN DATA TRADER';
    $data = $this->trader->get_datatables();
    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator('FISHINFO DASHBOARD')
    ->setTitle($title);
    $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

    foreach(range('A','G') as $columnID) {
          $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Add some data
    $spreadsheet->setActiveSheetIndex(0)
     ->setCellValue('A1', 'NO')
     ->setCellValue('B1', 'TRADER (KODE)')
     ->setCellValue('C1', 'ALAMAT')
     ->setCellValue('D1', 'KOTA')
     ->setCellValue('E1', 'TELEPON/HP')
     ->setCellValue('F1', 'E-MAIL')
     ->setCellValue('G1', 'PEMILIK')
    ;

    // Miscellaneous glyphs, UTF-8
    $i=2; 
    $no=1;

    foreach($data->result() as $row) 
    {

      $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, $no)
      ->setCellValue('B'.$i, $row->nama_trader.' ('.$row->trader_id.')')
      ->setCellValue('C'.$i, $row->alamat_trader)
      ->setCellValue('D'.$i, $row->nama_kota)
      ->setCellValue('E'.$i, $row->telp_trader)
      ->setCellValue('F'.$i, $row->email_trader) 
      ->setCellValue('G'.$i, $row->pemilik_trader);

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
