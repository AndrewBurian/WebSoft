<?php

/**
 * About page.
 * 
 * controllers/about.php
 *
 * ------------------------------------------------------------------------
 */
class About extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'About';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'About us';
        $this->data['pageDescrip'] = 'Who are we, what do we do, and why do we do it?';
        $this->data['pagebody'] = 'about';
        $this->render();
    }

}

/* End of file about.php */
/* Location: application/controllers/about.php */