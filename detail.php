<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Munin Viewer -detail</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">

    <!-- Original CSS-->
    <link href="css/muninviewer.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <?php
    require_once('./navbar.php');
    require_once('./setConfig.php');
  ?>


    <p>

    <div class="container">
    <div class="col-xs-12 col-md-12">
    <div class="thumbnail">   
      <?php
        if(isset($_GET['svn'])&&isset($_GET['checkbox'])&&isset($_GET['term'])){
          $svn = $_GET['svn'];
          $checkbox = $_GET['checkbox'];
          $term = $_GET['term'];

          $urlPic = "http://".$muninServer."/cgi-bin/munin-cgi-graph/".$svn."/".$svn."/".$checkbox."-".$term.".png";

          echo "<img src=\"$urlPic\" alt=\"...\"><BR>";
          echo "<div class=\"caption\">";
          echo " server: <strong>$svn</strong>";
          echo " target: <strong>$checkbox</strong>";
          echo " term: <strong>$term</strong>";
          echo "</div>";
        }else{
          echo "不正なアクセスです";
        }
      ?>
    </div><!-- /thumbnail -->
      <form action="<?php echo "detail.php?svn=$svn&checkbox=$checkbox&term=$term"; ?>"  class="thumbnail" method="POST">
      <div class="input-group">
        <input type="text" name="comment" class="form-control">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit">Write!</button>
        </span>
      </div>
      </form>
    
    <?php
      $file_name = $svn."_".$checkbox."_".$term.".txt";
      $file_url = "./text/".$file_name;
      // ☆☆☆フォームから送信された内容をファイルに書き込む☆☆☆
      if(!empty($_POST["comment"])){  // 書き込みがあるかチェック


        $file = fopen($file_url, "a") or die("OPENエラー $file_url");  // $file_nameを追記モード"a"で開く、またはエラーを返す処理を$fileへ入れる。※"w"だと上書きされる
        $comment = $_POST["comment"]." (".date("n月j日 H時i分", strtotime("+8 hour")).")"; // $_POST["comment"]を$commentに入れる
        flock($file, LOCK_EX);  // ファイルをロック
        fputs($file, "$comment\r\n"); //$fileに$comment\r\nを書き込む。\r、\nは改行
        flock($file, LOCK_UN);  // ロックを開放する
        fclose($file);  // ファイルを閉じる
      }
      
     if(file_exists($file_url)){
      $file = fopen($file_url,"r") or die("OPENエラー $file_url");
      flock($file, LOCK_EX);

      while (!feof($file)) {  // ファイルポインタがファイル終端に達しているかどうか調べ、達するまで以下の処理をする
        $string = fgets($file, 1000);  // ファイルから行を取得、１行1000文字に制限
        echo $string."<br>"; // 取得した行を表示
        }

      flock($file, LOCK_UN);
      fclose($file);
      }
    ?>
    <button class="btn btn-default" onClick="window.close(); return false;">Close</button>
    </div><!-- /col-xs-12 col-md-12 -->
    

    </div><!-- /container -->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
