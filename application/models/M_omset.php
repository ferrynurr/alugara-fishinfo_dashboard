<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_omset extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    private function query()
    {
      $this->db->select('a.omset_id, a.trader_id, a.kegiatan, a.tgl_mulai, a.tgl_selesai, a.jenis, a.kode_kota, a.kode_provinsi, b.nama_trader, c.nama_kota, d.nama_provinsi');
      $this->db->from('dash_omset as a');
      $this->db->join('dash_trader as b', 'b.trader_id = a.trader_id','left'); 
      $this->db->join('kota as c', 'c.kode_kota = a.kode_kota','left'); 
      $this->db->join('provinsi as d', 'd.kode_provinsi = a.kode_provinsi','left'); 

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
           $this->db->select('SUM(a.omset) omset');
           $this->db->group_by($filter['selected_group']);
          
        }
        else{         
          $this->db->select('a.omset');
          $this->db->order_by('a.kegiatan');
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
            $selgrub = ",SUM(a.omset) omset";
            $grubby = "GROUP BY ".implode(",", $filter['selected_group']);      
        }
        else{         
          $selgrub = ", a.omset";
          $order = "ORDER BY a.kegiatan ASC";
        }


        $query = "SELECT a.omset_id, a.trader_id, a.kegiatan, a.tgl_mulai, a.tgl_selesai, a.jenis, a.kode_kota, a.kode_provinsi, b.nama_trader, c.nama_kota, d.nama_provinsi ". $selgrub."  FROM dash_omset AS a LEFT JOIN dash_trader as b ON b.trader_id = a.trader_id LEFT JOIN kota as c ON c.kode_kota = a.kode_kota LEFT JOIN provinsi as d ON d.kode_provinsi = a.kode_provinsi WHERE a.omset_id IS NOT NULL ".$wherefile_all." ".$grubby." ".$order;

        return $query;
    }

    /*
    public function dataSavedashboard($filter)
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


        if( isset($filter['selected_group']))
        {
           $this->db->select('SUM(a.omset) omset');
           $this->db->group_by($filter['selected_group']);
          
        }
        else{         
          $this->db->select('a.omset');
          $this->db->order_by('a.kegiatan');
        }

        
        $data = $this->db->get();
        $toarr = array();
        $no=0;
        foreach ($data->result() as $val) 
        {
          $no++;
         $dts = array();
        
            if( isset($filter['selected_group']))
            { 
              $cek = implode(',', $filter['selected_group']);

                if($cek == 'jenis')
                    $dts = $no.'/'.$val->jenis.'/'. number_format($val->omset,0,',','.'); 
                else if($cek == 'nama_trader')
                    $dts = $no.'/'.$val->nama_trader.'/'. number_format($val->omset,0,',','.');
                else{

                  $dts[] = $no.'/'.$val->nama_trader.'/'. $val->jenis.'/'. number_format($val->omset,0,',','.');
                }
            
            }
            else
            {
                $dts[] = $no.'/'.$val->nama_trader.'/'.$val->kegiatan.'/'. $val->tgl_mulai.'/'. $val->tgl_selesai.'/'. $val->jenis.'/'. $val->nama_kota.$val->nama_provinsi.'/'. number_format($val->omset,0,',','.');
              
               
            } 
              $toarr[] = $dts;
            
        }

        return $toarr;
    }
    */
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
        $this->db->from('dash_omset as a');
        $this->db->join('dash_trader as b', 'b.trader_id = a.trader_id','left'); 


        
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
      $this->db->select('a.omset');
      $this->db->where($data);
      $data = $this->db->get();

      return $data;
    }




}
