<?php

/**
 * Friends page.
 * 
 * controllers/friends.php
 *
 * ------------------------------------------------------------------------
 */
class Friends extends Application {

    function __construct() {
        parent::__construct();
        $this->load->model('contacts');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Friends';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Friends';
        $this->data['pageDescrip'] = 'Donec ac dui eu augue faucibus sagittis ';
        $this->data['pagebody'] = 'friends_list';
        $this->data['contacts'] = $this->contacts->getAll_array();
        
        $this->data['session_id'] = $this->activeuser->getID();
        $this->data['login'] = $this->activeuser->buildLoginBar();
        
        $this->render();
    }

}

/* End of file friends.php */
/* Location: application/controllers/friends.php */