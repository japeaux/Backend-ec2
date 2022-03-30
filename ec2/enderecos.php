<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Endereços não verificados</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect("diwodb.c9c8abhxvhos.us-east-2.rds.amazonaws.com","diwoadmin","diwoadmin","diwoDB");
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, diwoDB);

?>

<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Nome </td>
    <td>email </td>
	<td>telefone </td>
 	 <td>Estado </td>
	<td>Cidade </td>
    <td>Bairro </td>
    <td>Endereço </td>
    <td>Numero </td>
	 <td>Complemento </td>
	 <td>CEP </td>    
	<td>Codigo </td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM diwoDB.userbairro WHERE contaaprovada='nao' AND endereco IS NOT NULL ORDER BY diapedebairro");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[1], "</td>",
	 "<td>",$query_data[3], "</td>",
	"<td>",$query_data[2], "</td>",
	"<td>",$query_data[7], "</td>",       
	"<td>",$query_data[6], "</td>",
       "<td>",$query_data[8], "</td>",
	"<td>",$query_data[9], "</td>",
       "<td>",$query_data[10], "</td>",
	"<td>",$query_data[11], "</td>",	
	"<td>",$query_data[12], "</td>",
       "<td>" ,$query_data[15],"</td>";
  echo "</tr>";
}
?>

</table>

<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>

                     
                







