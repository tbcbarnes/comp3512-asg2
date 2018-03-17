<?php
require 'includes/dbconn.inc.php';
if(!isset($pdoClass)) {
  try {
      $pdoClass = new db_functions();
  }
  catch(Exception $e) {
    die($e->getMessage());
  }
}
$result = $pdoClass->exSelect("COUNT(ISO) as NumISO,CountryName,CountryCodeISO","Countries JOIN ImageDetails ON CountryCodeISO=ISO","GROUP BY CountryCodeISO ORDER BY CountryName ASC","");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Browse Countries</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php require 'includes/header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
      <div class="panel panel-success">
        <div class="panel-heading">Countries with Images</div>
        <div class="panel-body">
          <?php
              $counter = 1;
              while($row = $result->fetch()) {
                if($counter % 4 == 0) {
                  echo '<div class="row">';
                } 
                echo '<div class="col-md-3"><a href="single-country.php?id='.$row['CountryCodeISO'].'">'.$row['CountryName'].'</a></div>';
                 if($counter % 4 == 0 && $counter != 0) {
                  echo '</div>';
                }
                $counter++;
              }
          ?>
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