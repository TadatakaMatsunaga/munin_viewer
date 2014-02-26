    <?php
      $path = 'text/';
      $latest_mtime = 0;
      $file_list = array();
      if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
          if ($file != "." && $file != ".." && strstr($file, ".txt") ){
            $fname = $path.$file;
            $mtime = filemtime( $fname );
            // 
            $file_list += array($file => date( "Y/n/d H:i" , $mtime ));
            }
          $result = arsort($file_list, SORT_STRING);
          }
        closedir($handle);  
      }
    ?>

    <div class="container">
      <div class="highlight">
      <p>最新更新履歴</p>
      <?php
        foreach($file_list as $key=>$val){
          $file_url = $path.$key;
          $key = str_replace(".txt", "", $key);
          $key = str_replace("if_bond0", "if-bond0", $key); //if_bond0対応
          $str = explode("_", $key);
          $str = str_replace("if-bond0", "if_bond0", $str); //if_bond0対応

          if(file_exists($file_url)){
            $handle = fopen($file_url,"r") or die("OPENエラー $file_url");
            flock($handle, LOCK_EX);

            while (!feof($handle)) {  // ファイルポインタがファイル終端に達しているかどうか調べ、達するまで以下の処理をする
              $string = fgets($handle, 300);  // ファイルから行を取得、１行1000文字に制限
              if($string){
                $last_comment = $string;
              }
              //echo $string."<br>"; // 取得した行を表示
            }
            flock($handle, LOCK_UN);
            fclose($handle);
          }

          echo "<a href=\"detail.php?svn=$str[0]&checkbox=$str[1]&term=$str[2]\"  target=\"_blank\">";
          echo $str[0]." ".$str[1].": ".$last_comment."</a><br>";
        }
      ?>
      </div>
    </div>