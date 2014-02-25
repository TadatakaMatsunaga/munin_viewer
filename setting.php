<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Munin Viewer -setting</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">

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
    <!--checked server setting-->
    <div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" role="well">
    <div class="form-group">
      <label for="muninServer">Munin Sever</label>
      <input type="text" class="form-control" id="muninServer" name="muninServer" value="<?php echo $muninServer ?>">
    </div>
    <div class="form-group">
      <label for="servers">Checked Sever ※カンマ区切り</label>
      <textarea class="form-control" rows="8" id="servers" name="servers"><?php echo $servers ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
