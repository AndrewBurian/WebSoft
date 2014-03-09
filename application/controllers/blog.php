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
        $this->data['page'] = 'Blog';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Blog';
        $this->data['pageDescrip'] = 'Donec ac dui eu augue faucibus sagittis ';
        $this->data['pagebody'] = 'blog/blog';

        $this->data['tag_list'] = $this->buildTagSidebar();
        $this->data['posts'] = $this->defaultPosts();
        
        // Cheat the pagination for the landing page
        $this->data['pagination'] = '<strong>1</strong> | <a href="/blog/post/2">Older</a>';

        $this->render();
    }

    function post($count = 1) {
        $this->data['page'] = 'Blog';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Blog';
        $this->data['pageDescrip'] = 'Donec ac dui eu augue faucibus sagittis ';
        $this->data['pagebody'] = 'blog/blog';
        $this->data['tag_list'] = $this->buildTagSidebar();
        
        // TO-DO Actual pagination logic here...
        $this->data['posts'] = $this->defaultPosts();
        $this->data['pagination'] = $this->makePaginationArrows($count, $count -1, $count +1);
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
        $postIDs = $this->tags_dao->getPostsWithTag($tag);
        sort($postIDs, SORT_NUMERIC);

        $this->data['posts'] = $this->processPostsByID($postIDs);

        $this->data['pagination'] = $this->makePaginationArrows($count, $count -1, $count +1, $tag);
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