<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_konsumsi_ikan extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    private function query()
    {
      $this->db->select('a.konsumsi_id, a.kode_kota, a.tahun, a.jum_penduduk, a.tkia_konsumsi, a.b_konsumsi, a.c_konsumsi, b.nama_kota');
      $this->db->from('dash_konsumsi_ikan as a');
      $this->db->join('kota as b', 'b.kode_kota = a.kode_kota','left'); 

    }

    public function dataTablesNew($filter)
    {
        $this->query();


        if(isset($filter['filter_all']))
        {

          $datas = $filter['filter_all'];
          $dataarr = array();
          foreach ($datas as $dat) {
            $dataarr[] = explode("|", $dat)[0];
          }
          
          $i=0;
          $dataand='';
          foreach ($dataarr as $da) {
            if ($i==0)
              $dataand = "(".$da.")";
            else
              $dataand .= " AND (".$da.")";
            $i +=1;
          }

          
          $saring  = str_replace("~","%",$dataand);
          $saring2 = str_replace("^","<",$saring);

          $this->db->where($saring2);
        }


        #-- FILTER LANJUTAN -->
        if( isset($filter['selected_group']))
        {
           $this->db->select('SUM(a.tot_konsumsi) tot_konsumsi');
           $this->db->select('SUM(a.kebutuhan) kebutuhan');
           $this->db->group_by($filter['selected_group']);
          
        }
        else{         
          $this->db->select('a.tot_konsumsi, a.kebutuhan');
          $this->db->order_by('b.nama_kota');
        }


        $data = $this->db->get();
        return $data;
    }

    public function simpanDash($filter)
    {
      
       $selgrub = '';
       $order ='';
       $grubby ='';

       $wherefile_all = '';

        if(isset($filter['filter_all']))
        {

          $datas = $filter['filter_all'];
          $dataarr = array();
          foreach ($datas as $dat) {
            $dataarr[] = explode("|", $dat)[0];
          }
          
          $i=0;
          $dataand='';
          foreach ($dataarr as $da) {
            if ($i==0)
              $dataand = "(".$da.")";
            else
              $dataand .= " AND (".$da.")";
            $i +=1;
          }

          
          $saring  = str_replace("~","%",$dataand);
          $saring2 = str_replace("^","<",$saring);

          //$this->db->where($saring2);
          $wherefile_all = "AND ".$dataand;
        }


        #-- FILTER LANJUTAN -->
        if( isset($filter['selected_group']))
        {
            $selgrub = ",SUM(a.tot_konsumsi) tot_konsumsi, SUM(a.kebutuhan) kebutuhan";
            $grubby = "GROUP BY ".implode(",", $filter['selected_group']);      
        }
        else{         
          $selgrub = ",a.tot_konsumsi, a.kebutuhan";
          $order = "ORDER BY b.nama_kota ASC";
        }


        $query = "SELECT a.konsumsi_id, a.kode_kota, a.tahun, a.jum_penduduk, a.tot_konsumsi, a.kebutuhan, b.nama_kota ". $selgrub."  FROM dash_konsumsi_ikan AS a LEFT JOIN kota as b ON b.kode_kota = a.kode_kota WHERE a.konsumsi_id IS NOT NULL ".$wherefile_all." ".$grubby." ".$order;

        return $query;
    }



    public function dataPivot($filter)
    {
        foreach ($filter['pengukuran'] as $key) {
          if(isset($key)){
            // if ($key=='count')
            $this->db->select("count(*) as count");
            if ($key!='count') {
              if ($filter['operator']=='sum')
                $this->db->select("sum(a.".$key.") as ".$key);
              if ($filter['operator']=='avg')
                $this->db->select("avg(a.".$key.") as ".$key);
            }
          }
        }
        if ($filter['baris']){
          foreach ($filter['baris'] as $key) {
            if(isset($key) and $key!=''){
                $this->db->select($key);
            }
          }
        }

        $this->db->from('dash_konsumsi_ikan as a');
        $this->db->join('kota as b', 'b.kode_kota = a.kode_kota','left'); 


        
        if(isset($filter['filter_all']) and $filter['filter_all']!='')
        {

          $datas = $filter['filter_all'];
          $dataarr = array();
          foreach ($datas as $dat) {
            $dataarr[] = explode("|", $dat)[0];
          }
          
          $i=0;
          $dataand='';
          foreach ($dataarr as $da) {
            if ($i==0)
              $dataand = "(".$da.")";
            else
              $dataand .= " AND (".$da.")";
            $i +=1;
          }

          //$this->db->where($dataand);

          $saring  = str_replace("~","%",$dataand);
          $saring2 = str_replace("^","<",$saring);

          $this->db->where($saring2);
        } 
        
        if ($filter['baris']){
          foreach ($filter['baris'] as $key) {
            if(isset($filter['baris']) and $filter['baris']!=''){
              $this->db->group_by($filter['baris']);
            }
          }
        }

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
      $this->db->select('a.tot_konsumsi, a.kebutuhan');
      $this->db->where($data);
      $data = $this->db->get();

      return $data;
    }




}
