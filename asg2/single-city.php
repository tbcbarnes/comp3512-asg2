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
  $result = $pdoClass->exSelect("a.*,b.CountryName","Cities as a JOIN Countries as b ON a.CountryCodeISO=b.ISO","WHERE a.CityCode=?",array($_GET['id']));
  $record = $result->fetch();
  if(!$record) {
    header("Location: error.php");
  }
}
$imgResults = $pdoClass->exSelect("*","ImageDetails","WHERE CityCode = ?",array($_GET['id']));
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
    <?php require 'includes/header.inc.php'; ?>
    


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
                    echo genImageList($imgResults);
                  ?>
                </ul>
              </div>
            </div>
          </div>
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