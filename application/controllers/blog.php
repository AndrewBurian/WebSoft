<?php

/**
 * Blog page.
 * 
 * controllers/blog.php
 *
 * ------------------------------------------------------------------------
 */
class Blog extends Application {

    var $_postsPerPage = 5;

    function __construct() {
        parent::__construct();

        $this->load->model('posts');
        $this->load->model('images_dao');
        $this->load->model('tags_dao');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        // default landing is the same as blog/post/1
        $this->post();
    }

    function post($count = 1) {
        $this->data['page'] = 'Blog';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Blog';
        $this->data['pageDescrip'] = 'Donec ac dui eu augue faucibus sagittis ';
        $this->data['pagebody'] = 'blog/blog';
        $this->data['tag_list'] = $this->buildTagSidebar();
        
        // TO-DO Actual pagination logic here...
        $allPosts = $this->posts->getAll_array();
        $allIds = array();
        foreach($allPosts as $post){
            $allIds[] = (int)$post['pid'];
        }
        rsort($allIds);

        $postIdsOnPage = array();
        $thisCount = 0;
        for($i = ($count-1) * $this->_postsPerPage; $i < count($allIds) && $thisCount < 5; $i++){
            $postIdsOnPage[] = $allIds[$i];
            $thisCount++;
        }
        $this->data['posts'] = $this->processPostsByID($postIdsOnPage);
        $prev = $count -1;
        $next = $count +1;
        if($i == 0){
            $prev = 0;
        }
        if($i == count($allIds)){
            $next = 0;
        }
        $this->data['pagination'] = $this->makePaginationArrows($count, $prev, $next);
        $this->render();
    }

    function tag($tag = null, $count = 1) {
        if ($tag == null) {
            redirect('/blog');
        }

        $this->data['page'] = 'Blog';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Blog';
        $this->data['pageDescrip'] = 'Donec ac dui eu augue faucibus sagittis ';
        $this->data['pagebody'] = 'blog/blog';
        $this->data['tag_list'] = $this->buildTagSidebar();

        // TO-DO Actual pagination logic here...
        $allIds = $this->tags_dao->getPostsWithTag($tag);
        rsort($allIds);

        $postIdsOnPage = array();
        $thisCount = 0;
        for($i = ($count-1) * $this->_postsPerPage; $i < count($allIds) && $thisCount < 5; $i++){
            $postIdsOnPage[] = $allIds[$i];
            $thisCount++;
        }
        $this->data['posts'] = $this->processPostsByID($postIdsOnPage);
        $prev = $count -1;
        $next = $count +1;
        if($i == 0){
            $prev = 0;
        }
        if($i == count($allIds)){
            $next = 0;
        }
        $this->data['pagination'] = $this->makePaginationArrows($count, $prev, $next);
        $this->render();
    }

    function defaultPosts() {
        $posts = $this->posts->newest($this->_postsPerPage);
        return $this->processPosts($posts);
    }

    function processPosts($posts) {
        $result = '';
        $viewParams = array();
        foreach ($posts as $post) {
            $viewParams['ptitle'] = $post['ptitle'];
            $viewParams['pid'] = $post['pid'];
            $viewParams['tags'] = $this->tags_dao->getTagsLinks($post['pid']);
            $viewParams['slug'] = $post['slug'];
            $viewParams['img_src'] = $this->images_dao->getPath($post['pic']);
            $result .= $this->parser->parse('blog/_post', $viewParams, true);
        }

        return $result;
    }

    function processPostsByID($posts) {
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
        }

        return $result;
    }

    function buildTagSidebar() {
        $result = '';
        $allTags = $this->tags_dao->getTagsArray();
        $viewParams = array();
        foreach ($allTags as $tag) {
            $viewParams['tag'] = $tag;
            $result .= $this->parser->parse('blog/_tagSidebar', $viewParams, true);
        }
        return $result;
    }

    function makePaginationArrows($current, $prev = 0, $next = 0, $tag = null) {
        $result = '';
        if ($tag != null) {
            if ($prev != 0) {
                $result .= '<a href="/blog/tag/' . $tag . '/' . $prev . '">Newer</a> | ';
            }
            $result .= '<strong>' . $current . '</strong>';
            if($next != 0) {
                $result .= ' | <a href="/blog/tag/' . $tag . '/' . $next . '">Older</a>';
            }
        }
        else{
            if ($prev != 0) {
                $result .= '<a href="/blog/post/' . $prev . '">Newer</a> | ';
            }
            $result .= '<strong>' . $current . '</strong>';
            if($next != 0) {
                $result .= ' | <a href="/blog/post/' . $next . '">Older</a>';
            }
        }
        
        return $result;
    }

}

/* End of file blog.php */
/* Location: application/controllers/blog.php */