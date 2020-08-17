<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function update($tbl, $where, $data)
    {
        $this->db->set( $data);
        $this->db->where($where);
        $this->db->update($tbl);

        return $this->db->affected_rows();

    }

    public function delete($tb, $data)
    {
        $this->db->where($data);
        $this->db->delete($tb);
    }

    public function delete_file($tbl, $data)
    {
        $this->db->where($data);
        $data = $this->db->get($tbl)->row();

        if($data->data_katagori != '')
             unlink('./assets/data_graph/'.$data->data_katagori);

        //if($data->data_series != '')
         //   unlink('./assets/data_graph/'.$data->data_series);

    }

    

    public function save($tbl, $data) 
    {
        $this->db->insert($tbl, $data);
 
    }

    public function data_favorite($data, $tbl)
    {    

        $this->db->where($data);
        $data = $this->db->get($tbl);

        return $data;
    }

    /*
    public function get_maps($id)
    {
         $tgl_minus = date('Y-m-d', strtotime('-8 day', strtotime(date('Y-m-d')) ));

         $this->db->select('a.*, SUM(b.volume) AS tot_volume, AVG(b.harga) AS avg_harga');
         $this->db->from('dash_maps as a');
         $this->db->join('survey_harga_konsumsi as b', 'b.kode_kota = a.kode_kota','left'); 

         if($id != '0')
         {
            $this->db->select('c.nama_ikan');
            $this->db->join('ikan as c', 'c.kode_ikan = b.kode_ikan','left'); 

            $this->db->where('a.kode_kota',  $id);
           // $this->db->where('a.long', $lng);

            $this->db->group_by(array('a.kode_kota', 'c.nama_ikan'));
         }else{
            $this->db->group_by('a.kode_kota');
         }

         
         $this->db->where('b.tanggal >=',  $tgl_minus);
         $this->db->where('b.tanggal <=',  date('Y-m-d'));
         $data = $this->db->get();

        return $data;
   
    }*/

    public function Maps($id)
    {
        $jenis = $this->input->get('maps_data');
         $tgl_minus = date('Y-m-d', strtotime('-8 day', strtotime(date('Y-m-d')) ));

         $this->db->select('a.kode_kota, b.nama_ikan, SUM(a.volume) AS tot_volume, AVG(a.harga) AS avg_harga');
         $this->db->from('survey_harga_konsumsi as a');
         $this->db->join('ikan as b', 'b.kode_ikan = a.kode_ikan','left');
         
         if($jenis){
          
            if($jenis == 'Eceran')
                $this->db->where('a.jenis', 0);              
            elseif($jenis == 'Grosir')
                $this->db->where('a.jenis', 1);
            
         }

         $this->db->where('a.tanggal >=',  $tgl_minus);
         $this->db->where('a.tanggal <=',  date('Y-m-d'));

         if($id == 0)
             $this->db->group_by('a.kode_kota');
         else{
            $this->db->where('a.kode_kota',  $id);
            $this->db->group_by('a.kode_kota, a.kode_ikan');
         }

         $data = $this->db->get();

        return $data;
    }


}
