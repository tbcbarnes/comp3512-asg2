<?php 
$orderBy = "";
if(POPULARMODE == "MOST") {
    $orderBy = " ORDER BY NumISO DESC";
}
elseif(POPULARMODE == "ALPHA") {
    $orderBy = " ORDER BY CountryName ASC";
}
?>
<aside class="col-md-2">
                <div class="panel panel-info">
                    <div class="panel-heading">Continents</div>
                    <ul class="list-group">
                        <?php
                        $result = $pdoClass->exSelect("*","Continents","ORDER BY ContinentName ASC","");
                        while($row = $result->fetch()) {
                            echo '<li class="list-group-item"><a href="browse-images.php?continent='.$row['ContinentCode'].'">'.$row['ContinentName'].'</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <!-- end continents panel -->
                <!-- choose sorting method by switching constant POPULARMODE in includes/db_constants.inc.php -->
                <div class="panel panel-info">
                    <div class="panel-heading">Popular</div>
                    <ul class="list-group">
                        <?php                         
                        $result = $pdoClass->exSelect("COUNT(ISO) as NumISO,CountryName,CountryCodeISO","Countries JOIN ImageDetails ON CountryCodeISO=ISO","GROUP BY CountryCodeISO".$orderBy,"");
                        while($row = $result->fetch()) {
                            echo '<li class="list-group-item"><a href="browse-images.php?country='.$row['CountryCodeISO'].'">'.$row['CountryName'].'</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <!-- end continents panel -->
            </aside>
