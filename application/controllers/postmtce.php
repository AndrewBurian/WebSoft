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

    var $_syndicateURL = 'http://showcase.bcitxml.com/boss';
    var $_syndicatePort = 80;
    
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

        $this->data['err_message'] = $this->session->flashdata('err_message');
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['posts'] = $this->listPosts();
        $this->data['pagebody'] = 'postlist';

        $this->data['post_add'] = makeLinkButton('Add a post', '/postmtce/add', 'Add a post');
        $this->data['cancel'] = makeLinkButton('Cancel', "/account", 'Cancel');

        $this->render();
    }
    
    
    function listPosts(){
        $result = '';
        $deleteWarning = "Are you sure you wish to delete this post? This is permanent!";
        $viewParams = array();
        $posts = $this->posts->getAll_array();
        foreach ($posts as &$post) {
            
            if($post['user'] == $this->activeuser->getID() || $this->activeuser->isAuthorized(ROLE_ADMIN)){
                $viewParams['post_edit'] = makeImageButton('icons/pencil.ico', '/postmtce/edit/{pid}', 'Edit Post', 20, 20);
                $viewParams['post_delete'] = makeImageButton('icons/delete.ico', '/postmtce/delete/{pid}', 'Delete Post', 20, 20, "return confirm('". $deleteWarning . "')");
            }
            else {
                $viewParams['post_edit'] = '';
                $viewParams['post_delete'] = '';
            }
            
            if($this->activeuser->isAuthorized(ROLE_ADMIN)){
                $viewParams['post_update'] = makeImageButton('icons/sync.ico', '/postmtce/sync/{pid}', 'Sync With Syndicate', 20, 20);
            }
            else{
                $viewParams['post_update'] = '';
            }
            
            $viewParams['pid'] = $post['pid'];
            $viewParams['picname'] = $this->images_dao->getName($post['pic']);
            $viewParams['ptitle'] = $post['ptitle'];
            $viewParams['updated'] = $post['updated'];
            $viewParams['tags'] = $this->tags_dao->getTagsString($post['pid']);
            $viewParams['slug'] = $post['slug'];
            $viewParams['story'] = substr($post['story'], 0, 40) . '...';
            
            $result .= $this->parser->parse('_postListRow', $viewParams, true);
        }
        
        return $result;
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
    
    function sync($pid = null){
        if($pid != null){
            $this->updateSyndicate($pid);
        }
        redirect('/postmtce');
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
            $errors['title'] = 'cannot be empty';
        }

        $posting['ptitle'] = htmlspecialchars($posting['ptitle']);

        if ($posting['slug'] == '') {
            $errors['slug'] = 'cannot be empty';
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
                    $errors['pic'] = 'Failed to upload';
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
                $errors['pic'] = 'php error code: ' . $_FILES['pic']['error'];
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
            $posting['pid'] = null;
            $this->posts->add($posting);
            $this->session->set_flashdata('message', 'Added post: ' . $pid);
        } else {
            $this->posts->update($posting);
            $this->session->set_flashdata('message', 'Updated post: ' . $pid);
        }
        
        // Tags are added after as they cannot be added to a nonexistant post
        if($pid == null){
            $newPost = (array)$this->posts->newest(1);
            $pid = $newPost[0]['pid'];
        }
        $this->tags_dao->addTags($pid, htmlspecialchars($tags));

        // Update the Syndicate
        $this->updateSyndicate($pid);
        
        // redisplay the list of users
        redirect('/postmtce');
    }

    // Delete a posting
    function delete($pid) {
        $this->posts->delete($pid);
        $this->session->set_flashdata('err_message', 'Post ' . $pid . ' deleted!');
        redirect('/postmtce');
    }

    function redirectErrors($errors, $pid = null) {
        
        $this->session->set_flashdata('posterr', $errors);
        if ($pid != null) {
            redirect('/postmtce/edit/' . $pid);
        } else {
            redirect('/postmtce/add');
        }
    }

    function getErrors() {
        $errors = $this->session->flashdata('posterr');
        $result = '';
        
        if($errors == NULL){
            return '';
        }

        if (isset($errors['title'])) {
            $viewParams['error_msg'] = 'Title must be set';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        if (isset($errors['slug'])) {
            $viewParams['error_msg'] = 'Slug must contain something';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        if (isset($errors['pic'])) {
            $viewParams['error_msg'] = 'Your picture could not be uploaded. It may be too big or an unsupported format';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        return $result;
    }
    
    function updateSyndicate($pid){
        $this->load->library('xmlrpc');
        $this->xmlrpc->server($this->_syndicateURL, $this->_syndicatePort);
        $this->xmlrpc->method('newpost');
        $params = array(
            $this->site_info->getCode(),
            $pid,
            $this->posts->getDateTime($pid),
            $this->posts->getLink($pid),
            $this->posts->getTitle($pid),
            $this->posts->getSlug($pid)
                );
        $this->xmlrpc->request($params);
        if(!$this->xmlrpc->send_request()){
            $this->session->set_flashdata('err_message', 'Error Syncing Syndicate: ' . $this->xmlrpc->display_error());
        }
        else{
          $this->session->set_flashdata('message', 'Synced post ' . $pid . ' with Syndicate');  
        }
    }

}

/* End of file postmtce.php */
/* Location: ./system/application/controllers/postmtce.php */