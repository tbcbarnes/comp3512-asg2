<?php
session_start();
require_once 'includes/helper.inc.php';
$favourites;
if(isset($_SESSION['favourites']) && !empty($_SESSION['favourites'])) {
    $favourites = unserialize($_SESSION['favourites']);
    if($_GET['type'] == "Posts") {
      $favourites->purgePosts();
    }
    elseif($_GET['type'] == "Images") {
      $favourites->purgeImages();
      $_SESSION['favourites'] = serialize($favourites);
    }
    header("Location: favourites.php");
}
else {
  header("Location: favourites.php");
}
?>
