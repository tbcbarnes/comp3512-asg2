<?php
/**
 * Presentation Layer. Builds lists and markup.
 * Acts as gatekeeper for Data Access requests.
 */
require_once 'db.class.php';
require_once 'user.class.php';
require_once 'favourites.class.php';

class Helper {
    
    private static $pdo;
    
    public function __construct() {
        try {
            self::$pdo = new DataAccess();
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
        if(!isset($_SESSION['favourites']) || empty($_SESSION['favourites'])) {
            $_SESSION['favourites'] = serialize(new Favourites());
        }
    }
    
    public function processLogin($userIn,$passIn) {
        $user = self::$pdo->getByID("UsersLogin","UserName",$userIn);
        $returnMessage = "";
        if(!empty($user)) {
            $credentials = md5($passIn.$user['Salt']);
            if($credentials === $user['Password']) {
                $uData = self::$pdo->getByID("Users","UserID",$user['UserID']);
                $_SESSION['user'] = serialize(new User($user,$uData));
                $returnMessage = "Login successfull";
                header("Location: user-profile.php");
            }
            else {
                $returnMessage = "Incorrect password";
            }
        }
        else {
            $returnMessage = "User not found";
        }
        return $returnMessage;
    }
    
    public function getImage($id) {
        return self::$pdo->getByID("ImageDetails as a JOIN Users as b ON a.UserID=b.UserID JOIN Countries ON CountryCodeISO=ISO JOIN Cities as c ON a.CityCode=c.CityCode","ImageID",$id);
    }
    
    public function genFavPosts($postArray) {
        $output = '
            <div class="row">
                <div class="col-sm-2">
                    Delete
                </div>
                <div class="col-sm-3">
                    Image
                </div>
                <div class="col-sm-7">
                    Title
                </div>
            </div><hr>';
        $rowNum = 1;
        foreach($postArray as $post) {
            $record = self::$pdo->getByID("Posts","PostID",$post);
            $imgRecord = self::$pdo->getByID("ImageDetails","ImageID",$record['MainPostImage']);
            $output .= '
            <div class="row">
                <div class="form-check">
                    <div class="col-sm-2">
                        <input type="checkbox" class="form-check-input" id="check'.$rowNum.'" name="removePosts" value="'.$post.'">
                    </div>
                    <div class="col-sm-3">
                        <a href="single-image.php?id='.$imgRecord['ImageID'].'"><img src="images/square-small/'.$imgRecord['Path'].'"></a>
                    </div> 
                    <div class="col-sm-7">
                        <a href="single-post.php?id='.$post.'">'.$record['Title'].'</a>
                    </div>
                </div>
            </div><hr>';
            $rowNum++;
        }
        return $output;
    }
    
    public function genFavImages($imageArray) {
        $output = '
            <div class="row">
                <div class="col-sm-2">
                    Delete
                </div>
                <div class="col-sm-3">
                    Image
                </div>
                <div class="col-sm-7">
                    Title
                </div>
            </div><hr>';
        $rowNum = 1;
        foreach($imageArray as $image) {
            $record = self::$pdo->getByID("ImageDetails","ImageID",$image);
            $output .= '
            <div class="row">
                <div class="form-check">
                    <div class="col-sm-2">
                        <input type="checkbox" class="form-check-input" id="check'.$rowNum.'" name="remimage" value="'.$image.'">
                    </div>
                    <div class="col-sm-3">
                        <a href="single-image.php?id='.$record['ImageID'].'"><img src="images/square-small/'.$record['Path'].'"></a>
                    </div> 
                    <div class="col-sm-7">
                        <a href="single-image.php?id='.$image.'">'.$record['Title'].'</a>
                    </div>
                </div>
            </div><hr>';
            $rowNum++;
        }
        return $output;
    }
    
    public function genImagesUser($id) {
        $result = self::$pdo->exSelect("*","ImageDetails",'WHERE UserID=?',array($id));
        $output;
        foreach($result as $row) {
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
        if(empty($output)) { $output .= "No results to display"; }
        $output .= '</ul>
        </div>';
        return $output;
    }
    
    public function genImagesCity($id) {
        $result = self::$pdo->exSelect("*","ImageDetails","WHERE CityCode = ?",array($id));
        $output;
        foreach($result as $row) {
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
        if(empty($output)) { $output .= "No results to display"; }
        $output .= '</ul>
        </div>';
        return $output;
    }
    
    public function genImagesCountry($id) {
        $result = self::$pdo->exSelect("*","ImageDetails","WHERE CountryCodeISO = ?",array($id));
        $output;
        foreach($result as $row) {
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
        if(empty($output)) { $output .= "No results to display"; }
        $output .= '</ul>
        </div>';
        return $output;
    }
    
    public function genImageList($filters) {
        $params = "";
        $result;
        $searchString = "";
        if(!empty($filters['searchQuery'])) {
            $result = self::$pdo->exSelect("ImageID,Path,Title","ImageDetails",'WHERE Title LIKE "%'.$filters['searchQuery'].'%" OR Description LIKE "%'.$filters['searchQuery'].'%"',"");
            $searchString = "Showing results for search: ".$filters['searchQuery'];
        }
        elseif(!empty($filters['continent']) || !empty($filters['country']) || !empty($filters['city']) || !empty($filters['title'])) {
                $params .= 'WHERE';
                if(!empty($filters['continent'])) {
                    $params .= ' ContinentCode = "'.$filters['continent'].'"';
                    $continent = self::$pdo->getByID("Continents","ContinentCode",$filters['continent']);
                    $searchString .= 'Continent = '.$continent['ContinentName'];
                }
                else { $searchString .= 'Continent = ALL'; }
                if(!empty($filters['country'])) {
                    if(!empty($filters['continent'])) {$params.=" AND";}
                    $params .= ' CountryCodeISO = "'.$filters['country'].'"';
                    $country = self::$pdo->getByID("Countries","ISO",$filters['country']);
                    $searchString .= ', Country = '.$country['CountryName'];
                }
                else { $searchString .= ", Country = ALL"; }
                if(!empty($filters['city'])) {
                    if(!empty($filters['continent']) || !empty($filters['country'])) {$params.=" AND";}
                    $params .= ' CityCode = "'.$filters['city'].'"';
                    $city = self::$pdo->getByID("Cities","CityCode",$filters['city']);
                    $searchString .= ', City = '.$city['AsciiName'];
                }
                else { $searchString .= ', City = ALL'; }
                if(!empty($filters['title'])) {
                    if(!empty($filters['continent']) || !empty($filters['country']) || !empty($filters['city'])) {$params .=" AND";}
                    $params .= ' Title LIKE "%'.$filters['title'].'%"';
                    $searchString .= ', Title = '.$filters['title'];
                }
                else { $searchString .= ', Title = ALL'; }
            $result = self::$pdo->exSelect("ImageID,Path,Title","ImageDetails",$params,"");
        }
        else {
            $result = self::$pdo->exSelect("ImageID,Path,Title","ImageDetails","","");
            $searchString = "Showing ALL Images";
        }
        $output = '
        <div class="panel-heading">Images &#91;'.$searchString.'&#93;</div>
            <div class="panel-body">
        	    <ul class="center-block caption-style-2">';
        foreach($result as $row) {
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
        if(empty($output)) { $output .= "No results to display"; }
        $output .= '</ul>
        </div>';
        return $output;
    }
    
    public function genContinents() {
        $result = self::$pdo->exSelect("*","Continents","ORDER BY ContinentName ASC","");
        $output;
        foreach($result as $row) {
            $output .= '<li class="list-group-item"><a href="browse-images.php?continent='.$row['ContinentCode'].'">'.$row['ContinentName'].'</a></li>';
        }
        return $output;
    }
    
    public function genContinentSelect() {
        $result = self::$pdo->exSelect("ContinentCode,ContinentName","Continents","ORDER BY ContinentName ASC","");
        $output;
        foreach($result as $row) {
          $output .= '<option value='.$row['ContinentCode'];
          if($v1 && $row['ContinentCode'] == $_GET['continent']) { $output.= ' selected';}
          $output .= '>'.$row['ContinentName'].'</option>';
        }
        return $output;
    }
    
    public function genCountries() {
        $result = self::$pdo->exSelect("COUNT(ISO) as NumISO,CountryName,CountryCodeISO","Countries JOIN ImageDetails ON CountryCodeISO=ISO","GROUP BY CountryCodeISO ORDER BY CountryName ASC","");
        $output;
        foreach($result as $row) {
            echo '<li class="list-group-item"><a href="browse-images.php?country='.$row['CountryCodeISO'].'">'.$row['CountryName'].'</a></li>';
        }
        return $output;
    }
    
    public function genCountrySelect() {
        $result = self::$pdo->exSelect("COUNT(ISO) as NumISO,CountryName,CountryCodeISO","Countries JOIN ImageDetails ON CountryCodeISO=ISO","GROUP BY CountryCodeISO ORDER BY CountryName ASC","");
        $output;
        foreach($result as $row) {
            $output .= '<option value='.$row['CountryCodeISO'];
            $output .= '>'.$row['CountryName'].'</option>';
        
        }
        return $output;
    }
    
    public function genCitySelect() {
        $result = self::$pdo->exSelect("COUNT(a.CityCode) as NumCity,AsciiName,a.CityCode as CCode","Cities as a JOIN ImageDetails as b ON a.CityCode=b.CityCode","GROUP BY a.CityCode ORDER BY AsciiName ASC","");
        $output;
        foreach($result as $row) {
            $output .= '<option value='.$row['CCode'];
            $output .= '>'.$row['AsciiName'].'</option>';
        }
        return $output;
    }
    
    public function genRatingList($id) {
        $query = self::$pdo->exSelect("*","ImageRating","WHERE ImageID = ?",array($id));
        $output = "";
        $ratings = array();
        foreach($query as $row) {
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
    
    public function genUsers() {    
        $counter = 1;
        $output = "";
        $result = self::$pdo->exSelect("UserID,FirstName,LastName","Users","ORDER BY LastName,FirstName ASC","");
        foreach($result as $row) {
            if($counter % 4 == 0) {
                $output .= '<div class="row">';
            } 
                $output .= '<div class="col-md-3"><a href="single-user.php?id='.$row['UserID'].'">'.$row['FirstName'].' '.$row['LastName'].'</a></div>';
            if($counter % 4 == 0 && $counter != 0) {
                $output .= '</div>';
            }
            $counter++;
        }
        return $output;
    }
    
    public function genCountryList() {
        $result = self::$pdo->exSelect("COUNT(ISO) as NumISO,CountryName,CountryCodeISO","Countries JOIN ImageDetails ON CountryCodeISO=ISO","GROUP BY CountryCodeISO ORDER BY CountryName ASC","");
        $output;
        $counter = 1;
        foreach($result as $row) {
            if($counter % 4 == 0) {
                $output .= '<div class="row">';
            } 
                $output .= '<div class="col-md-3"><a href="single-country.php?id='.$row['CountryCodeISO'].'">'.$row['CountryName'].'</a></div>';
            if($counter % 4 == 0 && $counter != 0) {
                $output .= '</div>';
            }
            $counter++;
        }
        return $output;
    }
    
    public function genCities() {
        $result = self::$pdo->exSelect("COUNT(a.CityCode) as NumCity,AsciiName,a.CityCode","Cities as a JOIN ImageDetails as b ON a.CityCode=b.CityCode","GROUP BY a.CityCode ORDER BY AsciiName ASC","");
        $output;
        $counter = 1;
        foreach($result as $row) {
            if($counter % 4 == 0) {
                $output .= '<div class="row">';
            } 
                $output .= '<div class="col-md-3"><a href="single-city.php?id='.$row['CityCode'].'">'.$row['AsciiName'].'</a></div>';
            if($counter % 4 == 0 && $counter != 0) {
                $output .= '</div>';
            }
            $counter++;
        }
        return $output;
    }
    
    public function genPostList() {
        $result = self::$pdo->exSelect("*","Posts AS a JOIN Users AS b ON a.UserID=b.UserID JOIN ImageDetails AS c ON a.MainPostImage=c.ImageID","ORDER BY a.PostTime DESC","");
        $output="";
        foreach($result as $row) {
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
                            $output.=substr($row['Message'],0,80).'. . .';            
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
    
    public function getPost($id) {
        $record = self::$pdo->exSelect("*","Posts AS a JOIN Users AS b ON a.UserID=b.UserID","WHERE a.PostID=?",array($id));
        if(!$record) {
            header("Location: error.php");
        }
        return $record;
    }
    
    public function getUser($id) {
        $result = self::$pdo->exSelect("*","Users","WHERE UserID=?",array($id));
        if(!$result) {
            header("Location: error.php");
        }
        return $result;
    }
    
    public function getCity($id) {
        $result = self::$pdo->exSelect("a.*,b.CountryName","Cities as a JOIN Countries as b ON a.CountryCodeISO=b.ISO","WHERE a.CityCode=?",array($id));
        if(!$result) {
            header("Location: error.php");
        }
        return $result;
    }
    
    public function getCountry($id) {
        $result = self::$pdo->exSelect("*","Countries","WHERE ISO=?",array($id));
        if(!$result) {
            header("Location: error.php");
        }
        return $result;
    }
    
    public function getImageResults($id) {
        return self::$pdo->exSelect("*","ImageDetails","WHERE CountryCodeISO = ?",array($id));
    }
}