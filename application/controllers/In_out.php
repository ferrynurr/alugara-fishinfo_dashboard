<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class In_out extends CI_Controller {

	function __construct() 
	{
		parent::__construct();		
		if($this->session->userdata('is_logged_in') == false )
			redirect('auth');

		$this->load->model('M_in_out', 'model');	
    $this->load->model('M_field_list', 'field_list'); 
					
	}

	public function dom_masuk()
	{

      $data = array('title'             => 'Domestik Masuk', 
                    'satuan_nilai'      => 'Rupiah ( Rp )',
                    'data_kom_kelompok' => $this->db->order_by('nama_komoditas_kel', 'asc')->where('jenis_tabel', 'dom_masuk')->get('dash_komoditas_kelompok'),
                    'data_satuan'       => $this->db->order_by('class_satuan', 'asc')->get('dash_satuan'),
                    'jenis'             => 'dom_masuk',
                    'halaman'           => 'dom_masuk',
                    );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                          'uri'             => 'dom_masuk'
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
          $data['selected_group'] = array();



      $data['data_list']  = $this->model->dataTablesNew($filterNew); //tabel
     // $data['data_pivot'] = $this->model->dataPivot($filterNew); //pivot
      $data['myQuery']    = $this->model->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('dash_dom_masuk', 0);
      $data['group_field'] = $this->field_list->dataTables('dash_dom_masuk', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_in_out', $data);

   }

  public function dom_keluar()
  {

      $data = array('title'             => 'Domestik Keluar',
                    'satuan_nilai'      => 'Rupiah ( Rp )',
                    'data_kom_kelompok' => $this->db->order_by('nama_komoditas_kel', 'asc')->where('jenis_tabel', 'dom_keluar')->get('dash_komoditas_kelompok'),
                    'data_satuan'       => $this->db->order_by('class_satuan', 'asc')->get('dash_satuan'),
                    'jenis'             => 'dom_keluar',
                    'halaman'           => 'dom_keluar',
                    );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                          'uri'             => 'dom_keluar'
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
         $data['selected_group'] = array();



      $data['data_list']  = $this->model->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->model->dataPivot($filterNew); //pivot
      $data['myQuery']    = $this->model->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('dash_dom_keluar', 0);
      $data['group_field'] = $this->field_list->dataTables('dash_dom_keluar', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_in_out', $data);

   }

  public function ekspor()
  {

      $data = array('title'             => 'Ekspor',
                    'satuan_nilai'      => 'USD ( $ )',
                    'data_kom_kelompok' => $this->db->order_by('nama_komoditas_kel', 'asc')->where('jenis_tabel', 'ekspor')->get('dash_komoditas_kelompok'),
                    'data_satuan'       => $this->db->order_by('class_satuan', 'asc')->get('dash_satuan'),
                    'jenis'             => 'ekspor',
                    'halaman'           => 'ekspor',
                    );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                          'uri'             => 'ekspor'
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
         $data['selected_group'] = array();



      $data['data_list']  = $this->model->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->model->dataPivot($filterNew); //pivot
      $data['myQuery']    = $this->model->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('dash_ekspor', 0);
      $data['group_field'] = $this->field_list->dataTables('dash_ekspor', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_in_out', $data);

   }

  public function impor()
  {

      $data = array('title'             => 'Impor',
                    'satuan_nilai'      => 'USD ( $ )',
                    'data_kom_kelompok' => $this->db->order_by('nama_komoditas_kel', 'asc')->where('jenis_tabel', 'impor')->get('dash_komoditas_kelompok'),
                    'data_satuan'       => $this->db->order_by('class_satuan', 'asc')->get('dash_satuan'),
                    'jenis'             => 'impor',
                    'halaman'           => 'impor',
                    );

      $filterNew = array( 'filter_all'      => $this->input->post('filter_all'), 
                          'selected_group'  => $this->input->post('selected_group'),
                          'uri'             => 'impor'
                    );

      if($this->input->post('filter_all'))
         $data['filter_all'] = $this->input->post('filter_all');
      else
         $data['filter_all'] = '';


      if($this->input->post('selected_group'))
         $data['selected_group'] = $this->input->post('selected_group');
      else
          $data['selected_group'] = array();



      $data['data_list']  = $this->model->dataTablesNew($filterNew); //tabel
      //$data['data_pivot'] = $this->model->dataPivot($filterNew); //pivot
      $data['myQuery']    = $this->model->simpanDash($filterNew);

      $data['list_field'] = $this->field_list->dataTables('dash_impor', 0);
      $data['group_field'] = $this->field_list->dataTables('dash_impor', 1);

      $data['favorite_filter'] = $this->db->where('kode_surveyor', $this->session->userdata('kode_surveyor'))->where('halaman', $data['halaman'])->where('(is_shared=0 OR is_shared=1)')->get('dash_filter_favorite');


      $this->load->view('v_in_out', $data);

  }


  public function page_handler($uri)
  {
    
     $primary = '';
     $astuj = '';
     $tbl = '';

      if( $uri == 'dom_masuk')
      {
           $astuj   = 'asal'; 
           $primary = 'dom_masuk_id';
           $tbl     = 'dash_dom_masuk';
      }
      elseif( $uri == 'dom_keluar')
      {
           $astuj   = 'tujuan'; 
           $primary = 'dom_keluar_id';
           $tbl     = 'dash_dom_keluar';
      }
      elseif( $uri == 'impor' )
      {
           $astuj   = 'asal';
           $primary = 'impor_id';
           $tbl     = 'dash_impor';
      }
      elseif( $uri == 'ekspor')
      {
           $astuj   = 'tujuan'; 
           $primary = 'ekspor_id';
           $tbl     = 'dash_ekspor';
      }

      $data = array('uri' => $uri, 'prim_id' =>  $primary, 'astuj' => $astuj, 'tbl' => $tbl);

      return $data;
  }



  public function ajax_add($uri)
  {


      $data = array('trader_name'      =>  $this->input->post('trader_name'),
                    'tgl'              =>  $this->input->post('tgl'),
                    'komoditas_id'     =>  $this->input->post('komoditas_id'),
                    'satuan_awal'      =>  $this->input->post('satuan_awal'),
                    'jumlah_awal'      =>  $this->input->post('jumlah_awal'),
                    'nilai'            =>  $this->input->post('nilai'),               
                  );

      $uri_data = $this->page_handler($uri);

      if($uri_data)
      {
         $i = $uri_data['astuj'];
         $data[$i] = $this->input->post('astuj_name'); 
      }
      
      $this->model->save($uri_data['tbl'], $data);
      echo json_encode(array("status" => TRUE));
  }

  public function ajax_update($uri)
  {    
     
      $data = array('trader_name'      =>  $this->input->post('trader_name'),
                    'tgl'              =>  $this->input->post('tgl'),
                    'komoditas_id'     =>  $this->input->post('komoditas_id'),
                    'satuan_awal'      =>  $this->input->post('satuan_awal'),
                    'jumlah_awal'      =>  $this->input->post('jumlah_awal'),
                    'nilai'            =>  $this->input->post('nilai'),
                  );

       $uri_data = $this->page_handler($uri);

        if($uri_data)
        {
           $i = $uri_data['astuj'];
           $data[$i] = $this->input->post('astuj_name'); 
        }

         $this->model->update($uri_data['tbl'], $data, array($uri_data['prim_id'] => $this->input->post('in_out_id')) );
         echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id, $uri)
  {
       $uri_data = $this->page_handler($uri);

       $this->model->delete($uri_data['tbl'], array($uri_data['prim_id'] => $id));
       echo json_encode(array("status" => TRUE));
  }

  public function ajax_get($id, $uri)
  {
       $uri_data = $this->page_handler($uri);

       $query = $this->model->get_byID($uri, array($uri_data['prim_id'] => $id));
       echo json_encode($query->row());
  }

 public function get_komoditas($id)
 {
       $this->db->where('komoditas_kel_id', $id);
       $query = $this->db->get('dash_komoditas');
       echo json_encode($query->result());
 }
 
 public function ajax_pivot_get($uri)
    {
      // echo json_encode($res);
        $filterNew = array( 'filter_all'  => $this->input->post('filter_all'), 
                          'pengukuran'  => $this->input->post('pengukuran'),
                          'operator'  => $this->input->post('operator'),
                          'baris'  => $this->input->post('baris'),
                          'jenis'       => 0,
                          'uri'        => $uri
                        );

      $query = $this->model->dataPivot($filterNew);

     echo json_encode($query->result());
    // echo json_encode(array("status" => $filterNew));
    }
  



}
