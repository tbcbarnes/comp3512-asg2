<?php
require 'includes/dbconn.inc.php';
require 'includes/helper.inc.php';
if(!isset($pdoClass)) {
  try {
      $pdoClass = new db_functions();
  }
  catch(Exception $e) {
    die($e->getMessage());
  }
}
if(isset($_GET['id'])) {
  $result = $pdoClass->exSelect("*","Posts AS a JOIN Users AS b ON a.UserID=b.UserID","WHERE a.PostID=?",array($_GET['id']));
  $record = $result->fetch();
  if(!$record) {
    header("Location: error.php");
  }
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
              $imgResults = $pdoClass->exSelect("*","ImageDetails",'WHERE ImageID IN(SELECT ImageID FROM PostImages WHERE PostID=?)',array($record['PostID']));
              echo genImageList($imgResults);
            ?>
          </ul>
        </div>
      </div>     
      
    </main>
    
    <footer>
      <?php include 'includes/footer.inc.php'; ?>
    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>