<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Activeuser extends _Mymodel {

    function __construct() {
        parent::__construct();
        //$this->load->model('user_dao');
    }
    
    function buildLoginBar(){
        $result = "";
        if($this->session->userdata('id') == null){
            // return login bar
            $result .= '<a href="/login">You need to login, son</a>';
        }else{
            // return login name
            $result .= "Welcome back commander";
        }
        
        return $result;
    }
    
    function getID(){
        return $this->session->userdata('id');
    }
    
    function isLoggedIn(){
        return(!($this->getID() == null));
    }
    
    function restrict($roleNeeded = null, $directOnFailURL = null) {
        $userRole = $this->session->userdata('role');
        if ($roleNeeded != null) {
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                    redirect();
                    exit;
                }
            } else
            if ($userRole != $roleNeeded) {
                if($directOnFailURL == null){
                    redirect("/");
                }
                else{
                    reditect($directOnFailURL);
                }
                exit;
            }
        }
    }

    function login($id, $username, $role){
        $this->session->set_userdata('id', $id);
        $this->session->set_userdata('username', $username);
        $this->session->set_userdata('userrole', $role);
    }
}
