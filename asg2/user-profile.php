<?php
session_start();
require_once 'includes/helper.inc.php';
$help = new Helper();
$user;
$isLoggedIn = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $isLoggedIn = true;
    $userData = $user->getUserData();
}
else {
    $_SESSION['message'] = "redirect";
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ASG2 Winter18 COMP3512 by Tim Barnes</title>
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
    <main class="container">
        <div class="jumbotron">
            <h1 class="display-4">Hi <?php echo $userData['FirstName'].' '.$userData['LastName'];?></h1>
            <ul class="list-group">
              <li class="list-group-item">Address: <?php echo $user->getUserData()['Address'];?></li>
              <li class="list-group-item">City: <?php echo $user->getUserData()['City'];?></li>
              <li class="list-group-item">Region: <?php echo $user->getUserData()['Region'];?></li>
              <li class="list-group-item">Country: <?php echo $user->getUserData()['Country'];?></li>
              <li class="list-group-item">Postal: <?php echo $user->getUserData()['Postal'];?></li>
              <li class="list-group-item">Phone: <?php echo $user->getUserData()['Phone'];?></li>
              <li class="list-group-item">Email: <?php echo $user->getUserData()['Email'];?></li>
              <li class="list-group-item">Date Joined: <?php $dt = new DateTime($user->getDateJoined()); echo date_format($dt, 'j F Y');?></li>
            </ul>
        </div>
    </main>
      <?php require_once 'includes/footer.inc.php'; ?>
</body>
</html>