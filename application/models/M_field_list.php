<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_field_list extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function query()
    {
      $this->db->select('*');
      $this->db->from('dash_field_list');
    }

    public function dataTables($tbl, $group)
    {
  
      $this->query(); 
      if($tbl)
        $this->db->where('table', $tbl);

      //if($group != null)
         $this->db->where('is_group', $group);
      
      $data = $this->db->get();

      return $data;
    }

}
