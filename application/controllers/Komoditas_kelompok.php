<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas_kelompok extends CI_Controller {

  function __construct() 
  {
    parent::__construct();    
    if($this->session->userdata('is_logged_in') == false )
      redirect('auth');

    $this->load->model('M_komoditas_kelompok', 'komo'); 
          
  }

  public function index()
  {
     
     $data = array('title'                => 'Master Komoditas Kelompok',
                   'data'                 => $this->komo->get_datatables(),
                   'halaman'              => 'komoditas_kelompok'
    );


     $this->load->view('v_komoditas_kelompok', $data);

  }

  public function ajax_add()
  {

      $data = array('nama_komoditas_kel'     =>  $this->input->post('nama_komoditas_kel'), 
                    'jenis_tabel'     =>  $this->input->post('jenis_tabel'),
                  );
      

         $this->komo->save('dash_komoditas_kelompok', $data);
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {

       $data = array('nama_komoditas_kel'     =>  $this->input->post('nama_komoditas_kel'),
                     'jenis_tabel'     =>  $this->input->post('jenis_tabel'),
                  );
      

         $this->komo->update('dash_komoditas_kelompok', $data, array('komoditas_kel_id' => $this->input->post('komoditas_kel_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->komo->delete('dash_komoditas_kelompok', array('komoditas_kel_id' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->komo->get_byID(array('komoditas_kel_id' => $id));
       echo json_encode($query->row());
  }

}
