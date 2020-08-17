<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_konsumsi_ikan extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    private function query()
    {
      $this->db->select('a.*, b.nama_kota');
      $this->db->from('dash_konsumsi_ikan as a');
      $this->db->join('kota as b', 'b.kode_kota = a.kode_kota','left'); 
      $this->db->order_by('nama_kota', 'asc');

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

    public function get_dataExport($kota, $thn)
    {
       $this->query(); 
       if($kota)
       {
          if($kota != 'all')
          {
            $this->db->where('a.kode_kota', $kota);
          }
       }

       if($thn)
       {
          $this->db->where('a.tahun', $thn);
       }

       $data = $this->db->get();

       return $data;
    }




}
