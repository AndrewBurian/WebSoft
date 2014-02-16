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

    function buildLoginBar() {
        $result = "";
        if ($this->session->userdata('id') == null) {
            // return login bar
            $result .= '<a href="/login">Log In</a>';
        } else {
            // return login name
            $result .= $this->session->userdata('username');
            $result .= ' | <a href="/logout">Log Out</a>';
        }

        return $result;
    }

    function getID() {
        return $this->session->userdata('id');
    }

    function getName() {
        return $this->session->userdata('username');
    }

    function isLoggedIn() {
        return(!($this->getID() == null));
    }

    function restrict($roleNeeded = null, $directOnFailURL = null) {
        $userRole = $this->session->userdata('role');
        if($userRole == null){
            $userRole = ROLE_VISITOR;
        }
        if ($roleNeeded != null) {
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                    if ($directOnFailURL == null) {
                        redirect("/");
                    } else {
                        reditect($directOnFailURL);
                    }
                    exit;
                }
            } else
            if ($userRole != $roleNeeded) {
                if ($directOnFailURL == null) {
                    redirect("/");
                } else {
                    reditect($directOnFailURL);
                }
                exit;
            }
        }
    }
    
    function isAuthorized($roleNeeded){
        $userRole = $this->session->userdata('role');
        if($userRole == null){
            $userRole = ROLE_VISITOR;
        }
        if ($roleNeeded != null) {
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                    return false;
                }
            } else
            if ($userRole != $roleNeeded) {
                return false;
            }
        }
        
        return true;
    }

    function login($id, $username, $role) {
        $this->session->set_userdata('id', $id);
        $this->session->set_userdata('username', $username);
        $this->session->set_userdata('role', $role);
    }

    function logout() {
        $this->session->sess_destroy();
    }

}
