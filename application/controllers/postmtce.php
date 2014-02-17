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
        $this->activeuser->restrict(ROLE_USER || ROLE_ADMIN);
    }

    //-------------------------------------------------------------
    //  The index should never be called!
    //-------------------------------------------------------------

    function index() {
        $this->data['pageTitle'] = "Java-Geeks ~ Posts";
        $posts = $this->posts->getAll_array();
        $this->data['posts'] = $posts;
        $this->data['pagebody'] = 'postlist';
        $this->render();
    }

    //-------------------------------------------------------------
    //  Trigger adding a new post
    //-------------------------------------------------------------

    function add() {
        $this->data['pageTitle'] = "Java-Geeks ~ Add a Posting";
        $posting = (array) $this->posts->create();
        $this->data = array_merge($this->data, $posting);
        $this->data['uid'] = 'new';
        $this->data['pagebody'] = 'postedit';
        $this->render();
    }

    // Request a post edit
    function edit($uid) {
        $this->data['pageTitle'] = "Java-Geeks ~ Edit a Posting";
        $posting = (array) $this->posts->get($uid);
        $this->data = array_merge($this->data, $posting);
        $this->data['uid'] = $posting['uid'];
        $this->data['pagebody'] = 'postedit';
        $this->render();
    }

    // Process an add/edit form submission
    function submit($uid = null) {
        // the form fields we are interested in
        $post_fields = array('thumb', 'ptitle', 'pdate', 'slug', 'story');

        // either create or retrieve the relevant user record
        if ($uid == null || $uid == 'new')
            $posting = $this->posts->create();
        else
            $posting = $this->posts->get($uid);

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $posting, $post_fields);

        // validate the posting fields
//        if ($_POST['id'] == 'new' || empty($_POST['id']))
//            $this->data['errors'][] = 'You need to specify a userid';
//        if ($id == null && $this->users->exists($_POST['id']))
//            $this->data['errors'][] = 'That userid is already used';
//        if (strlen($user->name) < 1)
//            $this->data['errors'][] = 'You need a user name';
//        if (strlen($user->email) < 1)
//            $this->data['errors'][] = 'You need an email address';
//        if (!strpos($user->email, '@'))
//            $this->data['errors'][] = 'The email address is missing the domain';
//        if ($id == null && empty($user->password))
//            $this->data['errors'][] = 'You must specify a password';
        // if errors, redisplay the form
        if (count($this->data['errors']) > 0) {
            // over-ride the view parameters to reflect our data
            $this->data = array_merge($this->data, (array) $posting);
            $this->data['pagebody'] = 'postedit';
            $this->render();
            exit;
        }

        // either add or update the posting record, as appropriate
        if ($uid == null) {
            $this->posts->add($posting);
        } else
            $this->posts->update($posting);

        // redisplay the list of users
        redirect('/postmtce');
    }

    // Delete a posting
    function delete($uid) {
        $this->posts->delete($uid);
        $this->index();
    }

}

/* End of file postmtce.php */
/* Location: ./system/application/controllers/postmtce.php */