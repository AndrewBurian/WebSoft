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
        $this->setTable('images', 'id');
    }

    function getName($id) {
        $allImages = $this->getAll_array();
        foreach ($allImages as $pic) {
            if ($pic['id'] == $id) {
                return $pic['filename'];
            }
        }
        return NULL;
    }

    function getPath($id) {
        $result = "/data/images/";
        $found = false;
        $allImages = $this->getAll_array();
        foreach ($allImages as $pic) {
            if ($pic['id'] == $id) {
                $result .= $pic['filename'];
                $found = true;
            }
        }
        if (!$found) {
            $result .= "not_found.gif";
        }

        return $result;
    }

    function getCaption($id) {
        $allImages = $this->getAll_array();
        foreach ($allImages as $pic) {
            if ($pic['id'] == $id) {
                return $pic['caption'];
            }
        }

        return "Not Found";
    }

    function getDate($id) {
        $allImages = $this->getAll_array();
        foreach ($allImages as $pic) {
            if ($pic['id'] == $id) {
                return $pic['date'];
            }
        }

        return NULL;
    }

    function add($record) {
        parent::add($record);
    }

    function safeAddFile($file) {
        try {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                    !isset($file['error']) ||
                    is_array($file['upfile']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            // You should also check filesize here. 
            if ($file['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                    $finfo->file($file['tmp_name']), array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                    ), true
                    )) {
                throw new RuntimeException('Invalid file format.');
            }

            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            if (!move_uploaded_file(
                            $file['tmp_name'], sprintf('/data/images/%s.%s', sha1_file($file['tmp_name']), $ext
                            )
                    )) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            echo 'File is uploaded successfully.';
        } catch (RuntimeException $e) {
            echo $e->getMessage();
            return false;
        }
        
        $Imgdata = array();
        $Imgdata['caption'] = $file['tmp_name'];
        $Imgdata['filename'] = sprintf('/data/images/%s.%s', sha1_file($file['tmp_name']), $ext);
        $Imgdata['author'] = $this->activeuser->getName();
        
        $this->add($Imgdata);
        return true;
    }

}
