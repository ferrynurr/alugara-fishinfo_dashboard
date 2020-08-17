<html>
<head>

<title>LAPORAN DASHBOARD FISHINFO</title>
<!--
<link href="assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'"></script>
<script src="assets/gentelella/vendors/jquery/dist/jquery.min.js"></script>

<link href="assets/gentelella/vendors/highcharts/css/highcharts.css" rel="stylesheet" type="text/css" />
<script src="assets/gentelella/vendors/highcharts/highcharts.js"></script>
<script src="assets/gentelella/vendors/highcharts/highcharts-more.js"></script>
<script src="assets/gentelella/vendors/highcharts/modules/exporting.js"></script>
<script src="assets/gentelella/vendors/highcharts/modules/export-data.js"></script>
<script src="assets/gentelella/vendors/highcharts/modules/accessibility.js"></script>

-->

</head>
<style type="text/css">
body {
  font-family: "Roboto", "Helvetica", "Arial", sans-serif;
 
  padding: 10px;
}
table, td, th {  
  border: 1px solid #ddd;
  text-align: center;
}

table {
  border-collapse: collapse;
  width: 100%;
  font-size: 11px;
}

th, td {
  padding: 8px;
}

.solid {
     width: 100%;
     height: 100%;
     border: 2px solid black;
}

.konten{
  padding: 10px;
  background-color: #fdf9f9;

}
</style>
<body>

    <center><u><h1>LAPORAN DASHBOARD FISHINFO</h1></u></center><br/><br/>

    <?php 
      foreach ($tabel->result() as $row) {
    ?>
        <div class="konten">
            <center><h2><?= ucwords($row->dashtab_name) ?></h2></center><br/>
            <table>
              <?php 
                  $data_head = explode(",", $row->thead);
                  echo '<tr>';
                    foreach ($data_head as $thead) 
                    {
                      
                      echo '<th style="text-align:center;">'.$thead.'</th>';
                    }
                  echo '</tr>';

                  $saring  = str_replace("~","%",$row->query);
                  $saring2 = str_replace("^","<",$saring);

                  $query = $this->db->query($saring2);
                  $tbody_field = explode(",", $row->thead_key);

                  $no=1;
                  foreach ($query->result() as $tbody) 
                  {
                    echo '<tr>';
                    echo '<td>'.$no.'</td>';
                    foreach ($tbody_field as $field) {
                      $pecah = explode("|", $field);

                      if($pecah[1] == 'text')
                        echo  '<td>'.$tbody->{$pecah[0]}.'</td>';
                      elseif($pecah[1] == 'number') 
                        echo  '<td>'.number_format($tbody->{$pecah[0]},0,',','.').'</td>';
                      elseif($pecah[1] == 'float') 
                        echo  '<td>'.number_format($tbody->{$pecah[0]},2,',','.').'</td>';
                      elseif($pecah[1] == 'date') 
                        echo  '<td>'.date("d-M-Y", strtotime($tbody->{$pecah[0]})).'</td>';
                    }
                    echo '</tr>';
                    $no++;
                  }


               ?>
            </table>
        </div>
        <br/><br/>
    <?php
    }  
    ?>

   
</body>
</html>
