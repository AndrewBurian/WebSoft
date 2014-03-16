<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin extends Application {

    function __construct() {
        parent::__construct();
        $this->activeuser->restrict(ROLE_ADMIN);
        $this->load->model('site_info');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Site Management';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Manage the Site';
        $this->data['pageDescrip'] = 'Admins Only';
        $this->data['pagebody'] = 'admin';
        
        $this->data['site_name'] = $this->site_info->getName();
        $this->data['site_code'] = $this->site_info->getCode();
        $this->data['site_plug'] = $this->site_info->getPlug();
        $this->data['site_link'] = $this->site_info->getLink();
        
        $this->render();
    }
    
}