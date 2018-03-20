<?php
/**
 * Used to store and track favourite lists
 * Honestly... two arrays in Helper class would work, too.
 */
 
class Favourites {
    private $favPosts;
    private $favImages;

    public function __construct() {
        $this->favPosts = [];
        $this->favImages = [];
    }
    
    public function addFav($id,$type) {
        if(!$this->search($id,$type)) {
            array_push($this->{'fav'.$type},$id);
        }
    }
    
    public function removeFav($id,$type) {
        for($i=0;$i<count($this->{'fav'.$type});$i++) {
            echo var_dump($this->{'fav'.$type}[$i]);
            if($this->{'fav'.$type}[$i] == $id) {
                unset($this->{'fav'.$type}[$i]);
                break;
            }
        }
        
    }
    
    public function search($id,$type) {
        $exists = false;
        for($i=0;$i<count($this->{'fav'.$type});$i++) {
            if($this->{'fav'.$type}[$i] == $id) {
                $exists = true;
                break;
            }
        }
        return $exists;
    }
    
    public function purgeImages() {
        $this->favImages = [];
    }
    
    public function purgePosts() {
        $this->favPosts = [];
    }
    
    public function getImagesList() {
        return $this->favImages;
    }
    
    public function getPostsList() {
        return $this->favPosts;
    }
}