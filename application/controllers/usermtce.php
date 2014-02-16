<?php

/**
 * controllers/usermtce.php
 *
 * User table maintenance
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Usermtce extends Application {

    function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
    }

    //-------------------------------------------------------------
    //  Show the user list
    //-------------------------------------------------------------

    function index() {
        $this->data['pageTitle'] = "Java-Geeks ~ Users";
        $users = $this->users->getAll_array();
        $this->data['users'] = $users;
        $this->data['pagebody'] = 'userlist';
        $this->render();
    }

    //-------------------------------------------------------------
    //  Trigger adding a new user
    //-------------------------------------------------------------

    function add() {
        $this->data['pageTitle'] = "Java-Geeks ~ Add a User";
        $user = (array) $this->users->create();
        $this->data = array_merge($this->data, $user);
        $this->data['id'] = 'new';
        $this->data['pagebody'] = 'useredit';
        $this->render();
    }

    // Request a user edit
    function edit($id) {
        $this->data['pageTitle'] = "Java-Geeks ~ Edit a User";
        $user = (array) $this->users->get($id);
        $this->data = array_merge($this->data, $user);
        $this->data['id'] = $user['id'];
        $this->data['password'] = ''; // assume password to remain the same
        $this->data['pagebody'] = 'useredit';
        $this->render();
    }

    // Process an add/edit form submission
    function submit($id = null) {
        // the form fields we are interested in
        $user_fields = array('name', 'email', 'role', 'status',
            'lastvisited');

        // either create or retrieve the relevant user record
        if ($id == null || $id == 'new') {
            $id = null;
            $user = $this->users->create();
        } else {
            $user = $this->users->get($id);
        }

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $user, $user_fields);

        // validate the user fields
        if (empty($_POST['id'])) {
            $this->data['errors'][] = 'You need to specify a userid';
        }
         if ($_POST['id'] == 'new') {
            $this->data['errors'][] = 'new is not a valid userid';
        }
        if ($id == null && $this->users->exists($_POST['id'])) {
            $this->data['errors'][] = 'That userid is already used';
        }
        if (strlen($user->name) < 1) {
            $this->data['errors'][] = 'You need a user name';
        }
        if (strlen($user->email) < 1) {
            $this->data['errors'][] = 'You need an email address';
        }
        if (!strpos($user->email, '@')) {
            $this->data['errors'][] = 'The email address is missing the domain';
        }

        // if errors, redisplay the form
        if (count($this->data['errors']) > 0) {
            // over-ride the view parameters to reflect our data
            $this->data = array_merge($this->data, (array) $user);
            $this->data['pagebody'] = 'useredit';
            $this->render();
             foreach ($this->data['errors'] as $booboo)
            echo '<p>' . $booboo . '</p>';
             exit;
        }
        // handle the password specially, as it needs to be encrypted
        $new_password = $_POST['password'];
        if (!empty($new_password)) {
            $new_password = md5($new_password);
            //  if ($new_password != $user['password'])
            $user->password = $new_password;
        }
        if ($id == null && empty($user->password)) {
            $this->data['errors'][] = 'You must specify a password';
        }
        // either add or update the user record, as appropriate
        if ($id == null) {
            $user->id = $_POST['id'];
            $this->users->add($user);
        } else {
            $this->users->update($user);
        }
        // redisplay the list of users
        redirect('/usermtce');
    }
    // Delete a user
    function delete($id) {
        $this->users->delete($id);
        $this->index();
    }

}

/* End of file usermtce.php */
/* Location: ./system/application/controllers/usermtce.php */