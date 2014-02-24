<?php

/**
 * Account management page.
 * 
 * controllers/accountMan.php
 *
 * ------------------------------------------------------------------------
 */
class AccountMan extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['page'] = 'Account Management';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Manage your account';
        $this->data['pageDescrip'] = 'Lorem ipsum dolor amet sit consectetur adipiscing';
        $this->data['pagebody'] = 'accountMan';
        $this->data['pageOptions'] = $this->build_Account_Man_page();
        if ($this->activeuser->isLoggedIn()) {
            $this->data['user_name'] = $this->activeuser->getName();
            $this->data['role'] = $this->activeuser->GetRole();
        }
        $this->render();
    }

    function build_Account_Man_page() {
        $result = '';
        if ($this->activeuser->isAuthorized(ROLE_ADMIN)) {
            $this->data['userMan'] = makeLinkButton('User Management', "/usermtce", 'User Management');
            $result .= $this->parser->parse("/management/_admin", $this->data, true);
        }
        if ($this->activeuser->isAuthorized(ROLE_USER || ROLE_ADMIN)) {
            
            $this->data['postMan'] = makeLinkButton('Post Management', "/postmtce", 'Post Management');
            $result .= $this->parser->parse('management/_user', $this->data, true);
        }
        return $result;
    }
}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */