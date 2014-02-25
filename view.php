<!DOCTYPE html>

<html lang="ja">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Munin Viewer -view</title>

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

    <?php
    if(isset($_POST['Submit'])) {
      if(empty($_POST['chk'])){
        echo '<div id="flashMessage" class="container">';
        echo '<div class="alert alert-danger">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<strong>少なくとも１つは選択してください！</strong>';
        echo '</div></div>';
      }
    }
    ?>

    
    <p>
    <div class="container">
    <div class="highlight">
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-inline">               
        <label class="checkbox">
          <input type="checkbox" name="chk[]" value="cpu"> CPU usage</label>
        <label class="checkbox">
          <input type="checkbox" name="chk[]" value="load"> Load average</label>
        <label class="checkbox">
          <input type="checkbox" name="chk[]" value="memory"> Memory usage</label>
        <label class="checkbox">
          <input type="checkbox" name="chk[]" value="df"> Disk usage in percent</label>
        <label class="checkbox">
          <input type="checkbox" name="chk[]" value="if_bond0"> bond0 traffic</label>
        <!--radio -->
        <span class="help-block">
          <label class="radio">
            <input type="radio" name="r_term" value="month" checked="checked"/> month
          </label>
          <label class="radio">
            <input type="radio" name="r_term" value="year" /> year
          </label>
        </span>
        <!--button-->
        <span class="help-block">
          <button type="submit" name="Submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span> view</button>
        </span>
      </form>
    </div>
    </div>

    <p>

    <div class="container">
      <?php

        $svn = explode(",",$servers);

        if(isset($_POST['Submit'])) {
          if(!empty($_POST['chk'])){
            $checkbox = $_POST['chk'];
            $term = $_POST['r_term'];

            for($j=0; $j<sizeof($checkbox); $j++){

              echo '<div class="row">';

              echo "<div class=\"alert alert-info\"><strong>$checkbox[$j]</strong></div>";

              for($i=0; $i<sizeof($svn); $i++){

                $urlPic = "http://".$muninServer."/cgi-bin/munin-cgi-graph/".$svn[$i]."/".$svn[$i]."/".$checkbox[$j]."-".$term.".png";

                echo '<div class="col-xs-6 col-md-4">';
                echo "<a href=\"detail.php?svn=$svn[$i]&checkbox=$checkbox[$j]&term=$term\"  target=\"_blank\" class=\"thumbnail\">";
                echo "$svn[$i]";

                echo "<img src=\"$urlPic\" alt=\"...\">";

                // メモフラグ
                $file_name = $svn[$i]."_".$checkbox[$j]."_".$term.".txt";
                $file_url = "./text/".$file_name;
                if(file_exists($file_url)){
                  echo "<div class=\"text-right\"><span class=\"glyphicon glyphicon-tag\"></span>".date("n/j", filemtime($file_url))."</div>";
                }else{

                  echo "<BR>";
                }

                

                echo '</a>';
                echo "</div>";
              }
              echo '</div>';
            }   
          }           
        }
      ?>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->


    <script>
      $(function(){
        setTimeout(function() {
          $('#flashMessage').fadeOut("slow");
        }, 800);
      });
    </script>

  </body>
</html>
