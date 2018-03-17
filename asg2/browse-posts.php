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
// For some reason - maybe because I enjoy it... who knows - I went ahead
// and implemented Boostrap's pageination here. What a pain in the @rse.

$limit="";
$pageNum=1;
if(isset($_GET['page']) && !empty($_GET['page']) && intval($_GET['page']) > 1) {
  $pageNum=$_GET['page'];
  $limitPosts = intval($_GET['page'])*10;
  $limitPostsStart = $limitPosts - 9;
  $limit = "LIMIT $limitPostsStart,10";
}
else { $limit = "LIMIT 10"; }
$rando = $pdoClass->exSelect('COUNT(PostID) as NumPost',"Posts","","");
$rando2 = $rando->fetch();
$postCount = $rando2['NumPost'];
$totPages = intval($postCount / 10);
// IF TROUBLESHOOTING display problems, remove $limit from the SQL statement near the end... pageination still appears but it won't affect the query
$results = $pdoClass->exSelect("*","Posts AS a JOIN Users AS b ON a.UserID=b.UserID JOIN ImageDetails AS c ON a.MainPostImage=c.ImageID","ORDER BY a.PostTime DESC $limit","");
if($pageNum > $totPages) {
  header("location: error.php");
}
echo $limit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Browse Users</title>

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
    <main class="container">
        <div class="row">
          <?php require 'includes/left.inc.php'; ?>
          <div class="col-md-10">
            <div class="jumbotron">
                  <h1>Recent Posts</h1>
            </div>
            <div class="postlist">
              <?php 
                echo genPostList($results); 
              ?>
            </div>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <?php echo genPageination($pageNum,$totPages); ?>
              </ul>
            </nav>
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