<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Logout extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------


    function index() {

        $this->data['title'] = "Bars in Greater Vancouver";
        $this->data['page'] = 'Bars';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Log Out';
        $this->data['pageDescrip'] = 'Come Back Soon!';

        $this->activeuser->logout();
        redirect('/welcome');
        $this->render();
    }

}
