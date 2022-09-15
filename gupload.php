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

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FB 投稿ページ</title>
    <link rel="icon" href="favicon.ico">

    <!-- bootstrapのcss -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="post.css" rel="stylesheet" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
    crossorigin="anonymous"></script>
    <script>
        $(function() {
           const hum = $('#hamburger, .close')
           const nav = $('.sp-nav')
           hum.on('click', function(){
              nav.toggleClass('toggle');
           });
        });
        </script>
</head>
<body>



  <div class="probg"></div>
  <div class="container-fluid">
  <div class="row">

  <header>
      <img class="icon" src="icon_test.png">
      <nav class="pc-nav">
         <ul class="menu">
              <li><a href="index.php">TOP</a></li>
              
              <li><a href="./gupload.php">POST</a></li>
              <!-- <li><a href="index.php">MYPAGE</a></li> -->
         </ul>
      </nav>
      
      <div id="hamburger">
         <span></span>
      </div>
  </header>


  <!-- 左サイド -->
  <div class="col-sm-2 sidepic"></div>

  <!-- メインコンテンツ -->
  <div class="col-sm-8" style="background-color:#ffffff;">

  <div class="headspace"></div> <!-- ヘッダーが被るための余白 -->

  <h1 class="mc-b deka">フライヤーを投稿する</h1>
  <h4 class="mc-b deka">以下の項目に必要データを入力してください。</h4>
  <br>

<form enctype="multipart/form-data" action="gupload.php" method = "post" >

  <label class="mc-a">フライヤーのアップロード</label><br>
  <div class="mc-b">
  <input type="file" name="file_data"></div><br>

  <hr>

  <label class="mc-a">イベント名</label><br>
  <div class="mc-b">
  <textarea name="event" cols="60" rows="6" maxlength="600" placeholder="600文字以内で入力"></textarea></div><br>

  <hr>

  <label class="mc-a">ジャンル</label><br>
  <div class="mc-b">
  <select name="genre">
      <option>選択してください</option>
      <option value="1">アイドル</option>
      <option value="2">ヒップホップ</option>
      <option value="3">レゲエ</option>
      <option value="4">ロック</option>
  </select></div><br>
  <br>

  <hr>

  <label class="mc-a">日時</label><br>
  <div class="mc-b">
  <input type="date" name="date" value=""></div><br>
  <br>

  <hr>

  <label class="mc-a">料金</label><br>
  <div class="mc-b">
  <input type="text" name="fee" value=""></div><br>
  <br>

  <hr>

  <label class="mc-a">出演者</label><br>
  <div class="mc-b">
  <textarea name="performer" cols="60" rows="6" maxlength="600" placeholder="600文字以内で入力"></textarea></div><br>
  <br>

  <label class="mc-a">その他</label><br>
  <div class="mc-b">
  <textarea name="other" cols="60" rows="6" maxlength="600" placeholder="600文字以内で入力"></textarea></div><br>
  <br>

  <div class="mc-c">
  <input type="submit" name="FILE送信" value="投稿する">
  </div>
</form>
  </div>

  <!-- 右サイド -->
  <div class="col-sm-2 sidepic"></div>



<!---kokokara original  -->





<?php
$dbconn = pg_connect("host=localhost dbname=raito23 user=raito23 password=0QHxOR5a")
      or die('Could not connect: ' . pg_last_error());
// アップロードファイル情報を表示する。
if ( isset($_FILES['file_data'])){
  echo "アップロードファイル名　：　" , $_FILES["file_data"]["name"] , "<BR>";
  echo "MIMEタイプ　：　" , $_FILES["file_data"]["type"] , "<BR>";
  echo "ファイルサイズ　：　" , $_FILES["file_data"]["size"] , "<BR>";
  echo "テンポラリファイル名　：　" , $_FILES["file_data"]["tmp_name"] , "<BR>";
  echo "エラーコード　： " , $_FILES["file_data"]["error"] , "<BR>";

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
#$sql="select filename  from gupload order by gid desc;";
#$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
#echo "<table>\n";
#while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
#   echo "\t<tr>\n";
#   foreach ($line as $col_value) {
#     echo "\t\t<td><img width=\"100\" src=\"./uploads/$col_value\"</td>\n";
#   }
#   echo "\t</tr>\n";
 #}
 #echo "</table>\n";

?>

</body>
</html>
