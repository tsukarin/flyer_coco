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
      $aflag=1;
      $uid= $row[0];
    }
  }
}
if($aflag==0){
  header('location: ./login.html');
}
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form enctype="multipart/form-data" action = "gupload.php" method = "post" >
イベント:<input type="text" name="event"><br />
画像アップロード：<input type="file" name="file_data">
ジャンル： <select class="form-select" aria-label="Default select example" name="genre">
            <option selected>ジャンルを選択</option>
            <option value="1">アイドル</option>
            <option value="2">ヒップホップ</option>
            <option value="3">レゲエ</option>
            <option value="4">ロックバンド</option>
          </select>
開催日：<input name="date" type="date" />
料金：<input type="text" name="fee">
出演者：<input type="text" name="performer">
その他：<textarea rows="7" name="other"></textarea>
<input type="submit" name="FILE送信" value="投稿">
</form>

<?php
$dbconn = pg_connect("host=localhost dbname=raito23 user=raito23 password=0QHxOR5a")
      or die('Could not connect: ' . pg_last_error());
// アップロードファイル情報を表示する。
if ( isset($_FILES['file_data'])){
  echo "アップロードファイル名　: " , $_FILES["file_data"]["name"] , "<BR>";
  
  $nfn=time() . "_" . getmypid() . "." .
    pathinfo($_FILES["file_data"]["name"], PATHINFO_EXTENSION);

// アップロードファイルを格納するファイルパスを指定,uploadsフォルダの場合。同フォルダは777にすること
  $filename = "./uploads/" . $nfn;

  if ( $_FILES["file_data"]["size"] === 0 ) {
    echo "ファイルはアップロードされてません！！ アップロードファイルを指定してください。";
  }else{
// アップロードファイルされたテンポラリファイルをファイル格納パスにコピーする
    $result=@move_uploaded_file($_FILES["file_data"]["tmp_name"], $filename);
    if($result === true){
    echo "アップロード成功(" . $nfn . ")！！";
      $event=$_POST['event'];
      $fee=$_POST['fee'];
      $genre=$_POST['genre'];
      $date=$_POST['date'];
      $performer=$_POST['performer'];
      $other=$_POST['other'];
      $sql="insert into gupload (filename,uid,date,genre,fee,performer,other,event) values('" . 
       $nfn . "','". $uid . "','" . $date . "','" . $genre . "','" . $fee . "','" . $performer . 
       "','" . $other . "','" . $event . "');";
      $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
      echo $date;
    }else{
      echo "アップロード失敗！！";
    }
  }
}
$sql="select filename  from gupload order by gid desc;";
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

</body>
</html>
