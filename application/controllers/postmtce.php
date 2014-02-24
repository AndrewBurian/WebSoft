<?php

/**
 * controllers/postmtce.php
 *
 * Posting table maintenance
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
//FIXME Needs fleshing out
class Postmtce extends Application {

    function __construct() {
        parent::__construct();
        $this->activeuser->restrict(array(ROLE_USER, ROLE_ADMIN));
        $this->load->model('images_dao');
        $this->load->model('posts');
    }

    //-------------------------------------------------------------
    //  The index should never be called!
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Posts";
        $this->data['pageDescrip'] = "Post maintenance functions";

        $posts = $this->posts->getAll_array();
        foreach ($posts as &$post) {
            $post['picname'] = $this->images_dao->getName($post['pic']);
        }
        $this->data['posts'] = $posts;
        $this->data['pagebody'] = 'postlist';
        $this->render();
    }

    //-------------------------------------------------------------
    //  Trigger adding a new post
    //-------------------------------------------------------------

    function add() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Add a Posting";
        $this->data['pageDescrip'] = "Add post";

        $posting = (array) $this->posts->create();
        $this->data = array_merge($this->data, $posting);
        $this->data['uid'] = 'new';
        $this->data['pagebody'] = 'postedit';

        $this->data['field_errors'] = $this->getErrors();
        $this->data['field_pic'] = makeImageUploader('Thumbnail', 'pic', '');
        $this->data['field_title'] = makeTextField('Post Title', 'ptitle', $posting['ptitle'], 'Title of the post');
        $this->data['field_date'] = makeDateSelector('Post Date', 'created', $posting['created'], 'The date of posting');
        $this->data['field_slug'] = makeTextArea('Slug', 'slug', $posting['slug'], 'Short Description of post', 140, 15, 1);
        $this->data['field_story'] = makeTextEditor('Story', 'story', $posting['story']);
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'submit');

        $this->render();
    }

    // Request a post edit
    function edit($uid) {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Edit a Posting";
        $this->data['pageDescrip'] = "Edit post";

        $posting = (array) $this->posts->get($uid);
        $this->data = array_merge($this->data, $posting);
        $this->data['id'] = $posting['id'];
        $this->data['pagebody'] = 'postedit';
        $this->data['field_errors'] = $this->getErrors();
        $this->data['field_pic'] = makeImageUploader('Image', 'pic', 'Leave blank to use existing');
        $this->data['field_title'] = makeTextField('Post Title', 'ptitle', $posting['ptitle'], 'Title of the post');
        $this->data['field_date'] = makeDateSelector('Post Date', 'created', $posting['created'], 'The date of posting', 10, TRUE);
        $this->data['field_slug'] = makeTextArea('Slug', 'slug', $posting['slug'], 'Short Description of post', 140, 15, 1);
        $this->data['field_story'] = makeTextEditor('Story', 'story', $posting['story']);
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'submit');
        $this->render();
    }

    // Process an add/edit form submission
    function submit($id = null) {
        // the form fields we are interested in
        $post_fields = array('user', 'ptitle', 'slug', 'story', 'created', 'pic');
        $posting = array();
        $errors = array();
        
        // either create or retrieve the relevant user record
        if ($id == null || $id == 'new') {
            $id = null;
            $posting = $this->posts->create();
        } else {
            $posting = $this->posts->get($id);
        }

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $posting, $post_fields);
        
        $posting = (array)$posting;
        
        // if creating the post
        if($id == null){
            $posting['user'] = $this->activeuser->getID();
        }
        
        if($posting['ptitle'] == ''){
            $errors[] = 'title';
        }
        
        $posting['ptitle'] = htmlspecialchars($posting['ptitle']);
        
        if($posting['slug'] == ''){
            $errors[] = 'slug';
        }
        
        $posting['slug'] = htmlspecialchars($posting['slug']);
        
        if($posting['created'] == ''){
            unset($posting['created']);
        }
        
        // allow updated to be set by the database
        unset($posting['updated']);
        
        $posting['story'] = '' . $_POST['story'];
        
        // only attempt to upload image if no other errors
        if (count($errors) == 0) {
            if ($_FILES['pic']['name'] != '') {
                $imgid = $this->images_dao->addFile($_FILES['pic']);
                if ($imgid == 0) {
                    // image failed to upload
                    $errors[] = 'pic';
                } else {
                    $posting['pic'] = $imgid;
                }
            }
        }
        
        if (count($errors) > 0) {
            $this->redirectErrors($errors, $id);
            exit;
        }
        
        // either add or update the posting record, as appropriate
        if ($id == null) {
            $this->posts->add($posting);
        } else {
            $this->posts->update($posting);
        }

        // redisplay the list of users
        redirect('/postmtce');
    }

    // Delete a posting
    function delete($uid) {
        $this->posts->delete($uid);
        $this->index();
    }

    
    function redirectErrors($errors, $id = null) {
        $get = '?';
        foreach ($errors as $error) {
            $get .= $error . '=err&';
        }
        if ($id != null) {
            redirect('/postmtce/edit/' . $id . $get);
        } else {
            redirect('/postmtce/add' . $get);
        }
    }

    function getErrors() {
        $result = '';
        $viewParams = array();
        $viewParams['error_msg'] = '';

        if (isset($_GET['title'])) {
            $viewParams['error_msg'] = 'Title must be set';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }
        
        if (isset($_GET['slug'])) {
            $viewParams['error_msg'] = 'Slug must contain something';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }
        
        if (isset($_GET['pic'])) {
            $viewParams['error_msg'] = 'Your picture could not be uploaded. It may be too big or an unsupported format';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        return $result;
    }
    
}

/* End of file postmtce.php */
/* Location: ./system/application/controllers/postmtce.php */