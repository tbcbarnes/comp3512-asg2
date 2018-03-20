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
$image;
if(isset($_GET['id'])) {
  $image = $help->getImage($_GET['id']);
  if(!$image) {
    header("Location: error.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $image['Title']; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/custom.css" /> 

</head>

<body>
    <?php require 'includes/header.inc.php'; ?>

    <!-- Page Content -->
    <main class="container">
        <div class="row">
            <?php require_once 'includes/left.inc.php'; ?>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8">                                                
                        <img class="img-responsive" src="images/medium/<?php echo $image['Path']; ?>" alt="<?php echo $image['Title']; ?>">
                        <h3><?php echo $image['Title']; ?></h3>
                        <p><?php echo $image['Description']; ?></p>
                    </div>
                    <div class="col-md-4">                                                
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <ul class="details-list">
                                    <li>By: <a href="single-user.php?id=<?php echo $image['UserID']; ?>"><?php echo $image['FirstName'].' '.$image['LastName']; ?></a></li>
                                    <li>Country: <a href="single-country.php?id=<?php echo $image['CountryCodeISO']; ?>"><?php echo $image['CountryName']; ?></a></li>
                                    <li>City: <a href="single-city.php?id=<?php echo $image['CityCode']; ?>"><?php echo $image['AsciiName']; ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p class="ratings">Rating: 
                                <?php 
                                echo $help->genRatingList($image['ImageID']);
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <form action="favourites.php" method="POST">
                                    <input type="hidden" name="addimage" value="<?php echo $image['ImageID']; ?>">
                                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></button>
                                </form>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-save" aria-hidden="true"></span></button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
                            </div>
                        </div>
                        <div id="map">
                            
                        </div>
                    </div>  <!-- end right-info column -->
                </div>  <!-- end row -->
            </div>  <!-- end main content area -->
        </div>
    </main>
    
        <?php require_once 'includes/footer.inc.php'; ?>
        <?php 
        echo '<script>
          function initMap() {

            var uluru = {lat: '.$image['Latitude'].', lng: '.$image['Longitude'].'};
            var map = new google.maps.Map(document.getElementById("map"), {
              zoom: 15,
              center: uluru
            });
            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });
          }
        </script>';
        ?>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHBxl8YGvX84eVXAV8xqrsi8sCBmty83A&callback=initMap"></script>
</body>
</html>