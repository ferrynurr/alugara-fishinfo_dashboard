<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Non_konsumsi extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');

		$this->load->model('M_non_konsumsi', 'nonkon');	
		$this->load->model('M_field_list', 'field_list'); 		
	}

	public function index()
	{
	    $data = array('title'	             => 'Non-Konsumsi',
                    'data_pengusaha'     => $this->db->order_by('nama_perusahaan', 'asc')->get('pengusaha'),
                    'tujuan_jatim'       => $this->db->order_by('nama_kota', 'asc')->get('kota'),
                    'tujuan_luar_jatim'  => $this->db->order_by('nama_provinsi', 'asc')->get('provinsi'),
                    'tujuan_luar_negeri' => $this->db->order_by('nama_negara', 'asc')->get('negara'),
                    'halaman'            => 'non_konsumsi'
                    
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



      $data['data_list']  = $this->nonkon->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->nonkon->dataPivot($filterNew); //pivot
      //$data['tbodyArray'] = $this->omset->dataSavedashboard($filterNew);
      $data['myQuery']    = $this->nonkon->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('survey_nonkonsumsi', 0);
      $data['group_field'] = $this->field_list->dataTables('survey_nonkonsumsi', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');

      $this->load->view('v_non_konsumsi', $data);
   }

  public function ajax_update()
  {    
      $data = array(
                    'tanggal'         =>  $this->input->post('tanggal'),
                    'kode_pengusaha'  =>  $this->input->post('kode_pengusaha'),
                    'harga'           =>  $this->input->post('harga'),
                    'harga_kg'        =>  $this->input->post('harga_kg'),
                    'harga_l'         =>  $this->input->post('harga_l'),
                    'omset'           =>  $this->input->post('omset'),        
                  );

      if($this->input->post('tujuan_jatim'))
          $data['tujuan_jatim'] = implode(",", $this->input->post('tujuan_jatim'));

      if($this->input->post('tujuan_luar_jatim'))
          $data['tujuan_luar_jatim'] = implode(",", $this->input->post('tujuan_luar_jatim'));

      if($this->input->post('tujuan_luar_negeri'))
          $data['tujuan_luar_negeri'] = implode(",", $this->input->post('tujuan_luar_negeri'));

         $this->nonkon->update('survey_nonkonsumsi', array('kode_survey_nonkonsumsi' => $this->input->post('kode_survey_nonkonsumsi')), $data );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
       $this->nonkon->delete('survey_nonkonsumsi', array('kode_survey_nonkonsumsi' => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id)
  {
       $query = $this->nonkon->get_byID(array('a.kode_survey_nonkonsumsi' => $id));
       echo json_encode($query->row());
  }

 public function get_komoditas($id)
 {
       $this->db->where('komoditas_kel_id', $id);
       $query = $this->db->get('dash_komoditas');
       echo json_encode($query->result());
 }

   public function ajax_pivot_get()
    {
      // echo json_encode($res);
        $filterNew = array( 'filter_all'  => $this->input->post('filter_all'), 
                          'pengukuran'  => $this->input->post('pengukuran'),
                          'operator'  => $this->input->post('operator'),
                          'baris'  => $this->input->post('baris'),
                          'jenis'       => 0,);

      $query = $this->nonkon->dataPivot($filterNew);

     echo json_encode($query->result());
    // echo json_encode(array("status" => $filterNew));
    }



}
