<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_non_konsumsi extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    private function query()
    {
          $this->db->select('a.kode_survey_nonkonsumsi, a.kode_pengusaha, a.tanggal, a.kode_ikan_hias, a.kode_komoditi, a.jenis_komoditi, a.tujuan_jatim, a.tujuan_luar_jatim, a.tujuan_luar_negeri, a.harga, a.harga_kg, a.harga_l, a.omset, b.nama_perusahaan, b.kode_kota, c.nama_kota, d.nama_komoditi, e.nama_ikan_hias, f.nama_surveyor');
          $this->db->from('survey_nonkonsumsi as a');
          $this->db->join('pengusaha as b', 'b.kode_pengusaha = a.kode_pengusaha','left'); 
          $this->db->join('kota as c', 'c.kode_kota = b.kode_kota','left');
          $this->db->join('komoditi as d', 'd.kode_komoditi = a.kode_komoditi','left');
          $this->db->join('ikan_hias as e', 'e.kode_ikan_hias = a.kode_ikan_hias','left');
          $this->db->join('surveyor as f', 'f.kode_surveyor = a.kode_surveyor','left');
    }


    public function dataTablesNew($filter)
    {
        $this->query();

        if( !isset($filter['selected_group']) && !isset($filter['filter_all']) )
          //$this->db->where('a.tanggal <=', date('Y-m-d'))->where('a.tanggal >=', date('Y-m-d', strtotime("-1 months")));

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
           $this->db->select('AVG(a.harga) harga');
           $this->db->select('AVG(a.harga_kg) harga_kg');
           $this->db->select('AVG(a.harga_l) harga_l');
           $this->db->select('SUM(a.omset) omset');
           $this->db->group_by($filter['selected_group']);
          
        }
        else
        {         
          $this->db->select('a.harga, a.harga_kg, a.harga_l, a.omset');
          $this->db->order_by('a.tanggal', 'desc');
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
            $selgrub = ",AVG(a.harga) harga, AVG(a.harga_kg) harga_kg, AVG(a.harga_l) harga_l, SUM(a.omset) omset";
            $grubby = "GROUP BY ".implode(",", $filter['selected_group']);      
        }
        else{         
          $selgrub = ",a.harga, a.harga_kg, a.harga_l, a.omset";
          $order = "ORDER BY a.tanggal DESC";
        }


        $query = "SELECT a.kode_survey_nonkonsumsi, a.kode_pengusaha, a.tanggal, a.kode_ikan_hias, a.kode_komoditi, a.jenis_komoditi, a.tujuan_jatim, a.tujuan_luar_jatim, a.tujuan_luar_negeri, a.harga, a.harga_kg, a.harga_l, a.omset, b.nama_perusahaan, b.kode_kota, c.nama_kota, d.nama_komoditi, e.nama_ikan_hias, f.nama_surveyor ".$selgrub."  FROM survey_nonkonsumsi AS a LEFT JOIN pengusaha as b ON b.kode_pengusaha = a.kode_pengusaha LEFT JOIN kota as c ON c.kode_kota = b.kode_kota LEFT JOIN komoditi as d ON d.kode_komoditi = a.kode_komoditi LEFT JOIN ikan_hias as e ON e.kode_ikan_hias = a.kode_ikan_hias LEFT JOIN surveyor as f ON f.kode_surveyor = a.kode_surveyor WHERE a.kode_survey_nonkonsumsi IS NOT NULL ".$wherefile_all." ".$grubby." ".$order;

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

        // $this->db->select('a.kode_survey_pasar, a.tanggal, a.kode_ikan, a.kode_kota, b.nama_kota, c.nama_ikan, d.nama_surveyor');
         $this->db->from('survey_nonkonsumsi as a');
          $this->db->join('pengusaha as b', 'b.kode_pengusaha = a.kode_pengusaha','left'); 
          $this->db->join('kota as c', 'c.kode_kota = b.kode_kota','left');
          $this->db->join('komoditi as d', 'd.kode_komoditi = a.kode_komoditi','left');
          $this->db->join('ikan_hias as e', 'e.kode_ikan_hias = a.kode_ikan_hias','left');
          $this->db->join('surveyor as f', 'f.kode_surveyor = a.kode_surveyor','left');

        
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

    public function data_favorite($id, $get)
    {
        if($get)
            $this->db->where('field_id', $get);

        $this->db->where('filter_id', $id);
        $data = $this->db->get('dash_filter_data_detail');

        return $data;
    }

    public function get_byID($data)
    {
      $this->query(); 

      $this->db->where($data);
      $data = $this->db->get();

      return $data;
    }



}
