<html>
<head>

<title><?php echo $judul ?></title>
</head>
<style type="text/css">
body {
  font-family: "Roboto", "Helvetica", "Arial", sans-serif;
  font-size: 9px;
}
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 8px;
}


</style>
<body>
  <center><h2><?= $judul ?></h2></center>
    <table >
      <?php

        $data_head = explode(",", $head);
        echo '<tr>';
          foreach ($data_head as $row) 
          {
            
            echo '<th style="text-align:center;">'.$row.'</th>';
          }
        echo '</tr>';
        
          foreach ($isi as $val) 
          {
            $hitung = count($val);

             echo '<tr>';
              for ($i = 0; $i <= $hitung-1; $i++) 
              {
                  echo '<td>'.$val[$i].'</td>';
              } 
             echo '</tr>';
          }
           
      ?>
          
      </table>
   
</body>
</html>
