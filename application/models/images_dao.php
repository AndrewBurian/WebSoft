<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Images_dao extends _Mymodel {

    function __construct() {
        parent::__construct();
        $this->setTable('images', 'iid');
    }

    function getName($iid) {
        $image = (array)$this->get($iid);
        if($image == NULL){
            return "Not Found";
        }
        else{
            return $image['filename'];
        }
    }

    function getPath($iid) {
        $result = "/data/images/";
        $image = (array)$this->get($iid);
        if($image == NULL){
            $result .= "notFound.jpg";
        }
        else{
            $result .= $image['filename'];
        }
        return $result;
    }

    function getCaption($iid) {
        $image = (array)$this->get($iid);
        if($image == NULL){
            return "Not Found";
        }
        else{
            return $image['caption'];
        }
    }

    function getDate($iid) {
        $image = (array)$this->get($iid);
        if($image == NULL){
            return 0;
        }
        else{
            return $image['date'];
        }
    }

    function addFile($file) {
        // Set the upload directory
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/data/images/';
        
        // Check php's built in errors
        if($file['error'] != 0){
            return 0;
        }
        
        // Check to make sure it's really an uploaded file
        if(!is_uploaded_file($file['tmp_name'])){
            return 0;
        }
        
        // Check to make sure file is an image using imgsize
        if(getimagesize($file['tmp_name']) == false){
            return 0;
        }
        
        // Generate a unique name
        // timestamp-name.ext
        $timestamp = time();
        $finalName = '';
        while(file_exists($finalName = $uploadDir . $timestamp . '-' . $file['name'])){
            $timestamp++;
        }
        
        // Move uploaded file to it's destination and new name
        if(move_uploaded_file($file['tmp_name'], $finalName) == false){
            return 0;
        }
        
        // Collect the image data
        $Imgdata = array();
        $Imgdata['caption'] = $file['name'];
        $Imgdata['filename'] = $timestamp . '-' . $file['name'];
        $Imgdata['author'] = $this->activeuser->getName();
        $Imgdata['iid'] = NULL;

        // Add to database
        $this->add($Imgdata);

        // Check to see if added, and get the iid
        $allImages = $this->getAll_array();
        foreach ($allImages as $pic) {
            if ($pic['filename'] == $Imgdata['filename']) {
                // image added. Return iid.
                return $pic['iid'];
            }
        }

        // failed to add to database
        return 0;
    }

}
