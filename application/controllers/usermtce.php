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
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Users";
        $this->data['pageDescrip'] = "User maintenance functions";

        $users = $this->users_dao->getAll_array();
        $this->data['users'] = $users;
        $this->data['pagebody'] = 'userlist';
        $this->render();
    }

    //-------------------------------------------------------------
    //  Trigger adding a new user
    //-------------------------------------------------------------

    function add() {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Add a User";
        $this->data['pageDescrip'] = "Add user";

        $user = (array) $this->users_dao->create();
        $this->data = array_merge($this->data, $user);
        $this->data['id'] = 'new';
         
        $this->data['field_name'] = makeTextField('User Name', 'name', '');
        $this->data['field_password'] = makeTextField('Password', 'password', '');
        $this->data['field_password_new'] = '';
        
        // See if the user is authorized to set a role
        if($this->activeuser->isAuthorized(ROLE_ADMIN)){
            $this->data['field_role'] = makeComboField('Role', 'role', ROLE_USER, $this->users_dao->allRoles);
        } else{
            $this->data['field_role'] = makeComboField('Role', 'role', ROLE_USER, array(ROLE_USER), '', 40, 25, true);
        }
        
        $this->data['field_email'] = makeTextField('Email', 'email', $user['email']);
        $this->data['field_status'] = makeComboField('Status', 'status', $user['status'], array('A','D'), 'A- Active, D- Dormant', 1, 3);
        $this->data['field_pic'] = makeImageUploader('Profile Picture', 'pic');
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'Submit');
        
        $this->render();
    }

    // Request a user edit
    function edit($id) {
        $this->data['title'] = "Greater Vancouver Pub Reviews";
        $this->data['pageTitle'] = "Greater Vancouver Pub Reviews ~ Edit a User";
        $this->data['pageDescrip'] = "Edt user";

        $user = (array) $this->users_dao->get($id);
        $this->data = array_merge($this->data, $user);
        $this->data['id'] = $user['id'];
        $this->data['pagebody'] = 'useredit';
        
        $this->data['field_name'] = makeTextField('User Name', 'name', $user['name']);
        $this->data['field_password'] = makePasswordField('Current Password', 'password', '', 'Required to make changes');
        $this->data['field_password_new'] = makePasswordField('New Password', 'newpassword', '', 'Leave this blank if you do not wish to change your password');
        // See if the user is authorized to set a role
        if($this->activeuser->isAuthorized(ROLE_ADMIN)){
            $this->data['field_role'] = makeComboField('Role', 'role', $user['role'], $this->users_dao->allRoles);
        } else{
            $this->data['field_role'] = makeComboField('Role', 'role', $user['role'], array(ROLE_USER), '', 40, 25, true);
        }
        $this->data['field_email'] = makeTextField('Email', 'email', $user['email']);
        $this->data['field_status'] = makeComboField('Status', 'status', $user['status'], array('A','D'), 'A- Active, D- Dormant', 1, 3);
        $this->data['field_pic'] = makeImageUploader('Profile Picture', 'pic');
        $this->data['field_submit_btn'] = makeSubmitButton('Submit', 'Submit');
        
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
            $user = $this->users_dao->create();
        } else {
            $user = $this->users_dao->get($id);
        }
        
        if(isset($_FILES['pic'])){
            if(!$this->images_dao->safeAddFile($_FILES['pic'])){
                // image failed to upload
                redirect('/usermtce');
                exit;
                // should be handled better
            }
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
        if ($id == null && $this->users_dao->exists($_POST['id'])) {
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
            $this->users_dao->add($user);
        } else {
            $this->users_dao->update($user);
        }
        // redisplay the list of users
        redirect('/usermtce');
    }

    // Delete a user
    function delete($id) {
        $this->users_dao->delete($id);
        $this->index();
    }

}

/* End of file usermtce.php */
/* Location: ./system/application/controllers/usermtce.php */