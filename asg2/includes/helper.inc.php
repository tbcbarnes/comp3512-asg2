<?php
/**
 * Generates the image list based on a passed results object
 * from a SQL Query.
 * 
 */
function genImageList($queryResultsObj) {
    $output = "";
    while($row = $queryResultsObj->fetch()) {
        $output .= '
        <li>
            <a href="single-image.php?id='.$row['ImageID'].'" class="img-responsive">
                <img src="images/square-medium/'.$row['Path'].'" alt="'.$row['Title'].'">
                <div class="caption">
                    <div class="blur"></div>
                    <div class="caption-text">
                        <p>'.$row['Title'].'</p>
                    </div>
                </div>
            </a>
        </li>';
    }
    return $output;
}