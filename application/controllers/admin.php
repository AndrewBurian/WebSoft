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
        $this->load->library('xmlrpc');
        $this->xmlrpc->server('http://http://showcase.bcitxml.com/test/', 80);
        $this->xmlrpc->method('update');
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
        
        $this->data['site_changes'] = $this->session->flashdata('changes');

        $this->data['field_site_name'] = makeTextArea('Site Name', 'sitename', $this->site_info->getName(), 'The name of our site, this will appear on the main title and throughout', 64, 25, 1);
        $this->data['submit_site_name'] = makeSubmitButton('Update Site Name', 'Submit');

        $this->data['field_site_plug'] = makeTextArea('Site Plug', 'siteplug', $this->site_info->getPlug(), 'The short description of our site that will appear on the title bar', 128, 30, 5);
        $this->data['submit_site_plug'] = makeSubmitButton('Update Site Plug', 'Submit');

        $this->render();
    }

    function sitename() {
        if ($_POST['sitename'] != '') {
            //$this->site_info->setName($_POST['sitename']);
            $this->updateMaster();
            $this->session->set_flashdata('changes', 'Set sitename to: ' . $_POST['sitename']);
        }

        redirect('/admin');
    }

    function siteplug() {
        if ($_POST['siteplug'] != '') {
            //$this->site_info->setPlug($_POST['siteplug']);
            $this->updateMaster();
            $this->session->set_flashdata('changes', 'Set sitename to: ' . $_POST['siteplug']);
        }
        redirect('/admin');
    }

    function updateMaster() {
        
        $request = array($this->site_info->getCode(),
            $this->site_info->getName(),
            $this->site_info->getLink(),
            $this->site_info->getPlug());
        
        $this->xmlrpc->request($request);
        $this->xmlrpc->send_request();
    }

}
