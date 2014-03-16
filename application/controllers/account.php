<?php

/**
 * Account management page.
 * 
 * controllers/accountMan.php
 *
 * ------------------------------------------------------------------------
 */
class Account extends Application {

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
        $this->data['pageDescrip'] = 'Change your avatar, email, or password';
        $this->data['pagebody'] = 'account';

        if (!$this->activeuser->isLoggedIn()) {
            redirect('/');
        }

        $this->data['user_image'] = $this->images_dao->getPath(
                $this->users_dao->getUserPic(
                        $this->activeuser->getID()
                )
        );
        $this->data['user_info'] = $this->getUserInfo();
        $this->data['user_options'] = $this->getUserOptions();
        $this->data['user_posts'] = $this->getUserPosts();


        $this->render();
    }

    function getUserOptions() {
        $result = '';
        if ($this->activeuser->isAuthorized(array(ROLE_ADMIN, ROLE_USER))) {
            $result .= '<li><a href="/postmtce">Add/Edit/Remove Posts</li>';
        }

        if ($this->activeuser->isAuthorized(ROLE_ADMIN)) {
            $result .= '<li><a href="/usermtce">Manage Users</li>';
            $result .= '<li><a href="/admin">Site Admin</li>';
        }
        return $result;
    }

    function getUserInfo() {
        $result = "";
        
        $result .= "<h4>" . $this->activeuser->getName() . '</h4>';
        $result .= $this->activeuser->getRole() . '<br/><br/><em>';
        $result .= $this->users_dao->getEmail($this->activeuser->getID()) . '</em>';
        return $result;
    }
    
    function getUserPosts() {
        $posts = $this->posts->getAllByUser($this->activeuser->getID());
        $result = '';
        $viewParams = array();
        foreach ($posts as $postId) {
            $post = (array) $this->posts->get($postId);
            $viewParams['ptitle'] = $post['ptitle'];
            $viewParams['pid'] = $post['pid'];
            $viewParams['tags'] = $this->tags_dao->getTagsLinks($post['pid']);
            $viewParams['slug'] = $post['slug'];
            $viewParams['img_src'] = $this->images_dao->getPath($post['pic']);
            $result .= $this->parser->parse('blog/_post', $viewParams, true);
            $result .= '<br/>';
        }

        return $result;
    }
}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */