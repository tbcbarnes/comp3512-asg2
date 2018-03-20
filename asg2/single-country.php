<?php
session_start();
require_once 'includes/helper.inc.php';
$help = new Helper();
$isLoggedIn = false;
if(isset($_SESSION['favourites']) && !empty($_SESSION['favourites'])) {
    $favourites = unserialize($_SESSION['favourites']);
}
$record;
if(isset($_GET['id'])) {
  $record = $help->getCountry($_GET['id'])[0];
}
$imgResults = $help->getImageResults($record['ISO']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $record['CountryName']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    
    <link rel="stylesheet" href="css/custom.css" /> 
</head>

<body>
    <?php require_once 'includes/header.inc.php'; ?>
    <!-- Page Content -->
    <main>
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <h1 class="display-4"><?php echo $record['CountryName']; ?></h1>
            <p>Capital: <?php echo '<strong>'.$record['Capital'].'</strong>'; ?></p>
            <p>Area: <?php echo '<strong>'.number_format($record['Area']).'</strong> sq km.'; ?></p>
            <p>Population: <?php echo '<strong>'.number_format($record['Population']).'</strong>'; ?></p>
            <p>Currency Name: <?php echo '<strong>'.$record['CurrencyName'].'</strong>'; ?></p>
            <p><?php if(empty($record['CountryDescription'])) { echo "No description available."; } else { echo $record['CountryDescription']; } ?></p>
            <img
              width="350px"
              height="350px"
              style="border:0;margin:10px"
              <?php echo 'src="https://maps.googleapis.com/maps/api/staticmap?center='.$record['CountryName'].'&size=350x350&maptype=hybrid';
                foreach($imageResults as $row) {
                  echo '&markers=color:blue%7C'.$row['Latitude'].','.$row['Longitude'];
                }
                echo '&key=AIzaSyDdgI8seaGHlV-OD2VsLXtJ_XixvS3VxTA"';
                ?> >
          </div>  
          <div class="col-sm-8">
            <div class="panel panel-success">
              <div class="panel-heading">Images from <?php echo $record['CountryName']; ?></div>
              <div class="panel-body">
                <ul class="caption-style-2">
                  <?php
                    echo $help->genImagesCountry($record["ISO"]);
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
      <?php require_once 'includes/footer.inc.php'; ?>
</body>
</html>