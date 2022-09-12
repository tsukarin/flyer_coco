
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>phpb07</title>
</head>
<body>
<?php
$table='country';
$attribute='cname';
$dbconn = pg_connect("host=localhost dbname=raito23 user=raito23 password=0QHxOR5a")
or die('Could not connect: ' . pg_last_error());
$query="select " . $attribute . " from " . $table . ";";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
echo '<form method="POST" action="./phpb07.php">';
echo '<select name="q">';
while ($line = pg_fetch_row($result)) {
echo '<option value="' . $line[0] . '">' . $line[0] . '</option>';
}
echo '</select>';
echo '<input type="submit" value="search">';
echo '</form>';
if (isset($_POST['q'])){
$q=$_POST['q'];
$query='select * from ' . $table . ' where ' . $attribute . '=\' . $q . '\';';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
echo "<table>\n";
while ($line = pg_fetch_row($result)){
echo "\t<tr>\n";
foreach ($line as $col_value) {
echo "\t\t<td>$col_value</td>\n";
}
echo "\t</tr>\n";
}
echo "</table>\n";
}
?>
</body>
</html>