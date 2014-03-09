<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tags_dao extends _Mymodel {

    function __construct() {
        parent::__construct();
        $this->setTable('tags', 'pid');
    }
    
    function getTagsString($pid = 'all'){
        $result = '';
        $allPT = $this->getAll_array();
        foreach($allPT as $post){
            if($pid == 'all' || $post['pid'] == $pid){
                $result .= $post['tag'] . ', ';
            }
        }
        $result = rtrim($result, ", ");
        return $result;
    }
    
    function getTagsLinks($pid = 'all'){
        $result = '';
        $allPT = $this->getAll_array();
        foreach($allPT as $post){
            if($pid == 'all' || $post['pid'] == $pid){
                $result .= '<a href="/blog/tag/' . $post['tag'] . '">' . $post['tag'] . '</a>, ';
            }
        }
        $result = rtrim($result, ", ");
        return $result;
    }
    
    function getTagsArray($pid = 'all'){
        $result = array();
        $allPT = $this->getAll_array();
        foreach($allPT as $post){
            if($pid == 'all' || $post['pid'] == $pid){
                $result[] = $post['tag'];
            }
        }
        $result = array_unique($result);
        return $result;
    }
    
    function getPostsWithTag($tag){
        $result = array();
        $allPT = $this->getAll_array();
        foreach($allPT as $post){
            if($post['tag'] == $tag){
                $result[] = $post['pid'];
            }
        }
        return $result;
    }
    
    function addTags($pid, $tagsStr){
        $tagsToAdd = explode(',', $tagsStr);
        $record = array();
        $record['pid'] = $pid;
        foreach($tagsToAdd as $tag){
            $tag = trim($tag);
            $record['tag'] = $tag;
            if($tag != ''){
                $this->add($record);
            }
        }
    }
    
    function removeAllTags($pid){
        $this->delete($pid);
    }
    
}