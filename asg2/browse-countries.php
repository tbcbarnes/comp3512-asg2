<?php
session_start();
require_once 'includes/helper.inc.php';
$help = new Helper();
$isLoggedIn = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $isLoggedIn = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Browse Countries</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/custom.css" />
</head>
<body>
    <?php require_once 'includes/header.inc.php'; ?>
    <!-- Page Content -->
    <main class="container">
      <div class="panel panel-success">
        <div class="panel-heading">Countries with Images</div>
        <div class="panel-body">
          <?php
              echo $help->genCountryList();
          ?>
        </div>
      </div>     
    </main>
      <?php require_once 'includes/footer.inc.php'; ?>
</body>

</html>