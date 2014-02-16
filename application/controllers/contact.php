<?php

/**
 * Contact page.
 * 
 * controllers/contact.php
 *
 * ------------------------------------------------------------------------
 */
class Contact extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Contact';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Contact';
        $this->data['pageDescrip'] = 'Suspendisse venenatis dolor vitae dolor';
        $this->data['pagebody'] = 'contact';
        
        $this->data['session_id'] = $this->activeuser->getID();
        $this->data['login'] = $this->activeuser->buildLoginBar();
        
        $this->render();
    }

}

/* End of file contact.php */
/* Location: application/controllers/contact.php */