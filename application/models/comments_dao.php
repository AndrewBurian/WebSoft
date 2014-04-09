<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comments_dao extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('comments', 'cid');
    }
    
    function getForPost($pid){
        $result = array();
        $allComments = (array)$this->getAll_array();
        foreach ($allComments as $comment) {
            if($comment['pid'] == $pid){
                $result[] = $comment['cid'];
            }
        }
        rsort($result);
        return $result;
    }
    
    function getForUser($uid){
        $result = array();
        $allComments = (array)$this->getAll_array();
        foreach ($allComments as $comment) {
            if($comment['uid'] == $uid){
                $result[] = $comment['cid'];
            }
        }
        rsort($result);
        return $result;
    }
    
}
