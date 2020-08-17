<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_komoditas extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function query()
    {
      $this->db->select('a.*, b.nama_komoditas_kel, c.*');
      $this->db->from('dash_komoditas as a');
      $this->db->join('dash_komoditas_kelompok as b', 'b.komoditas_kel_id = a.komoditas_kel_id','left'); 
      $this->db->join('dash_satuan as c', 'c.satuan_id = a.satuan_id','left'); 

    }

    public function get_datatables()
    {
  
      $this->query(); 
      $data = $this->db->get();

      return $data;
    }

    public function save($tbl, $data) 
    {
        $this->db->insert($tbl, $data);
 
    }

    public function update($tbl, $data, $where)
    {
        $this->db->set($data);
        $this->db->where($where);
        $this->db->update($tbl);

        return $this->db->affected_rows();

    }

    public function delete($tb, $data)
    {
        $this->db->where($data);
        $this->db->delete($tb);
    }

    public function get_byID($data)
    {
      $this->query(); 
      $this->db->where($data);
      $data = $this->db->get();

      return $data;
    }




}
