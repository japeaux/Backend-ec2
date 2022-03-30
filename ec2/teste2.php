<?php
//index.php
$connect = mysqli_connect("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
$query = 'SELECT precopor, UNIX_TIMESTAMP(diafim) AS datetime FROM diwoDB.evento WHERE (estado = 1 or estado = 3 or estado = 5 or estado = 6)ORDER BY diainicio';

$primeirodia = "SELECT diainicio FROM diwoDB.evento ORDER BY diainicio ASC LIMIT 1";

$resultprimeirodia = mysqli_query($connect,$primeirodia);
$dados = array();
if(mysqli_num_rows($resultprimeirodia) >= 1){
  while($row = mysqli_fetch_assoc($resultprimeirodia)){
      $dados[] = $row; 
  }
  $json_str = json_encode($dados);
  echo  "$json_str";
}

$eventosdaprimeira = "SELECT * FROM diwoDB.evento WHERE diainicio < DATE($dados[diainicio]+7)";

$resulteventosdaprimeira = mysqli_query($connect,$eventosdaprimeira);
$dadoseventosdaprimeira = array();
if(mysqli_num_rows($resulteventosdaprimeira) >= 1){
  while($roweventosdaprimeira = mysqli_fetch_assoc($resulteventosdaprimeira)){
      $dadoseventosdaprimeira[] = $roweventosdaprimeira; 
  }
  $json_streventosdaprimeira = json_encode($dadoseventosdaprimeira);
  echo  "$json_streventosdaprimeira";
}

$result = mysqli_query($connect, $query);
$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Evento', 
  'type' => 'number'
 )
);

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["datetime"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["precopor"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
echo json_encode($table);
$jsonTable = json_encode($table);

?>


<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

    var options = {
     title:'Sensors Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script>
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center">Display Google Line Chart with JSON PHP & Mysql</h2>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>
