<?php
session_start();
require_once 'includes/helper.inc.php';
$help = new Helper();
$isLoggedIn = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $isLoggedIn = true;
}
$filters = ["searchQuery" => "",
            "continent" => "",
            "country" => "",
            "city" => "",
            "title" => ""];

if(isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
  $filters['searchQuery'] = $_GET['searchQuery'];
}
if(isset($_GET['continent']) && !empty($_GET['continent']) && $_GET['continent'] != "0") {
  $filters['continent'] = $_GET['continent'];
}
if(isset($_GET['country']) && !empty($_GET['country']) && $_GET['country'] != "0") {
  $filters['country'] = $_GET['country'];
}
if(isset($_GET['city']) && !empty($_GET['city']) && $_GET['city'] != "0") {
  $filters['city'] = $_GET['city'];
}
if(isset($_GET['title']) && !empty($_GET['title']) && $_GET['title'] != "0") {
  $filters['title'] = $_GET['title'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Browse Images</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php require 'includes/header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
      <div class="panel panel-default">
        <div class="panel-heading">Filters</div>
        <div class="panel-body">
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="get" class="form-horizontal">
            <div class="form-inline">
            <select name="continent" class="form-control">
              <option value="0">Select Continent</option>
              <?php 
                echo $help->genContinentSelect();
              ?>
            </select>     
            
            <select name="country" class="form-control">
              <option value="0">Select Country</option>
              <?php 
                echo $help->genCountrySelect();
              ?>
            </select>
            
            <select name="city" class="form-control">
              <option value="0">Select City</option>
              <?php 
                echo $help->genCitySelect();
              ?>
            </select> 
            <input type="text"  placeholder="Search title" class="form-control" name=title<?php if($v3) {echo ' value="'.$_GET['title'].'"';}?> >
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php foreach($filters as $filter) {
                    if($filter) {
                      echo '<a href="browse-images.php" class="btn btn-success">Clear</a>';
                      break;
                    }
                  } ?>
            </div>
          </form>

        </div>
      </div>     
      <div class="panel panel-default">                                  
            <?php echo $help->genImageList($filters); ?>
      </div>
    </main>
      <?php require_once 'includes/footer.inc.php'; ?>
</body>

</html>