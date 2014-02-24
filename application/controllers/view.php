<?php

/**
 * View controller.
 * 
 * controllers/view.php
 *
 * ------------------------------------------------------------------------
 */
class View extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        //$this->data['page'] = 'View';
        $this->data['pagebody'] = 'view';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Greater Vancouver Pub Reviews ~ Recent Posts';
        $this->data['pageDescrip'] = 'Suspendisse venenatis dolor vitae dolor';
        $this->render();
    }

    // Present a single post.
    function post($which) {
        //Get the post
        $record = (array) $this->posts->get($which);
        $this->data = array_merge($this->data, $record);

        //get associated images
        $this->data['img_src'] = $this->images_dao->getPath($record['pic']);
        $this->data['caption'] = $this->images_dao->getCaption($record['pic']);

        //the rest of the page
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Post #" . $record['pid'] . ' ' . $record['ptitle'];
        $this->data['pageDescrip'] = 'Suspendisse venenatis dolor vitae dolor';
        $this->data['pagebody'] = 'view1';
        $this->render();
    }

}

/* End of file view.php */
/* Location: application/controllers/view.php */