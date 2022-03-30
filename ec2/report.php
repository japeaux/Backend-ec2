
<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Reports</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, diwoDB);

?>
//<a href="appdiwo://">Open</a>
//<a href="appdiwo://app/eventoConvidado/567">Open</a>
<a href="appdiwo://eventoConvidado/567">TESTE ANDROID</a>

//<a href="appdiwo://eventoConvidado?idevento=567">TESTE ANDROID2</a>
//<a href="appdiwo://eventoConvidado/:idevento=567">MAIS UM</a>
//<a href="appdiwo://eventoConvidado/idevento?idevento=567">MAIS UM outro</a>
//<a href="appdiwo://eventoConvidado/:idevento?idevento=567">MAIS UM</a>
<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Pessoa que esta reportando</td>
    <td>Nome do reportado</td>
    <td>Tipo do report</td>
    <td>Motivo</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM diwoDB.report");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[2], "</td>",
       "<td>",$query_data[4], "</td>",
       "<td>",$query_data[5], "</td>",
       "<td>",$query_data[6], "</td>";
  echo "</tr>";
}
?>

</table>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>


