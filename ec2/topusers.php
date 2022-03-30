<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Top Users</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, diwoDB);

?>


<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Número de eventos idos</td>
    <td>Nome do indivíduo</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT COUNT(a.iduser) AS n, a.apelido FROM  diwoDB.pessoaevento a WHERE a.estado ='3' GROUP BY  a.iduser order by n desc");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>";
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


