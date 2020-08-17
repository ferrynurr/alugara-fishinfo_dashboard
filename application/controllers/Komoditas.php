<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas extends CI_Controller {

  function __construct() 
  {
    parent::__construct();    
    if($this->session->userdata('is_logged_in') == false )
      redirect('auth');

    $this->load->model('M_komoditas', 'komo');  
          
  }

  public function index()
  {
     
     $data = array('title'                => 'Master Komoditas',
                   'data_komoditas_kel'   => $this->db->order_by('nama_komoditas_kel', 'asc')->get('dash_komoditas_kelompok'),
                   'data_satuan'          => $this->db->order_by('class_satuan', 'asc')->get('dash_satuan'),
                   'data'                 => $this->komo->get_datatables(),
                   'halaman'              => 'komoditas'
    );


     $this->load->view('v_komoditas', $data);

  }

  public function ajax_add()
  {

      $data = array('jenis_komoditas'           =>  $this->input->post('jenis_komoditas'),
                    'komoditas_kel_id'          =>  $this->input->post('komoditas_kel_id'),
                    //'satuan_id'                    =>  $this->input->post('satuan'),
                  );
      

         $this->komo->save('dash_komoditas', $data);
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {

       $data = array('jenis_komoditas'           =>  $this->input->post('jenis_komoditas'),
                     'komoditas_kel_id'          =>  $this->input->post('komoditas_kel_id'),
                     //'satuan_id'                    =>  $this->input->post('satuan'),
                  );
      

         $this->komo->update('dash_komoditas', $data, array('komoditas_id' => $this->input->post('komoditas_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->komo->delete('dash_komoditas', array('komoditas_id' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->komo->get_byID(array('a.komoditas_id' => $id));
       echo json_encode($query->row());
  }

}
