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
        $this->data['pageDescrip'] = 'Nullam tempor semper nisl in tristique';
        $this->data['pagebody'] = 'about';
        $this->data['login'] = $this->activeuser->buildLoginBar();
        $this->render();
    }

}

/* End of file about.php */
/* Location: application/controllers/about.php */