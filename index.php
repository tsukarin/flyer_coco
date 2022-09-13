<?php
session_start();
if (isset($_SESSION['ems'])) {
  $ems=$_SESSION['ems'];
}
if (isset($_SESSION['pws'])) {
  $pws=$_SESSION['pws'];
}
if (isset($_POST['emf'])){$ems=$_POST['emf'];}
if (isset($_POST['pwf'])){$pws=$_POST['pwf'];}
$aflag=0;
if (isset($ems) &&isset($pws)){
  $sql="select * from phpua where email='". $ems . "';";
  $dbconn = pg_connect("host=localhost dbname=raito23 user=raito23 password=0QHxOR5a")
    or die('Could not connect: ' . pg_last_error());
  $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
  if(pg_num_rows($result)==1){
    $row = pg_fetch_row($result);
    if (password_verify($pws, $row[3])){
      $_SESSION['ems']=$ems;
      $_SESSION['pws']=$pws;
      $uid=$row[0];
      $aflag=1;
    }
  }
}
if($aflag==0){
  header('location: ./login.html');
}
?>



<html>
<head>
  <title>
    login
  </title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">


</head>
<body>

<?php
 echo "<p>LOGIN SUCCEED: " . $ems . "</p>\n";
 echo "<p><a href=\"./logout.php\">LOGOUT</a>";
 ?>
 <br>
<a href="./gupload.php">フライヤー登録はこちら~!</a>

<!-- kokokara -->
<?php
$sql="select filename from gupload where uid='" . $uid . "' order by gid desc;";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
   echo "\t<tr>\n";
   foreach ($line as $col_value) {
     echo "\t\t<td><img width=\"100\" src=\"./uploads/$col_value\"</td>\n";
   }
   echo "\t</tr>\n";
 }
 echo "</table>\n";

?>

<!-- kokomade -->
</body>
</html>
