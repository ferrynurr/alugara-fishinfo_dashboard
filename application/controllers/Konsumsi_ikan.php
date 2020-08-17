<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsumsi_ikan extends CI_Controller {

  function __construct() 
  {
    parent::__construct();    
    if($this->session->userdata('is_logged_in') == false )
      redirect('auth');

    $this->load->model('M_konsumsi_ikan', 'konsumsiiwak');  
    $this->load->model('M_field_list', 'field_list'); 
          
  }

  public function index()
  {
      $data = array('title'           => 'Konsumsi Ikan',           
                    'data_kota'       => $this->db->order_by('nama_kota', 'asc')->get('kota'),
                    'halaman'         => 'konsumsi_ikan'
              );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
         $data['selected_group'] = array();



      $data['data_list']  = $this->konsumsiiwak->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->konsumsiiwak->dataPivot($filterNew); //pivot
      //$data['tbodyArray'] = $this->omset->dataSavedashboard($filterNew);
      $data['myQuery']    = $this->konsumsiiwak->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('dash_konsumsi_ikan', 0);
      $data['group_field'] = $this->field_list->dataTables('dash_konsumsi_ikan', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_konsumsi_ikan', $data);

   }

  public function ajax_add()
  {

      $data = array('kode_kota'          =>  $this->input->post('kode_kota'),
                    'tahun'              =>  $this->input->post('tahun'),
                    'jum_penduduk'       =>  $this->input->post('jum_penduduk'),
                    'tkia_konsumsi'      =>  $this->input->post('tkia_konsumsi'),
                    'b_konsumsi'         =>  $this->input->post('b_konsumsi'),  
                    'c_konsumsi'         =>  $this->input->post('c_konsumsi'),
                    'tot_konsumsi'       =>  $this->input->post('tot_konsumsi'),
                    'kebutuhan'          =>  $this->input->post('kebutuhan'),
                  );
      
         $this->konsumsiiwak->save('dash_konsumsi_ikan', $data);
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {    
      $data = array('kode_kota'          =>  $this->input->post('kode_kota'),
                    'tahun'              =>  $this->input->post('tahun'),
                    'jum_penduduk'       =>  $this->input->post('jum_penduduk'),
                    'tkia_konsumsi'      =>  $this->input->post('tkia_konsumsi'),
                    'b_konsumsi'         =>  $this->input->post('b_konsumsi'),  
                    'c_konsumsi'         =>  $this->input->post('c_konsumsi'),
                    'tot_konsumsi'       =>  $this->input->post('tot_konsumsi'),
                    'kebutuhan'          =>  $this->input->post('kebutuhan'),
                  );

         $this->konsumsiiwak->update('dash_konsumsi_ikan', $data, array('konsumsi_id' => $this->input->post('konsumsi_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->konsumsiiwak->delete('dash_konsumsi_ikan', array('konsumsi_id' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->konsumsiiwak->get_byID(array('a.konsumsi_id' => $id));
       echo json_encode($query->row());
  }


  public function ajax_pivot_get()
  {
    // echo json_encode($res);
      $filterNew = array(
                        'filter_all'  => $this->input->post('filter_all'), 
                        'pengukuran'  => $this->input->post('pengukuran'),
                        'operator'    => $this->input->post('operator'),
                        'baris'       => $this->input->post('baris'),
                      );
                        

    $query = $this->konsumsiiwak->dataPivot($filterNew);

   echo json_encode($query->result());
  // echo json_encode(array("status" => $filterNew));
  }

  



}
