<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_komoditas_kelompok extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function query()
    {
      $this->db->select('*');
      $this->db->from('dash_komoditas_kelompok');
     
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
