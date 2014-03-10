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
        $this->load->model('posts');
        $this->load->model('images_dao');
        $this->load->model('tags_dao');
    }

    //-------------------------------------------------------------
    //  The index should never be called!
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Posts";
        $this->data['pageDescrip'] = "Post maintenance functions";

        $posts = $this->posts->getAll_array();
        foreach ($posts as &$post) {
            $post['picname'] = $this->images_dao->getName($post['pic']);
            $this->data['post_edit'] = makeLinkButton('Edit', '/postmtce/edit/{pid}', 'Edit');
            $this->data['post_delete'] = makeLinkButton('Delete', '/postmtce/delete/{pid}', 'Delete');
        }
        $this->data['posts'] = $posts;
        $this->data['pagebody'] = 'postlist';

        $this->data['post_add'] = makeLinkButton('Add a post', '/postmtce/add', 'Add a post');
        $this->data['cancel'] = makeLinkButton('Cancel', "/accountMan", 'Cancel');

        $this->render();
    }

    //-------------------------------------------------------------
    //  Trigger adding a new post
    //-------------------------------------------------------------

    function add() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Add a Posting";
        $this->data['pageDescrip'] = "Add post";
        $this->data['pagebody'] = 'postedit';

        $posting = (array) $this->posts->create();
        $this->data = array_merge($this->data, $posting);
        $this->data['pid'] = 'new';

        $this->data['field_errors'] = $this->getErrors();
        $this->data['field_pic'] = makeImageUploader('Thumbnail', 'pic', '');
        $this->data['field_title'] = makeTextField('Post Title', 'ptitle', $posting['ptitle'], 'Title of the post');
        $this->data['field_date'] = makeDateSelector('Post Date', 'created', $posting['created'], 'The date of posting');
        $this->data['field_slug'] = makeTextArea('Slug', 'slug', $posting['slug'], 'Short Description of post', 140, 35, 6);
        $this->data['field_tags'] = makeTextArea('Tags', 'tags', '', 'Comma Separated Tags', 40, 25, 1);
        $this->data['field_story'] = makeCKEditor('Story', 'story', $posting['story']);
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'submit');
        $this->data['cancel'] = makeLinkButton('Cancel', "/postmtce", 'Cancel');

        $this->render();
    }

    // Request a post edit
    function edit($pid = null) {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Edit a Posting";
        $this->data['pageDescrip'] = "Edit post";
        
        if($pid == null){
            redirect('/postmtce');
        }
        
        $posting = (array) $this->posts->get($pid);
        $this->data = array_merge($this->data, $posting);
        $this->data['pid'] = $posting['pid'];
        $this->data['pagebody'] = 'postedit';
        $this->data['field_errors'] = $this->getErrors();
        $this->data['field_pic'] = makeImageUploader('Thumbnail', 'pic', 'Leave blank to use existing');
        $this->data['field_title'] = makeTextField('Post Title', 'ptitle', $posting['ptitle'], 'Title of the post');
        $this->data['field_date'] = makeDateSelector('Post Date', 'created', $posting['created'], 'The date of posting', 10, TRUE);
        $this->data['field_slug'] = makeTextArea('Slug', 'slug', $posting['slug'], 'Short Description of post', 140, 35, 6);
        $this->data['field_tags'] = makeTextArea('Tags', 'tags', $this->tags_dao->getTagsString($pid), 'Comma Separated Tags', 40, 25, 1);
        $this->data['field_story'] = makeCKEditor('Story', 'story', $posting['story']);
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'submit');
        $this->data['cancel'] = makeLinkButton('Cancel', "/postmtce", 'Cancel');

       $this->render();
    }

    // Process an add/edit form submission
    function submit($pid = null) {
        // the form fields we are interested in
        $post_fields = array('user', 'ptitle', 'slug', 'story', 'created', 'pic', 'tags');
        $posting = array();
        $errors = array();

        // either create or retrieve the relevant user record
        if ($pid == null || $pid == 'new') {
            $pid = null;
            $posting = $this->posts->create();
        } else {
            $posting = $this->posts->get($pid);
        }

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $posting, $post_fields);

        $posting = (array) $posting;

        // if creating the post
        if ($pid == null) {
            $posting['user'] = $this->activeuser->getID();
        }

        if ($posting['ptitle'] == '') {
            $errors[] = 'title';
        }

        $posting['ptitle'] = htmlspecialchars($posting['ptitle']);

        if ($posting['slug'] == '') {
            $errors[] = 'slug';
        }

        $posting['slug'] = htmlspecialchars($posting['slug']);

        if ($posting['created'] == '') {
            unset($posting['created']);
        }

        // allow updated to be set by the database
        $posting['updated']=NULL;

        $posting['story'] = '' . $_POST['story'];

        // only attempt to upload image if no other errors
        if (count($errors) == 0) {
            
            // Check to see if there is a valid upload
            if ($_FILES['pic']['error'] === UPLOAD_ERR_OK) {
                $imgid = $this->images_dao->addFile($_FILES['pic']);
                if ($imgid == 0) {
                    // image failed to upload
                    $errors[] = 'pic';
                } else {
                    $posting['pic'] = $imgid;
                }
            }
            
            // check to see if there was an error
            else if($_FILES['pic']['error'] === UPLOAD_ERR_NO_FILE){
                // no file selected
                // leave file
            }
            
            else{
                // some other error occured
                $errors[] = 'pic';
            }
        }

        if (count($errors) > 0) {
            $this->redirectErrors($errors, $pid);
            exit;
        }
        
        // Save the tags seperatly as they're not part of the posts table
        $tags = $posting['tags'];
        unset($posting['tags']);
        
        // either add or update the posting record, as appropriate
        if ($pid == null) {
            unset($posting['pid']);
            $this->posts->add($posting);
        } else {
            $this->posts->update($posting);
        }
        
        // Tags are added after as they cannot be added to a nonexistant post
        if($pid == null){
            $newPost = (array)$this->posts->newest(1);
            $pid = $newPost[0]['pid'];
        }
        $this->tags_dao->addTags($pid, htmlspecialchars($tags));

        // redisplay the list of users
        redirect('/postmtce');
    }

    // Delete a posting
    function delete($pid) {
        $this->posts->delete($pid);
        $this->index();
    }

    function redirectErrors($errors, $pid = null) {
        $get = '?';
        foreach ($errors as $error) {
            $get .= $error . '=err&';
        }
        if ($pid != null) {
            redirect('/postmtce/edit/' . $pid . $get);
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