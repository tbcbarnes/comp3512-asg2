<?php
session_start();
require_once 'includes/helper.inc.php';
$help = new Helper();
$isLoggedIn = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $isLoggedIn = true;
}
$favourites;
if(isset($_SESSION['favourites']) && !empty($_SESSION['favourites'])) {
    $favourites = unserialize($_SESSION['favourites']);
}
if(isset($_POST['addimage']) && !empty($_POST['addimage'])) {
  $favourites->addFav($_POST['addimage'],"Images");
  $_SESSION['favourites'] = serialize($favourites);
}
if(isset($_POST['remimage']) && !empty($_POST['remimage'])) {
  $favourites->removeFav($_POST['remimage'],"Images");
  $_SESSION['favourites'] = serialize($favourites);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $record['CountryName']; ?></title>

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
    <main>
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <form action="favourites.php" method="POST">
              <div class="row">
                <h3 class="text-center">Favourite Images</h3>
              </div>
              <div class="row">
                <button class="btn btn-primary" type="submit">Remove Selected</button>
                <a class="btn btn-success" href="rfavourites.php?type=Images">Remove All</a>
              </div>
              <?php if(count($favourites->getImagesList()) > 0) {
                echo $help->genFavImages($favourites->getImagesList()); 
              }
              else {
                echo '<div class="row"><p>No favourites to display</p></div>';
              }
              ?>
            </form>
          </div>  
          <div class="col-sm-6">
            <form action="favourites.php" method="POST">
              <div class="row">
                <h3 class="text-center">Favourite Posts</h3>
              </div>
              <div class="row">
                <button class="btn btn-primary" type="submit">Remove Selected</button>
                <a class="btn btn-success" href="rfavourites.php?type=Posts">Remove All</a>
              </div>
              <?php if(count($favourites->getPostsList()) > 0) {
                echo $help->genFavPosts($favourites->getPostsList()); 
              }
              else {
                echo '<div class="row"><p>No favourites to display</p></div>';
              }
              ?>
            </form>
          </div>
        </div>
      </div>
    </main>
      <?php require_once 'includes/footer.inc.php'; ?>
</body>
</html>