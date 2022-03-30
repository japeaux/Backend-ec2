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
  'label' => 'Eventos Criados', 
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

$query2 = "SELECT UNIX_TIMESTAMP(date(diainicio)) AS Dia, COUNT(genero) AS Total FROM diwoDB.evento WHERE diainicio BETWEEN '2019-05-03 15:54:00' - INTERVAL 1 WEEK AND CURDATE() AND (estado =1 or estado=5) GROUP BY date(diainicio)";


$result2 = mysqli_query($connect, $query2);
$rows2 = array();
$table2 = array();

$table2['cols'] = array(
 array(
  'label' => 'Dia', 
  'type' => 'date'
 ),
 array(
  'label' => 'Eventos Encerrados', 
  'type' => 'number'
 )
);

while($row2 = mysqli_fetch_array($result2))
{
 $sub_array2 = array();
 $datetime2 = explode(".", $row2["Dia"]);
 $sub_array2[] =  array(
      "v" => 'Date(' . $datetime2[0] . '000)'
     );
 $sub_array2[] =  array(
      "v" => $row2["Total"]
     );
 $rows2[] =  array(
     "c" => $sub_array2
    );
}
$table2['rows'] = $rows2;
//echo json_encode($table);
$jsonTable2 = json_encode($table2);





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
    var data2 = new google.visualization.DataTable(<?php echo $jsonTable2; ?>);
    var options = {
     title:'Eventos por dia',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var options2 = {
     title:'Eventos encerrados por dia',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('ScatterChart_chart2'));
    var chart2 = new google.visualization.ScatterChart(document.getElementById('ScatterChart_chart'));
    chart.draw(data, options);
    chart2.draw(data2, options2);
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
   <div id="ScatterChart_chart2" style="width: 100%; height: 500px"></div>
   <div class="spacer" style="width: 300px; height: 80px;"></div>
    <div id="ScatterChart_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>
