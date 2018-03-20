<?php
session_start();
require_once 'includes/helper.inc.php';
$message = "";
$alertType = "success";
$help = new Helper();
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    session_unset();
    session_destroy();
    $message = "Logout successful";
}
if(isset($_SESSION['message'])) {
    $message = "Please login to continue";
    unset($_SESSION['message']);
}
elseif(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $message = $help->processLogin($_POST['username'],$_POST['password']);
    $alertType = "danger";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
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
        <?php if($message) { echo '
        <div id="alert-message" class="alert alert-'.$alertType.'" role="alert">
            '.$message.'
        </div>';} ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="inputUser">Username</label>
                <input type="text" class="form-control" name="username" id="inputUser" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="inputPass">Password</label>
                <input type="password" class="form-control" name="password" id="inputPass" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
      <?php require_once 'includes/footer.inc.php'; ?>
</body>
</html>