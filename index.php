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
<body style = "background-color: antiquewhite;">
<body>

<h1>Flyer Board</h1>

<?php
 echo "<p>LOGIN SUCCEED: " . $ems . "</p>\n";
 echo "<p><a href=\"./logout.php\">LOGOUT</a>";
 ?>
 </br>

 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16" href="./gupload.php">
  <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
</svg>

 <div class="input-group">
          <form method="post" action="./search.php">
            <input type="text" name="kw" class="form-control" placeholder="キーワードを入力">
          </div>

        <div class="input-group">
          <select name="genre" class="form-select" aria-label="Default select example">
            <option selected>ジャンルを選択(必須)</option>
            <option value="1">アイドル</option>
            <option value="2">ヒップホップ</option>
            <option value="3">レゲエ</option>
            <option value="4">ロックバンド</option>
          </select>
        </div>

        <div class="input-group">
            <select name="order" class="form-select" aria-label="Default select example">
            <option selected>表示順</option>
            <option value="1">新着</option>
            <option value="2">開催日</option>
            <option value="3">人気</option>
          </select>
          
        </div>


        <input name="from" type="date" />
        〜<input name="to" type="date" />

      </br>
      <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>

</form>

<br>



<!-- kokokara -->
<!-- <?php
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

?> -->

<!-- kokomade -->
</body>
</html>
