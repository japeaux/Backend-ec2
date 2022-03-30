<?php
//index.php
$connect = mysqli_connect("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
// $query = 'SELECT precopor, UNIX_TIMESTAMP(diafim) AS datetime FROM diwoDB.evento WHERE (estado = 1 or estado = 3 or estado = 5 or estado = 6)ORDER BY diainicio';



$query = "SELECT UNIX_TIMESTAMP(date(diainicio)) AS Dia, COUNT(genero) AS Total FROM diwoDB.evento WHERE diainicio BETWEEN '2019-05-03 15:54:00' - INTERVAL 1 WEEK AND CURDATE() GROUP BY date(diainicio)";


$result = mysqli_query($connect, $query);
$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'date'
 ),
 array(
  'label' => 'Evento', 
  'type' => 'number'
 )
);

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["Dia"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["Total"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
//echo json_encode($table);
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
     title:'Eventos por dia',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
    var chart2 = new google.visualization.ScatterChart(document.getElementById('ScatterChart_chart'));
    chart.draw(data, options);
    chart2.draw(data, options);
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
   <h2 align="center">KDI</h2>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
   <div class="spacer" style="width: 300px; height: 80px;"></div>
    <div id="ScatterChart_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>
