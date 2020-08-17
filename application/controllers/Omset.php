<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Omset extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');

		$this->load->model('M_omset', 'omset');	
    $this->load->model('M_field_list', 'field_list'); 
					
	}

	public function index()
	{
	    $data = array('title'	          => 'Omzet Kegiatan Perikanan',
                   
                    'data_provinsi'   => $this->db->order_by('nama_provinsi', 'asc')->get('provinsi'),
                    'data_kota'       => $this->db->order_by('nama_kota', 'asc')->get('kota'),
                    'halaman'         => 'omset'
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



      $data['data_list']  = $this->omset->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->omset->dataPivot($filterNew); //pivot
      //$data['tbodyArray'] = $this->omset->dataSavedashboard($filterNew);
      $data['myQuery']    = $this->omset->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('dash_omset', 0);
      $data['group_field'] = $this->field_list->dataTables('dash_omset', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_omset', $data);

   }

  public function ajax_add()
  {

      $data = array('trader_id'      =>  $this->input->post('trader_id'),
                    'kegiatan'       =>  $this->input->post('kegiatan'),
                    'tgl_mulai'      =>  $this->input->post('tgl_mulai'),
                    'tgl_selesai'    =>  $this->input->post('tgl_selesai'),
                    'kode_kota'      =>  $this->input->post('kode_kota'),  
                    'kode_provinsi'  =>  $this->input->post('kode_provinsi'),
                    'jenis'          =>  $this->input->post('jenis'),
                    'omset'          =>  $this->input->post('omset'),
                  );
      
         $this->omset->save('dash_omset', $data);
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {    
      $data = array('trader_id'      =>  $this->input->post('trader_id'),
                    'kegiatan'       =>  $this->input->post('kegiatan'),
                    'tgl_mulai'      =>  $this->input->post('tgl_mulai'),
                    'tgl_selesai'    =>  $this->input->post('tgl_selesai'),
                    'kode_kota'      =>  $this->input->post('kode_kota'),  
                    'kode_provinsi'  =>  $this->input->post('kode_provinsi'),
                    'jenis'          =>  $this->input->post('jenis'),
                    'omset'          =>  $this->input->post('omset'),
                  );

         $this->omset->update('dash_omset', $data, array('omset_id' => $this->input->post('omset_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->omset->delete('dash_omset', array('omset_id' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->omset->get_byID(array('a.omset_id' => $id));
       echo json_encode($query->row());
  }


    public function ajax_pivot_get()
    {
      // echo json_encode($res);
        $filterNew = array( 'filter_all'  => $this->input->post('filter_all'), 
                          'pengukuran'  => $this->input->post('pengukuran'),
                          'operator'  => $this->input->post('operator'),
                          'baris'  => $this->input->post('baris'),
                          'jenis'       => 0,);

      $query = $this->omset->dataPivot($filterNew);

     echo json_encode($query->result());
    // echo json_encode(array("status" => $filterNew));
    }

  



}
