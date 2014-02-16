<?php

/**
 * controllers/login.php
 *
 * Login manager 
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2010-2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Login extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  Default entry point. 
    //  We should never get here, since the login form is in the sidebar
    //-------------------------------------------------------------

    function index() {
        redirect('/');
    }

    // Process a login
    function submit() {
        $key = $_POST['id'];
        $password = md5($_POST['password']);
        // echo 'key: '.$key.'<br/>';
        // echo 'password: '.$password.'<br/>';
        // exit;
        $user = $this->users->get($key);
        // what if no such user
        if ($user == null) {
            echo 'No such user<br/>';
            // redirect('/');
            exit;
        }
        //check the password
        if ($password == (string) $user->password) {
            // we have a winner!
            $this->session->set_userdata('id', $key);
            $this->session->set_userdata('userName', $user->name);
            $this->session->set_userdata('userRole', $user->role);

            redirect("/");
        } else {
            echo 'Password does not match<br/>';
            // password doesn't match
            redirect("/");
        }
    }

}

/* End of file login.php */
/* Location: application/controllers/login.php */