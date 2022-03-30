<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Indicações</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, diwoDB);

?>


<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Pessoa que esta indicando</td>
    <td>Cidade/Bairro do user</td>
    <td>Nome do negócio</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM diwoDB.report WHERE tiporeport = 'Indica negocio' ORDER BY idreport DESC");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[2], "</td>",
       "<td>",$query_data[4], "</td>",
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
