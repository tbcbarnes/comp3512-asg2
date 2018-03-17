<?php
/**
 * Generates the lists based on a passed results object
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
    if(empty($output)) { $output="No results to display"; }
    return $output;
}

function genRatingList($ratingQueryResults) {
    $output = "";
    $ratings = array();
    while($row = $ratingQueryResults->fetch()) {
        array_push($ratings,$row['Rating']);
    }
    if(count($ratings) > 0) {
        $sum=0;
        for($i=0;$i<count($ratings);$i++) {
            $sum+=$ratings[$i];
        }
        $rating = round($sum / count($ratings));
        $numWhite = 5-$rating;
        for($i=0;$i<$rating;$i++) {
            $output.='<img src="images/misc/star-gold.svg" width="16" />';
        }
        for($i=0;$i<$numWhite;$i++) {
            $output.='<img src="images/misc/star-white.svg" width="16" />';
        }
        $output.='<br />Number of Ratings: '.count($ratings);
    }
    else {
        $output = "No rating information available";
    }
    return $output;
}

function genPostList($postListing) {
    $output="";
    while($row = $postListing->fetch()) {
        $output.='
        <div class="row">
            <div class="col-md-2">
                <a href="single-post.php?id='.$row['PostID'].'"><img src="images/square-medium/'.$row['Path'].'" alt="'.$row['Title'].'" class="img-responsive" /></a>
            </div>
            <div class="col-md-10">
                <h3>'.$row['Title'].'</h3>
                <div class="details">
                    Posted by <a href="single-user.php?id='.$row['UserID'].'">'.$row['FirstName'].' '.$row['LastName'].'</a>
                    <p class="excerpt">
                    ';
                    if(strlen($row['Message']) > 0) {
                        $output.=substr($row['Message'],0,100).'. . .';            
                    }
                    else {
                        $output.='No preview available';
                    }
                    $output.='</p>
                    <p class="pull-right"><a href="single-post.php?id='.$row['PostID'].'" class="btn btn-primary btn-sm">Read More</a></p>
                </div>
            </div>
        </div>
        <hr/>';
    }
    return $output;
}

function genPageination($curPage,$numPages) {
    $output="";
    if($curPage > 1) {
        $output.='<li class="page-item"><a class="page-link" href="browse-posts.php?page='.($curPage-1).'">Previous</a></li>';
    }
    for($i = 1; $i <= $numPages; $i++) {
        $output.='<li class="page-item"><a class="page-link" href="browse-posts.php?page='.($i).'">'.($i).'</a></li>';
    } 
    if($curPage < $numPages) {
        $output.='<li class="page-item"><a class="page-link" href="browse-posts.php?page='.($curPage+1).'">Next</a></li>';
    }
    return $output;
    
}