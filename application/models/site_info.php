<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Site_info extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('info', 'key');
    }

    function getName() {

        $siteName = $this->get_array('name');
        return $siteName['val'];
        // return "Greater Vancouver Pub Reviews";
    }

    function getCode() {
        $siteCode = $this->get_array('code');
        return $siteCode['val'];
        // return "O07";
    }

    function getLink() {
        return $_SERVER['HTTP_HOST'];
    }

    function getPlug() {
        $sitePlug = $this->get_array('plug');
        return $sitePlug['val'];
        //  return "Casual reviews of our favorite watering holes.";
    }

    function setName($name) {

        $siteName = $this->get_array('name');
        $siteName['val'] = $name;
        $this->update($siteName);
    }

    function setCode($code) {
        $siteCode = $this->get_array('code');
        $siteCode['val'] = $code;
        $this->update($siteCode);
    }

    function setPlug($plug) {
        $sitePlug = $this->get_array('plug');
        $sitePlug['val'] = $plug;
        $this->update($sitePlug);
    }

}
