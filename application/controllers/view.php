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
        $this->load->model('comments_dao');
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
        if (empty($record)) {
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

        $this->data['comments'] = $this->buildComments($which);

        $this->render();
    }

    function buildComments($pid) {
        $result = '';
        $viewParams = array();

        if ($this->activeuser->isAuthorized(array(ROLE_USER, ROLE_ADMIN))) {
            $viewParams['comment_text'] = makeTextArea('Comment', 'comment', '', '', 300, 50, 5);
            $viewParams['comment_submit'] = makeSubmitButton('Post', 'Post');

            $result .= $this->parser->parse('comments/_commentSubmit', $viewParams, true);
        }

        $commentIds = array();
        $commentIds = $this->comments_dao->getForPost($pid);

        $result .= '<h3>Latest Comments</h3><br/>';
        
        if (count($commentIds) > 0) {
            $result .= '<table width="80%" rules="rows">';
            foreach($commentIds as $cid){
                $details = $this->comments_dao->get_array($cid);
                $viewParams['comment_user_img'] =  $this->data['author_img'] = $this->images_dao->getPath(
                    $this->users_dao->getUserPic($details['uid']));
                $viewParams['comment_user_name'] = $this->users_dao->getUserName($details['uid']);
                $viewParams['comment_text'] = $details['text'];
                $viewParams['comment_time'] = $details['time'];
                $result .= $this->parser->parse('comments/_comment', $viewParams, true);
                
            }
            $result .= '</table>';
        } else {
            $result .= "There are no comments yet.";
        }

        return $result;
    }

}

/* End of file view.php */
/* Location: application/controllers/view.php */