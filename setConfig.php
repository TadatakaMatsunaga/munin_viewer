    <?php
      $file_name = "config.json";
      $file_url = "./text/".$file_name;
      $servers = "";
      $muninServer = "";

      if(!empty($_POST["muninServer"])&&!empty($_POST["servers"])){
        $file = fopen($file_url, "wb") or die("OPENエラー $file_url");

        $muninServer = $_POST["muninServer"];
        $servers = $_POST["servers"];

        $servers = str_replace(" ", "", $servers);
        $servers = trim($servers);

        $data = array(
          "muninServer" => $muninServer,
          "servers" => $servers,
          );

        flock($file, LOCK_EX);
        fwrite($file, json_encode($data));
        flock($file, LOCK_UN);
        fclose($file);

      }elseif(!isset($_POST["submit"])){

        $file = fopen($file_url, "r") or die("OPENエラー $file_url");

        flock($file, LOCK_EX);
        while (!feof($file)){
          $json = fgets($file, 1000);
        }
        
        $data = json_decode($json, true);

        //var_dump($data);
        $muninServer = $data['muninServer'];
        $servers = $data['servers'];

        flock($file, LOCK_UN);
        fclose($file);      

      };


    ?>