<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends Application {

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
        $this->data['pageTitle'] = 'Log In';
        $this->data['pageDescrip'] = 'Log In to our site';
        
        if($this->activeuser->isLoggedIn()){
            $this->buildAlreadyLoggedIn();
            $this->data['pagebody'] = 'login/alreadyloggedin';
            $this->data['login'] = $this->activeuser->buildLoginBar();
        }else{
            $this->data['pagebody'] = 'login/login';
            $this->data['login'] = 'Logging in now';
        }
        $this->render();
    }
}