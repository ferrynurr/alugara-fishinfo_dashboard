<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_harga_konsumsi extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    private function query()
    {
          $this->db->select('a.kode_survey_pasar, a.tanggal, a.kode_ikan, a.kode_kota, b.nama_kota, c.nama_ikan, d.nama_surveyor');
          $this->db->from('survey_harga_konsumsi as a');
          $this->db->join('kota as b', 'b.kode_kota = a.kode_kota','left'); 
          $this->db->join('ikan as c', 'c.kode_ikan = a.kode_ikan','left');
          $this->db->join('surveyor as d', 'd.kode_surveyor = a.kode_surveyor','left');
    }

    public function dataTablesNew($filter)
    {
        $this->query();
        $this->db->where('a.jenis', $filter['jenis'] );

        if($filter['jenis'] != 1)
        {
          $this->db->join('data_pasar as e', 'e.id_pasar = a.id_pasar','left');
          $this->db->select('e.nama_pasar');
        }


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

          $this->db->where($dataand);
        }


        #-- FILTER LANJUTAN -->
        if( isset($filter['selected_group']))
        {
           $this->db->select('AVG(a.harga) harga, SUM(a.volume) volume');
           $this->db->group_by($filter['selected_group']);
          
        }
        else{         
          $this->db->select('a.volume, a.harga');
          $this->db->order_by('b.nama_kota');
        }

        
        $data = $this->db->get();

        return $data;
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

        // $this->db->select('a.kode_survey_pasar, a.tanggal, a.kode_ikan, a.kode_kota, b.nama_kota, c.nama_ikan, d.nama_surveyor');
        $this->db->from('survey_harga_konsumsi as a');
        $this->db->join('kota as b', 'b.kode_kota = a.kode_kota','left'); 
        $this->db->join('ikan as c', 'c.kode_ikan = a.kode_ikan','left');
        $this->db->join('surveyor as d', 'd.kode_surveyor = a.kode_surveyor','left');

        $this->db->where('a.jenis', $filter['jenis'] );

        if($filter['jenis'] != 1)
        {
          $this->db->join('data_pasar as e', 'e.id_pasar = a.id_pasar','left');
          // $this->db->select('e.nama_pasar');
        }
        
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

          $this->db->where($dataand);
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

    public function update($tbl, $where, $data)
    {
        $this->db->set( $data);
        $this->db->where($where);
        $this->db->update($tbl);

        return $this->db->affected_rows();

    }

    public function delete($data = array(), $tb)
    {
        $this->db->where($data);
        $this->db->delete($tb);
    }

    public function get_byID($data)
    {
      $this->query(); 
      $this->db->select('a.id_pasar, a.volume, a.harga');

      $this->db->where($data);
      $data = $this->db->get();

      return $data;
    }

    public function data_favorite($data, $tbl)
    {
        

        $this->db->where($data);
        $data = $this->db->get($tbl);

        return $data;
    }



}
