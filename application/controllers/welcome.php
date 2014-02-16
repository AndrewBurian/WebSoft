<?php

/**
 * Our homepage.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Home';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Recent articles';
        $this->data['pageDescrip'] = 'Lorem ipsum dolor amet sit consectetur adipiscing';
        $this->data['pagebody'] = 'welcome';
        $this->data['posts'] = $this->posts->newest();
        
        $this->data['session_id'] = $this->activeuser->getID();
        $this->data['login'] = $this->activeuser->buildLoginBar();
       
        $this->render();
    }

}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */