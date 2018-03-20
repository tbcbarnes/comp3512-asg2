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
  $record = $help->getPost($_GET['id'])[0];
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Single Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    
    <link rel="stylesheet" href="css/custom.css" /> 
    <link rel="stylesheet" href="css/custom.css" />
</head>

<body>
    <?php require_once 'includes/header.inc.php'; ?>
    <!-- Page Content -->
    <main class="container">
      <div class="jumbotron">
          <h1 class="display-4"><?php echo $record['Title']; ?></h1>
          <p><strong>Posted By</strong> <?php echo '<a href="single-user.php?id='.$record['UserID'].'">'.$record['FirstName']." ".$record['LastName'].'</a>'; ?></p>
          <p><strong>Post Date</strong> <?php $d = new DateTime($record['PostTime']); echo $d->format('l F jS\, Y'); ?></p>
          <p><?php echo $record['Message']; ?></p>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">Images from Post # <?php echo $record['PostID']; ?></div>
        <div class="panel-body">
          <ul class="caption-style-2">
            <?php
              echo $help->genImages($record['PostID']);
            ?>
          </ul>
        </div>
      </div>
    </main>
      <?php include 'includes/footer.inc.php'; ?>
</body>
</html>