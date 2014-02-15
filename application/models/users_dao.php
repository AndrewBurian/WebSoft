<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_dao extends _Mymodel{
    
    function __construct() {
        parent::__construct();
        $this->setTable('users', 'id');
    }
    
    function authenticateUser($userID, $password){
        
        // Check to see if user exists at all
        if(!$this->exists($userID)){
            return false;
        }
        
        // Get the users details
        $userInfo = $this->get_array($userID);
        
        // Check password
        if(md5($password) == $userInfo['password']){
            return true;
        }
        else{
            return false;
        }
    }
    
    function restrict($userID, $requiredRole = ROLE_VISITOR){
        
        // no one will ever be less than a visitor
        if($requiredRole == ROLE_VISITOR){
            return true;
        }
        
        // check to see if roles are a match
        $userRole = $this->getUserRole($userID);
        if($userRole == $requiredRole){
            return true;
        }
        
        // if user is admin, allow anyways
        if($userRole == ROLE_ADMIN){
            return true;
        }
        
        // required role or user role is not valid
        // or requirements are too high
        return false;
    }
    
    function getUserID($username){
        $allUsers = $this->getAll_array();
        foreach($allUsers as $user){
            if($user['name'] == $username){
                return $user['id'];
            }
        }
        return NULL;
    }
    
    function getUserRole($userID){
        // Get the users details
        $userInfo = $this->get_array($userID);
        
        return $userInfo['role'];
    }
    
    function getAllUsers(){
        return $this->getAll_array();
    }
    
    function changeUserRole($userID, $newRole){
        // check new role is valid
        if($newRole != ROLE_ADMIN && $newRole != ROLE_USER && $newRole != ROLE_VISITOR){
            return false;
        }
        $userDetails = $this->get_array($userID);
        $userDetails['role'] = $newRole;
        $this->update($userDetails);
        return true;
    }
    
    function changeUserPassword($userID, $newPassword){
        $userDetails = $this->get_array($userID);
        $userDetails['password'] = md5($newPassword);
        $this->update($userDetails);
    }
    
    function changeUserName($userID, $newName){
        $userDetails = $this->get_array($userID);
        $userDetails['name'] = $newName;
        $this->update($userDetails);
    }
    
    function removeUser($userID){
        $this->delete($userID);
    }
    
    function addUser($userID, $userName, $password, $role){
        // check new role is valid
        if($role != ROLE_ADMIN && $role != ROLE_USER && $role != ROLE_VISITOR){
            return false;
        }
        $userDetails = array();
        $userDetails['id'] = $userID;
        $userDetails['name'] = $userName;
        $userDetails['password'] = md5($password);
        $userDetails['role'] = $role;
        $this->add($userDetails);
        return true;
    }
}