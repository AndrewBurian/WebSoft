<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Posts table.
 *
 * @author		JLP
 * ------------------------------------------------------------------------
 */
class Posts extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('posts', 'pid');
    }

    // Return the latest 3 posts, in revverse order (newest first)
    function newest($count = 3) {
        $this->db->order_by($this->_keyField, 'desc');
        $this->db->limit($count);
        $query = $this->db->get($this->_tableName);
        return $query->result_array();
    }
    
    function getLatestID(){
        $posts = $this->newest(1);
        return $posts[0]['pid'];
    }
    
    function getDateTime($pid){
        $post = (array)$this->get($pid);
        $date = (string)$post['created'];
        $date = str_replace(array(" ", ":"), "-", $date);
        $date = substr($date, 0, -3);
        return $date;
    }
    
    function getlink($pid, $full = false){
        $link = "";
        if($full){
            $link .= $_SERVER['HTTP_HOST'];//"VancouverPubReviews.bcitxml.com";
        }
        $link .= '/view/post/' . $pid;
        return $link;
    }
    
    function getTitle($pid){
        $post = (array)$this->get($pid);
        return (string)$post['ptitle'];
    }
    
    function getSlug($pid){
        $post = (array)$this->get($pid);
        return (string)$post['slug'];
    }

}

/* End of file posts.php */
/* Location: application/models/posts.php */