<?php
/**
  * Constants defined for use by the web application. POPULARMODE changes
  * the sorting method of the left nav links on single-image.php
  * 
  */
define('DBHOST', 'localhost');
define('DBNAME', 'travel');
define('DBUSER', 'timbcbarnes');
define('DBPASS', '');
define('DBCONNSTRING','mysql:dbname='.DBNAME.';host='.DBHOST.';charset=utf8mb4;');
define('POPULARMODE', 'MOST');  # accepted values MOST or ALPHA
                                # empty string results in no sorting
?>