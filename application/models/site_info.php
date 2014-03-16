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
        $this->setTable('rpc_data');
    }

    function getName() {
        $result = "";
        $result .= $this->get('name');
        return $result;
        // return "Greater Vancouver Pub Reviews";
    }

    function getCode() {
        $result = "";
        $result .= $this->get('code');
        return $result;
        //return "O07";
    }

    function getLink() {
        return $_SERVER['HTTP_HOST'];
    }

    function getPlug() {
        $result = "";
        $result .= $this->get('plug');
        return $result;
        // return "Casual reviews of our favorite watering holes.";
    }

    function setName($name) {

        $siteName = $this->get_array('name');
        $siteName['name'] = $name;
        $this->update($siteName);
        // throw new Exception("Not yet supported");
    }

    function setCode($code) {
        $siteCode = $this->get_array('code');
        $siteCode['code'] = $code;
        $this->update($siteCode);
        //throw new Exception("Not yet supported");
    }

    function setPlug($plug) {
        $sitePlug = $this->get_array('plug');
        $sitePlug['plug'] = $plug;
        $this->update($sitePlug);
        // throw new Exception("Not yet supported");
    }

}
