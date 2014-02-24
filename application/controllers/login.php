<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends Application {

    function __construct() {
        parent::__construct();
        $this->load->model('users_dao');
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

        if ($this->activeuser->isLoggedIn()) {
            $this->data['user_name'] = $this->activeuser->getName();
            $this->data['pagebody'] = 'login/already_logged_in';
        } else {
            $this->data['pagebody'] = 'login/login';
            $this->data['password_field'] = makePasswordField('Password:', 'password', '');
            $this->data['username_field'] = makeTextField('Username:', 'username', '');
            $this->data['submit'] = makeSubmitButton('Login', 'Login');
        }
        $this->render();
    }

    function submit() {
        $userID = $this->users_dao->getUserID($_POST['username']);
        if ($userID != NULL) {
            if ($this->users_dao->authenticateUser($userID, $_POST['password'])) {
                $this->activeuser->login($userID, $_POST['username'], $this->users_dao->getUserRole($userID));
            }
        }
        redirect("/");
    }

}
