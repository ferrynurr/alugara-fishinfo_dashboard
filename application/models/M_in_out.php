<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_in_out extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    private function query($uri)
    {

      $this->db->select('a.trader_name, a.tgl, a.komoditas_id, b.jenis_komoditas, b.komoditas_kel_id, c.nama_komoditas_kel, a.satuan_awal');

      if($uri == 'dom_masuk')
      {
          $this->db->select('a.dom_masuk_id, a.asal');
          $this->db->from('dash_dom_masuk as a');
      }
      elseif($uri == 'dom_keluar')
      {
          $this->db->select('a.dom_keluar_id, a.tujuan');
          $this->db->from('dash_dom_keluar as a');
      }
      elseif($uri == 'ekspor')
      {
          $this->db->select('a.ekspor_id, a.tujuan');
          $this->db->from('dash_ekspor as a');
      }
      elseif($uri == 'impor')
      {
          $this->db->select('a.impor_id, a.asal');
          $this->db->from('dash_impor as a');
      }

      $this->db->join('dash_komoditas as b', 'b.komoditas_id = a.komoditas_id','left'); 
      $this->db->join('dash_komoditas_kelompok as c', 'c.komoditas_kel_id = b.komoditas_kel_id','left');
      $this->db->order_by('a.trader_name', 'asc'); 

    }

    public function dataTablesNew($filter)
    {
        $this->query($filter['uri']);


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
           $this->db->select('SUM(a.jumlah_awal) jumlah_awal, SUM(a.nilai) nilai');
           $this->db->group_by($filter['selected_group']);
          
        }else{
           $this->db->select('a.jumlah_awal, a.nilai');
        }


        $data = $this->db->get();
        return $data;
    }

    public function simpanDash($filter)
    {
    
       $selgrub = '';
       $order ='';
       $grubby ='';
       $sel_from ='';
       $sel_filter= '';

       $wherefile_all = '';

       $uri = $filter['uri'];

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
            $selgrub = ",SUM(a.jumlah_awal) jumlah_awal, SUM(a.nilai) nilai";
            $grubby = "GROUP BY ".implode(",", $filter['selected_group']);      
        }
        else{         
          $selgrub = ",a.jumlah_awal, a.nilai";
          $order = "ORDER BY a.trader_name ASC";
        }


        if($uri == 'dom_masuk')
        {
            $sel_filter = ',a.dom_masuk_id, a.asal';
            $sel_from = 'dash_dom_masuk';
        }
        elseif($uri == 'dom_keluar')
        {
            $sel_filter = ',a.dom_keluar_id, a.tujuan';
            $sel_from = 'dash_dom_keluar';
        }
        elseif($uri == 'ekspor')
        {
            $sel_filter = ',a.ekspor_id, a.tujuan';
            $sel_from = 'dash_ekspor';
        }
        elseif($uri == 'impor')
        {
            $sel_filter = ',a.impor_id, a.asal';
            $sel_from = 'dash_impor';
        }


        $query = "SELECT a.trader_name, a.tgl, a.komoditas_id, b.jenis_komoditas, c.nama_komoditas_kel, a.satuan_awal ". $selgrub." ".$sel_filter." FROM ".$sel_from." AS a LEFT JOIN dash_komoditas as b ON b.komoditas_id = a.komoditas_id LEFT JOIN dash_komoditas_kelompok as C ON c.komoditas_kel_id = b.komoditas_kel_id WHERE a.trader_name IS NOT NULL ".$wherefile_all." ".$grubby." ".$order;

        return $query;
    }

   


    public function dataPivot($filter)
    {

      $uri = $filter['uri'];
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

      
      if($uri == 'dom_masuk')
      {
          //$this->db->select('a.dom_masuk_id, a.asal');
          $this->db->from('dash_dom_masuk as a');
      }
      elseif($uri == 'dom_keluar')
      {
          //$this->db->select('a.dom_keluar_id, a.tujuan');
          $this->db->from('dash_dom_keluar as a');
      }
      elseif($uri == 'ekspor')
      {
          //$this->db->select('a.ekspor_id, a.tujuan');
          $this->db->from('dash_ekspor as a');
      }
      elseif($uri == 'impor')
      {
        //  $this->db->select('a.impor_id, a.asal');
          $this->db->from('dash_impor as a');
      }


      $this->db->join('dash_komoditas as b', 'b.komoditas_id = a.komoditas_id','left'); 
      $this->db->join('dash_komoditas_kelompok as c', 'c.komoditas_kel_id = b.komoditas_kel_id','left');
      $this->db->order_by('a.trader_name', 'asc'); 

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

    public function get_byID($uri, $data)
    {
      $this->query($uri); 
      $this->db->select('a.jumlah_awal, a.nilai');
      $this->db->where($data);
      $data = $this->db->get();

      return $data;
    }




}
