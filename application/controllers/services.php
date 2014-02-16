<<<<<<< HEAD
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
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Services';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Services';
        $this->data['pageDescrip'] = 'Suspendisse venenatis dolor vitae dolor';
        $this->data['pagebody'] = 'services';
        
        $this->data['session_id'] = $this->activeuser->getID();
        $this->data['login'] = $this->activeuser->buildLoginBar();
        
        $this->render();
    }

}

/* End of file services.php */
=======
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
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Services';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Services';
        $this->data['pageDescrip'] = 'Suspendisse venenatis dolor vitae dolor';
        $this->data['pagebody'] = 'services';
        $this->data['login'] = $this->activeuser->buildLoginBar();
        $this->render();
    }

}

/* End of file services.php */
>>>>>>> f96c9ecd1233233f86c83629c2bf81ab7c280814
/* Location: application/controllers/services.php */