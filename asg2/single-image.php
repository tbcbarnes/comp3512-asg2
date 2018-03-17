<?php
require_once 'includes/dbconn.inc.php';
require_once 'includes/helper.inc.php';
if(!isset($pdoClass)) {
  try {
      $pdoClass = new db_functions();
  }
  catch(Exception $e) {
    die($e->getMessage());
  }
}
if(isset($_GET['id'])) {
  $result = $pdoClass->exSelect("*","ImageDetails as a JOIN Users as b ON a.UserID=b.UserID JOIN Countries ON CountryCodeISO=ISO JOIN Cities as c ON a.CityCode=c.CityCode","WHERE ImageID=?",array($_GET['id']));
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
    <title><?php echo $record['Title']; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/custom.css" /> 

</head>

<body>
    <?php require 'includes/header.inc.php'; ?>

    <!-- Page Content -->
    <main class="container">
        <div class="row">
            <?php require 'includes/left.inc.php'; ?>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8">                                                
                        <img class="img-responsive" src="images/medium/<?php echo $record['Path']; ?>" alt="<?php echo $record['Title']; ?>">
                        <p class="description"><?php echo $record['Title']; ?></p>
                    </div>
                    <div class="col-md-4">                                                
                        <h2><?php echo $record['Title']; ?></h2>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <ul class="details-list">
                                    <li>By: <a href="single-user.php?id=<?php echo $record['UserID']; ?>"><?php echo $record['FirstName'].' '.$record['LastName']; ?></a></li>
                                    <li>Country: <a href="single-country.php?id=<?php echo $record['CountryCodeISO']; ?>"><?php echo $record['CountryName']; ?></a></li>
                                    <li>City: <?php echo $record['AsciiName']; ?></a></li>
                                </ul>
                            </div>
                        </div>
    
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></button>
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
                    </div>  <!-- end right-info column -->
                </div>  <!-- end row -->
            </div>  <!-- end main content area -->
        </div>
    </main>
    
    <footer>
        <?php require 'includes/footer.inc.php'; ?>
    </footer>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>