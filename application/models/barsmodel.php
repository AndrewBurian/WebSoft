<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Barsmodel extends CI_model {

    var $xml_root;

// Constructor
    function __construct() {
        parent::__construct();
        $this->xml_root = simplexml_load_file(XML_FOLDER . 'locations.xml');
    }

    function getCities() {
        $result = array();

        foreach ($this->xml_root->CITY as $city) {
            $result[] = (string) $city['name'];
        }

        return $result;
    }

    function getBarsInCity($cityName) {
        foreach ($this->xml_root->CITY as $city) {
            if (((string) $city['name']) == $cityName) {
                $result = array();
                foreach ($city->BAR as $bar) {
                    $result[] = (array) $bar;
                }
                return $result;
            }
        }
        return NULL;
    }

}
