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
$v1 = isset($_GET['continent']) && !empty($_GET['continent']) && $_GET['continent'] != "0";
$v2 = isset($_GET['country']) && !empty($_GET['country']) && $_GET['country'] != "0";
$v3 = isset($_GET['title']) && !empty($_GET['title']) && $_GET['title'] != "0";
$v4 = isset($_GET['city']) && !empty($_GET['city']) && $_GET['city'] != "0";
$searchString = "";
if($v1) {
  $searchString .= "Continent".'='.$_GET['continent'];
}
else {
  $searchString .= 'Continent=ALL';
}
if($v2) {
  $searchString .= ", Country".'='.$_GET['country'];
}
else {
  $searchString .= ', Country=ALL';
}
if($v3) {
  $searchString .= ', Title contains "'.$_GET['title'].'"';
}
else {
  $searchString .= ', ALL Titles';
}
$result = $pdoClass->exSelect("AsciiName","Cities","WHERE CityCode='" . $_GET['city'] . "'","");
if($v4 && $result) {
  $cityMatch = $result->fetch();
  $searchString .= ", City".'='.$cityMatch['AsciiName'];
}
else {
  $searchString .= ', City=ALL';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Browse Images</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
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
                $result = $pdoClass->exSelect("ContinentCode,ContinentName","Continents","ORDER BY ContinentName ASC","");
                while($row = $result->fetch()) {
                  $output = '<option value='.$row['ContinentCode'];
                  if($v1 && $row['ContinentCode'] == $_GET['continent']) { $output.= ' selected';}
                  $output .= '>'.$row['ContinentName'].'</option>';
                  echo $output;
                }
                
              ?>
            </select>     
            
            <select name="country" class="form-control">
              <option value="0">Select Country</option>
              <?php 
                $result = $pdoClass->exSelect("COUNT(ISO) as NumISO,CountryName,CountryCodeISO","Countries JOIN ImageDetails ON CountryCodeISO=ISO","GROUP BY CountryCodeISO ORDER BY CountryName ASC","");
                if($result) {
                  while($row = $result->fetch()) {
                    $output = '<option value='.$row['CountryCodeISO'];
                    if($v2 && $row['CountryCodeISO'] == $_GET['country']) { $output.= ' selected';}
                    $output .= '>'.$row['CountryName'].'</option>';
                    echo $output;
                  }
                }
                else {
                  $error = true;
                }
              ?>
            </select>
            
            <select name="city" class="form-control">
              <option value="0">Select City</option>
              <?php 
                $result = $pdoClass->exSelect("COUNT(a.CityCode) as NumCity,AsciiName,a.CityCode as CCode","Cities as a JOIN ImageDetails as b ON a.CityCode=b.CityCode","GROUP BY a.CityCode ORDER BY AsciiName ASC","");
                if($result) {
                  while($row = $result->fetch()) {
                    $output = '<option value='.$row['CCode'];
                    if($v4 && $row['CCode'] == $_GET['city']) { $output.= ' selected';}
                    $output .= '>'.$row['AsciiName'].'</option>';
                    echo $output;
                  }
                }
                else {
                  $error = true;
                }
              ?>
            </select> 
            <input type="text"  placeholder="Search title" class="form-control" name=title<?php if($v3) {echo ' value="'.$_GET['title'].'"';}?> >
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if($v1 || $v2 || $v3 || $v4) {
              echo '<a href="browse-images.php" class="btn btn-success">Clear</a>';
            } ?>
            </div>
          </form>

        </div>
      </div>     
      <div class="panel panel-default">                                  
        <div class="panel-heading">Images &#91;<?php echo $searchString; ?>&#93;</div>
        <div class="panel-body">
        	<ul class="center-block caption-style-2">
            <?php /* display list of images ... sample below ... replace ???? with field data */
              $params = "";
              if($v1 || $v2 || $v3 || $v4) {
                $params .= 'WHERE';
                if($v1) {
                $params .= ' ContinentCode = "'.$_GET['continent'].'"';
                }
                if($v2) {
                  if($v1) {$params.=" AND";}
                  $params .= ' CountryCodeISO = "'.$_GET['country'].'"';
                } 
                if($v3) {
                  if($v1 || $v2) {$params.=" AND";}
                  $params .= ' Title LIKE "%'.$_GET['title'].'%"';
                }
                if($v4) {
                  if($v1 || $v2 || $v3) {$params .=" AND";}
                  $params .= ' CityCode = "'.$_GET['city'].'"';
                }
              }
              $result = $pdoClass->exSelect("ImageID,Path,Title","ImageDetails",$params,"");
              echo genImageList($result);
             ?>
          </ul>
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