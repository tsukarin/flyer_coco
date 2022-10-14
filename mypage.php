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
<style>
  .b{
    display: flex;
  }
</style>

<body>
    <a href="index.php">トップページへ</a>

<div class="a1">
<div class="b box1">
  <h2>お気に入り</h2>
<?php
//お気に入り///////////////////////////////////////////////////////////////////////////////////////// 
echo "</table>\n";

$sql="select filename,event,gid from gupload";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
//gidと詳細を見るをひとつひとつ繋ぐ
echo "<table border=\"1\">";
while($line = pg_fetch_array($result)){
  echo "<tr><td><img src=\"./uploads/" . $line['filename'] . "\" width=\"100px\" ></td>";
  echo "<td><form method=\"POST\" action=\"./detail.php\">";
  echo "<input type=\"hidden\" name=\"gid\" value=\"" . $line['gid'] . "\">";
  echo "<input type=\"submit\" value=\"詳細を見る\"></form>";
  echo "</td></tr>";
}
  //echo "</table>\n"; 
?>
</div>

<div class="b box2">
  <h2>投稿</h2>
<?php
//投稿////////////////////////////////////////////////////////////////////////////////////////////////
echo "</table>\n";

$sql="select filename,event,gid from gupload";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
//gidと詳細を見るをひとつひとつ繋ぐ
echo "<table border=\"1\">";
while($line = pg_fetch_array($result)){
  echo "<tr><td><img src=\"./uploads/" . $line['filename'] . "\" width=\"100px\" ></td>";
  echo "<td><form method=\"POST\" action=\"./detail.php\">";
  echo "<input type=\"hidden\" name=\"gid\" value=\"" . $line['gid'] . "\">";
  echo "<input type=\"submit\" value=\"詳細を見る\"></form>";
  echo "</td></tr>";
}
 //echo "</table>\n";
 ?>
</div>

<div class="b box3">
  <h2>アーカイブ</h2>
<?php
//アーカイブ/////////////////////////////////////////////////////////////////////////////////////////////
echo "</table>\n";

$sql="select filename,event,gid from gupload";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
//gidと詳細を見るをひとつひとつ繋ぐ
echo "<table border=\"1\">";
while($line = pg_fetch_array($result)){
  echo "<tr><td><img src=\"./uploads/" . $line['filename'] . "\" width=\"100px\" ></td>";
  echo "<td><form method=\"POST\" action=\"./detail.php\">";
  echo "<input type=\"hidden\" name=\"gid\" value=\"" . $line['gid'] . "\">";
  echo "<input type=\"submit\" value=\"詳細を見る\"></form>";
  echo "</td></tr>";
}
 //echo "</table>\n";
 //////////////////////////////////////////////////////////////////////////////////////////////////////
?>
</div>
</div>

</body>
</html>