<?php
session_start();
require_once 'includes/helper.inc.php';
$help = new Helper();
$isLoggedIn = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $isLoggedIn = true;
}
$record;
if(isset($_GET['id'])) {
  $record = $help->getUser($_GET['id'])[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $record['LastName'].', '.$record['FirstName']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    
    <link rel="stylesheet" href="css/custom.css" /> 

</head>

<body>
    <?php require 'includes/header.inc.php'; ?>
    <!-- Page Content -->
    <main class="container">
      <div class="jumbotron">
          <h1 class="display-4"><?php echo $record['FirstName'].' '.$record['LastName']; ?></h1>
          <p><?php echo $record['Address']; ?></p>
          <p><?php echo $record['City'].', '.$record['Postal'].', '.$record['Country']; ?></p>
          <p><?php echo $record['Phone']; ?></p>
          <p><?php echo $record['Email']; ?></p>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">Images from <?php echo $record['FirstName']. ' '.$record['LastName']; ?></div>
        <div class="panel-body">
          <ul class="caption-style-2">
            <?php
              echo $help->genImagesUser($record['UserID']);
            ?>
          </ul>
        </div>
      </div>     
    </main>
      <?php include 'includes/footer.inc.php'; ?>
</body>
</html>