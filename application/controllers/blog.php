<?php

/**
 * Blog page.
 * 
 * controllers/blog.php
 *
 * ------------------------------------------------------------------------
 */
class Blog extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Blog';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Blog';
        $this->data['pageDescrip'] = 'Donec ac dui eu augue faucibus sagittis ';
        $this->data['pagebody'] = 'blog';
        $this->render();
    }

}

/* End of file blog.php */
/* Location: application/controllers/blog.php */