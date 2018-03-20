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
if(isset($_GET['id'])) {
  $record = $help->getCity($_GET['id'])[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $record['AsciiName']; ?></title>
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
    <main>
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <h1 class="display-4"><?php echo $record['AsciiName']; ?></h1>
            <p>Country: <?php echo '<strong>'.$record['CountryName'].'</strong>'; ?></p>
            <p>Population: <?php echo '<strong>'.number_format($record['Population']).'</strong>'; ?></p>
            <p></p>Elevation: <?php echo '<strong>'.$record['Elevation'].' metres</strong>'; ?></p>
            <p>Timezone: <?php echo '<strong>'.$record['TimeZone'].'</strong>'; ?></p>
            <img
              width="350px"
              height="350px"
              style="border:0;margin:10px"
              <?php echo 'src="https://maps.googleapis.com/maps/api/staticmap?zoom=3&size=350x350&maptype=roadmap';
                echo '&markers=color:blue%7C'.$record['Latitude'].','.$record['Longitude'];
                echo '&key=AIzaSyDdgI8seaGHlV-OD2VsLXtJ_XixvS3VxTA"';
                ?> >
          </div>  
          <div class="col-sm-8">
            <div class="panel panel-success">
              <div class="panel-heading">Images from <?php echo $record['AsciiName']; ?></div>
              <div class="panel-body">
                <ul class="caption-style-2">
                  <?php
                    echo $help->genImagesCity($record['CityCode']);
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