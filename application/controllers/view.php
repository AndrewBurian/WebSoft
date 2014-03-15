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
        $this->load->model('tags_dao');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        //$this->data['page'] = 'View';
        //$this->data['pagebody'] = 'view';
        //$this->data['title'] = 'Greater Vancouver Pub Reviews';
        //$this->data['pageTitle'] = 'Recent Posts';
        //$this->data['pageDescrip'] = 'Suspendisse venenatis dolor vitae dolor';
        //$this->render();
        redirect('/');
    }

    // Present a single post.
    function post($which) {
        //Get the post
        $record = (array) $this->posts->get($which);
        if(empty($record)){
            redirect('/');
        }
        $this->data = array_merge($this->data, $record);

        //get associated images
        $this->data['img_src'] = $this->images_dao->getPath($record['pic']);
        $this->data['caption'] = $this->images_dao->getCaption($record['pic']);
        
        $this->data['tags'] = $this->tags_dao->getTagsLinks($which);

        //the rest of the page
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = "Post #" . $record['pid'] . ' ' . $record['ptitle'];
        $this->data['pageDescrip'] = '';
        $this->data['pagebody'] = 'view1';
        
        $this->data['author_name'] = $this->users_dao->getUserName($record['user']);
        $this->data['author_img'] = $this->images_dao->getPath(
                $this->users_dao->getUserPic($record['user']));
        
        $this->render();
    }

}

/* End of file view.php */
/* Location: application/controllers/view.php */