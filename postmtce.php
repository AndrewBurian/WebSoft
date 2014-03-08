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
            $this->data['post_edit'] = makeLinkButton('Edit', '/postmtce/edit/{pid}', 'Edit');
            $this->data['post_delete'] = makeLinkButton('Delete', '/postmtce/delete/{pid}', 'Delete');
        }
        $this->data['posts'] = $posts;
        $this->data['pagebody'] = 'postlist';

        $this->data['post_add'] = makeLinkButton('Add a post', '/postmtce/add', 'Add a post');

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
        $this->data['pid'] = 'new';
        $this->data['pagebody'] = 'postedit';

        $this->data['field_pic'] = makeImageUploader('Thumbnail', 'pic', '');
        $this->data['field_title'] = makeTextField('Post Title', 'ptitle', $posting['ptitle'], 'Title of the post');
        $this->data['field_date'] = makeDateSelector('Post Date', 'created', $posting['created'], 'The date of posting');
        $this->data['field_slug'] = makeTextArea('Slug', 'slug', $posting['slug'], 'Short Description of post', 140, 15, 1);
        $this->data['field_story'] = makeTextEditor('Story', 'story', $posting['story']);
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'submit');

        $this->render();
    }

    // Request a post edit
    function edit($pid) {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Edit a Posting";
        $this->data['pageDescrip'] = "Edit post";

        $posting = (array) $this->posts->get($pid);
        $this->data = array_merge($this->data, $posting);
        $this->data['pid'] = $posting['pid'];
        $this->data['pagebody'] = 'postedit';
        $this->data['field_pic'] = makeImageUploader('Thumbnail', 'pic', 'Leave blank to use existing');
        $this->data['field_title'] = makeTextField('Post Title', 'ptitle', $posting['ptitle'], 'Title of the post');
        $this->data['field_date'] = makeDateSelector('Post Date', 'created', $posting['created'], 'The date of posting', 10, TRUE);
        $this->data['field_slug'] = makeTextArea('Slug', 'slug', $posting['slug'], 'Short Description of post', 140, 15, 1);
        $this->data['field_story'] = makeTextEditor('Story', 'story', $posting['story']);
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'submit');
        $this->render();
    }

    // Process an add/edit form submission
    function submit($pid = null) {
        // the form fields we are interested in
        $post_fields = array('pid', 'user', 'ptitle', 'slug', 'story', 'created', 'updated', 'pic');
        $posting = array();

        // either create or retrieve the relevant user record
        if ($pid == null || $pid == 'new') {
            $pid = 'new';
            $posting = (array) $this->posts->create();
        } else {
            $posting = (array) $this->posts->get($pid);
        }

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $posting, $post_fields);

        if (!isset($posting['user'])) {
            $posting['user'] = $this->activeuser->getID();
        }

        // either add or update the posting record, as appropriate
        if ($pid == 'new') {
            $this->posts->add($posting);
        } else {
            $this->posts->update($posting);
        }

        // redisplay the list of users
        redirect("/postmtce");
    }

    // Delete a posting
    function delete($pid) {
        $this->posts->delete($pid);
        $this->index();
    }

}

/* End of file postmtce.php */
/* Location: ./system/application/controllers/postmtce.php */