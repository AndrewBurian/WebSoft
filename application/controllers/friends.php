<<<<<<< HEAD
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
=======
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
        $this->data['login'] = $this->activeuser->buildLoginBar();
        $this->data['contacts'] = $this->contacts->getAll_array();
        $this->render();
    }

}

/* End of file friends.php */
>>>>>>> f96c9ecd1233233f86c83629c2bf81ab7c280814
/* Location: application/controllers/friends.php */