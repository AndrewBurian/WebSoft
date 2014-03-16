<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Site_info extends CI_model {


    // Constructor
    function __construct() {
        parent::__construct();
    }
    
    
    function getName(){
        return "Vancouver Pub Reviews";
    }
    
    function getCode(){
        return "O07";
    }
    
    function getLink(){
        return $_SERVER['HTTP_HOST'];
    }
    
    function getPlug(){
        return "Casual reviews of our favorite watering holes.";
    }
    
    function setName(){
        throw new Exception("Not yet supported");
    }
    
    function setCode(){
        throw new Exception("Not yet supported");
    }
    
    function setPlug(){
        throw new Exception("Not yet supported");
    }
    
}