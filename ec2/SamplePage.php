<?php include "../inc/dbinfo.inc"; 
?>


<html>
<body>
<h1>KPI</h1>

<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Numero</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM diwoDB.evento WHERE DATE(diafim) > DATE(CURDATE()-8) AND (estado = 1 or estado = 3 or estado = 5 or estado = 6)"); 
$nrow = mysqli_num_rows($result);
//while($query_data = mysqli_fetch_row($result)) {

  echo "$nrow";
  //echo "</tr>";

?>

</table>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>

