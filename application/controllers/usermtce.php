<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * controllers/usermtce.php
 *
 * User table maintenance
 *
 * ------------------------------------------------------------------------
 */
class Usermtce extends Application {

    function __construct() {
        parent::__construct();
        $this->activeuser->restrict(ROLE_ADMIN);
        $this->load->model('users_dao');
        $this->load->model('images_dao');
    }

    //-------------------------------------------------------------
    //  Show the user list
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Users";
        $this->data['pageDescrip'] = "User maintenance functions";

        $users = $this->users_dao->getAll_array();
        foreach ($users as &$user) {
            $this->data['user_edit'] = makeLinkButton('Edit', '/usermtce/edit/{id}', 'Edit');
            $this->data['user_delete'] = makeLinkButton('Delete', '/usermtce/delete/{id}', 'Delete');
        }

        $this->data['users'] = $users;
        $this->data['pagebody'] = 'userlist';

        $this->data['user_add'] = makeLinkButton('Add a user', '/usermtce/add', 'Add a user');
        $this->data['cancel'] = makeLinkButton('Cancel', "/accountMan", 'Cancel');

        $this->render();
    }

    //-------------------------------------------------------------
    //  Trigger adding a new user
    //-------------------------------------------------------------

    function add() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Add a User";
        $this->data['pageDescrip'] = "Add user";
        $this->data['pagebody'] = 'useredit';

        $user = (array) $this->users_dao->create();
        $this->data = array_merge($this->data, $user);

        $this->data['field_errors'] = $this->getErrors();
        $this->data['field_name'] = makeTextField('User Name', 'name', '');
        $this->data['field_password'] = makeTextField('Password', 'password', '');
        $this->data['field_password_new'] = '';

        // See if the user is authorized to set a role
        if ($this->activeuser->isAuthorized(ROLE_ADMIN)) {
            $this->data['field_role'] = makeComboField('Role', 'role', ROLE_USER, $this->users_dao->allRoles);
        } else {
            $this->data['field_role'] = makeComboField('Role', 'role', ROLE_USER, array(ROLE_USER), '', 40, 25, true);
        }

        $this->data['field_email'] = makeTextField('Email', 'email', $user['email']);
        $this->data['field_status'] = makeComboField('Status', 'status', $user['status'], array('A', 'D'), 'A- Active, D- Dormant', 1, 3);
        $this->data['field_pic'] = makeImageUploader('Profile Picture', 'pic');
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'Submit');
        $this->data['cancel'] = makeLinkButton('Cancel', "/usermtce", 'Cancel');

        $this->render();
    }

    // Request a user edit
    function edit($id) {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Edit a User";
        $this->data['pageDescrip'] = "Edit user";

        $user = (array) $this->users_dao->get($id);
        $this->data = array_merge($this->data, $user);
        $this->data['pagebody'] = 'useredit';

        $this->data['field_errors'] = $this->getErrors();
        $this->data['field_name'] = makeTextField('User Name', 'name', $user['name']);
        $this->data['field_password'] = makePasswordField('Current Password', 'password', '', 'Required to make changes');
        $this->data['field_password_new'] = makePasswordField('New Password', 'newpassword', '', 'Leave this blank if you do not wish to change your password');
        // See if the user is authorized to set a role
        if ($this->activeuser->isAuthorized(ROLE_ADMIN)) {
            $this->data['field_role'] = makeComboField('Role', 'role', $user['role'], $this->users_dao->allRoles);
        } else {
            $this->data['field_role'] = makeComboField('Role', 'role', $user['role'], array(ROLE_USER), '', 40, 25, true);
        }
        $this->data['field_email'] = makeTextField('Email', 'email', $user['email']);
        $this->data['field_status'] = makeComboField('Status', 'status', $user['status'], array('A', 'D'), 'A- Active, D- Dormant', 1, 3);
        $this->data['field_pic'] = makeImageUploader('Profile Picture', 'pic');
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'Submit');
        $this->data['cancel'] = makeLinkButton('Cancel', "/usermtce", 'Cancel');

        $this->render();
    }

    // Process an add/edit form submission
    function submit($id = null) {

        $errors = array();

        // the form fields we are interested in
        $user_fields = array('name', 'role', 'email', 'status', 'pic');

        // either create or retrieve the relevant user record
        if ($id == null || $id == 'new') {
            $id = null;
            $user = $this->users_dao->create();
        } else {
            $user = $this->users_dao->get($id);
        }

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $user, $user_fields);

        $user = (array) $user;

        if ($user['name'] == '') {
            $errors[] = 'name';
        }

        if ($_POST['password'] == '') {
            $errors[] = 'password';
        } else {

            // If they're editing a user, password required
            if ($id != null) {
                if (!$this->users_dao->authenticateUser($id, $_POST['password'])) {
                    $errors[] = 'passchk';
                } else {
                    if (isset($_POST['password_new'])) {
                        // their old password is correct and there is a new one
                        $user['password'] = md5($_POST['password_new']);
                    }
                }
            } else {
                // new user, just accept new password
                $user['password'] = md5($_POST['password']);
            }
        }
        switch ($user['role']) {
            case 0:
                $user['role'] = ROLE_USER;
                break;
            case 1:
                $user['role'] = ROLE_ADMIN;
                break;
            case 2:
                $user['role'] = ROLE_VISITOR;
                break;
            case 3:
                $user['role'] = ROLE_GUEST;
                break;
        }

        switch ($user['status']) {
            case 0: $user['status'] = 'A';
                break;
            case 1: $user['status'] = 'D';
                break;
        }

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'email';
        }

        if ($user['pic'] == '') {
            $user['pic'] = 0;
        }

        // Check to see if there is a valid upload
        if ($_FILES['pic']['error'] === UPLOAD_ERR_OK) {
            $imgid = $this->images_dao->addFile($_FILES['pic']);
            if ($imgid == 0) {
                // image failed to upload
                $errors[] = 'pic';
            } else {
                $user['pic'] = $imgid;
            }
        }

        // check to see if there was an error
        else if ($_FILES['pic']['error'] === UPLOAD_ERR_NO_FILE) {
            // no file selected
            // leave file
        } else {
            // some other error occured
            $errors[] = 'pic';
        }

        // if there are errors, redirect
        if (count($errors) > 0) {
            $this->redirectErrors($errors, $id);
            exit;
        }

        // either add or update the user record, as appropriate
        if ($id == null) {
            $this->users_dao->add($user);
        } else {
            $this->users_dao->update($user);
        }
        // redisplay the list of users
        redirect('usermtce');
    }

    // Delete a user
    function delete($id) {
        $this->users_dao->delete($id);
        $this->index();
    }

    function redirectErrors($errors, $id = null) {
        $get = '?';
        foreach ($errors as $error) {
            $get .= $error . '=err&';
        }
        if ($id != null) {
            redirect('/usermtce/edit/' . $id . $get);
        } else {
            redirect('/usermtce/add' . $get);
        }
    }

    function getErrors() {
        $result = '';
        $viewParams = array();
        $viewParams['error_msg'] = '';

        if (isset($_GET['name'])) {
            $viewParams['error_msg'] = 'Your name cannot be empty';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        if (isset($_GET['password'])) {
            $viewParams['error_msg'] = 'Your passowrd cannot be empty';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        if (isset($_GET['email'])) {
            $viewParams['error_msg'] = 'Your email is not valid';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        if (isset($_GET['pic'])) {
            $viewParams['error_msg'] = 'Your picture could not be uploaded. It may be too big or an unsupported format';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        if (isset($_GET['passchk'])) {
            $viewParams['error_msg'] = 'Your password is incorrect';
            $result .= $this->parser->parse('error_fragment', $viewParams, true);
        }

        return $result;
    }

}

/* End of file usermtce.php */
/* Location: ./system/application/controllers/usermtce.php */