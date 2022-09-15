<html>
<head>
<title>Detail</title>
</head>
<body style = "background-color: antiquewhite;">
<body>
<?php
if (isset($_POST['gid'])){$gid = $_POST['gid']; }
$dbconn = pg_connect("host=localhost dbname=raito23 user=raito23 password=0QHxOR5a");
$query = "SELECT * from gupload where gid = " . $gid . ";";

$result = pg_query($query) or ('Query failed: ' . pg_last_error());
echo "<table>";
while ($line = pg_fetch_array($result,null,PGSQL_ASSOC)){
  //foreach ($line as $item){
  //   echo "<li>" . $item . "</li>";
  //}
  echo "<tr><td><img src=\"./uploads/" . $line['filename'] . "\" width=\"100px\"><td>";
  echo "<td>";
  echo "<ul>";
  echo "<li>" . $line['event'] . "</li>";
  echo "<li>" . $line['date'] . "</li>";
  echo "<li>" . $line['performer'] . "</li>";
  echo "<li>" . $line['other'] . "</li>";
  echo "</ul>";
  echo "</td></tr>";
}
echo "</table>";
?>
</body>
</html>
