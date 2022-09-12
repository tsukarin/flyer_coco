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

<!-- kokokara -->
<?php

if (isset($_POST['kw']) && strlen($_POST['kw'])>0){$kw=$_POST['kw'];}
if (isset($_POST['genre'])&& strlen($_POST['genre'])>0){$genre=$_POST['genre'];}
if (isset($_POST['from'])&& strlen($_POST['from'])>0){$from=$_POST['from'];}
if (isset($_POST['to'])&& strlen($_POST['to'])>0){$to=$_POST['to'];}
if (isset($_POST['order'])&& strlen($_POST['order'])>0){$order=$_POST['order'];}


$sql="select filename,event from gupload";
$wflag=0;
if (isset($kw)){
  $sql=$sql . " where other like '%" . $kw . "%' ";
  $wflag=1;
}
if(isset($genre) && $wflag==0){
  $sql=$sql . " where genre='" . $genre . "' ";
  $wflag=1;
}
elseif(isset($genre) && $wflag==1){
  $sql=$sql . " and genre='" . $genre . "' ";
}
if(isset($from) && $wflag==0){
  $sql=$sql . " where date>'" . $from . "' ";
  $wflag=1;
}
elseif(isset($from) && $wflag==1){
  $sql=$sql . " and date>'" . $from . "' ";
}
if(isset($to) && $wflag==0){
  $sql=$sql . " where date<'" . $to . "' ";
  $wflag=1;
}
elseif(isset($to) && $wflag==1){
  $sql=$sql . " and date<'" . $to . "' ";
}
if (isset($order) && $order==1){
  $sql=$sql . " order by gid desc ";
}
elseif (isset($order) && $order==2){
  $sql=$sql . " order by date desc ";
}
$sql=$sql . ";";
echo $sql;
echo $to;
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
