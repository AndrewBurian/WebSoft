<?php

/**
 * Services page.
 * 
 * controllers/services.php
 *
 * ------------------------------------------------------------------------
 */
class Services extends Application {

    function __construct() {
        parent::__construct();
        $this->activeuser->restrict(ROLE_ADMIN);
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Services';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Services';
        $this->data['pageDescrip'] = 'Ignore the empty shell of a page...';
        $this->data['pagebody'] = 'services';
        $this->render();
    }

}

/* End of file services.php */
/* Location: application/controllers/services.php */