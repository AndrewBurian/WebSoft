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
        $latest = $this->posts->newest();
        foreach ($latest as &$post) {
            $post['img_src'] = $this->images_dao->getPath($post['pic']);
            $post['caption'] = $this->images_dao->getCaption($post['pic']);
        }
        $this->data['posts'] = $latest;

        $this->render();
    }

}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */