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
        $this->setTable('rpc_data', 'varid');
    }

    function getName() {

        $siteName = $this->get_array('0');
        return $siteName['name'];
        // return "Greater Vancouver Pub Reviews";
    }

    function getCode() {
        $siteCode = $this->get_array('0');
        return $siteCode['code'];
        // return "O07";
    }

    function getLink() {
        return $_SERVER['HTTP_HOST'];
    }

    function getPlug() {
        $sitePlug = $this->get_array('0');
        return $sitePlug['plug'];
        //  return "Casual reviews of our favorite watering holes.";
    }

    function setName($name) {

        $siteName = $this->get_array('0');
        $siteName['name'] = $name;
        $this->update($siteName);
        // throw new Exception("Not yet supported");
    }

    function setCode($code) {
        $siteCode = $this->get_array('0');
        $siteCode['code'] = $code;
        $this->update($siteCode);
        //throw new Exception("Not yet supported");
    }

    function setPlug($plug) {
        $sitePlug = $this->get_array('0');
        $sitePlug['plug'] = $plug;
        $this->update($sitePlug);
        // throw new Exception("Not yet supported");
    }

}
