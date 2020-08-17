<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Harga_konsumsi extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');

		$this->load->model('M_harga_konsumsi', 'konsumsi');
		$this->load->model('M_field_list', 'field_list');						
	}


	public function tb_list_eceran()
	{

	    $data = array('title'	          => 'Harga & Ketersediaan Ikan Eceran',
                    'pages'           => 'ketersediaan',
                    'jenis'           => 'tb_list_eceran',
                    'data_ikan'       => $this->db->order_by('nama_ikan', 'asc')->get('ikan'),
                    'data_kota'       => $this->db->order_by('nama_kota', 'asc')->get('kota'),
                    'halaman'         => 'harga_konsumsi_eceran'
              );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                          'jenis'           => 0,
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
         $data['selected_group'] = array();



      $data['data_list']  = $this->konsumsi->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->konsumsi->dataPivot($filterNew); //pivot
      //$data['tbodyArray'] = $this->konsumsi->dataSavedashboard($filterNew);
      $data['myQuery']    = $this->konsumsi->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('survey_harga_konsumsi', 0);
      $data['group_field'] = $this->field_list->dataTables('survey_harga_konsumsi', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_harga_konsumsi', $data);
   }

  public function tb_list_grosir()
  {

      $data = array('title'           => 'Harga & Ketersediaan Ikan Grosir',
                    'pages'           => 'ketersediaan',
                    'jenis'           => 'tb_list_grosir',
                    'data_ikan'       => $this->db->order_by('nama_ikan', 'asc')->get('ikan'),
                    'data_kota'       => $this->db->order_by('nama_kota', 'asc')->get('kota'),
                    'halaman'         => 'harga_konsumsi_grosir'
              );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                          'jenis'           => 1,
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
         $data['selected_group'] = array();



      $data['data_list']  = $this->konsumsi->dataTablesNew($filterNew); //tabel
     // $data['data_pivot'] = $this->konsumsi->dataPivot($filterNew); //pivot
      //$data['tbodyArray'] = $this->konsumsi->dataSavedashboard($filterNew);
      $data['myQuery']    = $this->konsumsi->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('survey_harga_konsumsi', 0);
      $data['group_field'] = $this->field_list->dataTables('survey_harga_konsumsi', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_harga_konsumsi', $data);
  }

/*
  public function ajax_saveDash()
  {
      $data = array('dashtab_name'       =>  $this->input->post('dashtab_name'),
                    'thead'              =>  $this->input->post('thead'),
                    'thead_key'          =>  $this->input->post('thead_key'),
                    //'tbody'              =>  $this->input->post('tbody'),
                    'query'              =>  $this->input->post('myquery_save'),
                    'kode_surveyor'      =>  $this->session->userdata('kode_surveyor'),
                  );

     $this->konsumsi->save('dash_table_save', $data);
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

     $this->konsumsi->save('dash_filter_favorite', $data);
     echo json_encode(array("status" => TRUE));
  }

  public function delete_favorite($id)
  {
    
    $this->konsumsi->delete(array('fav_id' => $id), 'dash_filter_favorite');
    echo json_encode(array("status" => TRUE));

  }

  public function get_favorite($id)
  {

     $data = $this->konsumsi->data_favorite(array('fav_id' => $id), 'dash_filter_favorite');

     echo json_encode($data->row());

  }
  */
    public function ajax_pivot_get()
    {
      // echo json_encode($res);
        $filterNew = array( 'filter_all'  => $this->input->post('filter_all'), 
                          'pengukuran'  => $this->input->post('pengukuran'),
                          'operator'  => $this->input->post('operator'),
                          'baris'  => $this->input->post('baris'),
                          'jenis'       => 0,);

      $query = $this->konsumsi->dataPivot($filterNew);

     echo json_encode($query->result());
    // echo json_encode(array("status" => $filterNew));
    }


  public function ajax_delete($id)
  {
    
    $this->konsumsi->delete(array('kode_survey_pasar' => $id), 'survey_harga_konsumsi');
    echo json_encode(array("status" => TRUE));

  }

  public function ajax_update()
  {    

      $data = array('tanggal'     =>  $this->input->post('tanggal'),
                    'kode_kota'   =>  $this->input->post('kode_kota'),
                    'id_pasar'    =>  $this->input->post('id_pasar'),
                    'kode_ikan'   =>  $this->input->post('kode_ikan'),
                    'volume'      =>  $this->input->post('volume'),
                    'harga'       =>  $this->input->post('harga'),             
                  );

         $this->konsumsi->update('survey_harga_konsumsi', array('kode_survey_pasar' => $this->input->post('kode_survey_pasar')), $data );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->konsumsi->get_byID(array('a.kode_survey_pasar' => $id));
       echo json_encode($query->row());
  }

  public function get_pasar($id)
  {
      $this->db->where('kode_kota', $id);
      $query = $this->db->get('data_pasar');
      echo json_encode($query->result() );
  }






}
