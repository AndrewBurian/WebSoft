<?php

/**
 * About page.
 * 
 * controllers/about.php
 *
 * ------------------------------------------------------------------------
 */
class Capo extends Application {

    function __construct() {
        parent::__construct();

        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');

        $config['functions']['info'] = array('function' => 'Capo.info');
        $config['functions']['latest'] = array('function' => 'Capo.latest');
        $config['functions']['posts'] = array('function' => 'Capo.allPosts');
        $config['functions']['post'] = array('function' => 'Capo.singlePost');
        $config['object'] = $this;

        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    function info($request) {
        $response = array(array('code' => array('O07', 'string'),
                'name' => array('Vancouver Pub Reviews', 'string'),
                'link' => array('vancouverpubreviews.bcitxml.com', 'string'),
                'plug' => array('Casual reviews of our favorite watering holes.', 'string')
            ),
            'struct');

        return $this->xmlrpc->send_response($response);
    }

    function latest($request) {
        $pid = $this->posts->getLatestID();
        $response = array(
                            array(  'code'      => 'O07',
                                    'id'        => $pid,
                                    'datetime'  => $this->posts->getDateTime($pid),
                                    'link'      => $this->posts->getLink($pid, true),
                                    'title'     => $this->posts->getTitle($pid),
                                    'slug'      => $this->posts->getSlug($pid),
                                ),
                    'struct');
        return $this->xmlrpc->send_response($response);
    }

    function allPosts($request) {
        // get the upper limit to post id's
        $maxPid = $this->posts->getLatestID();
        
        // this will hold the collection of post structs
        $allPostsArray = array();
        
        // this is an array for a single post
        $singlePost = array();
        
        // since it's constant
        $singlePost['code'] = 'O07';
        
        // loop through all possible posts
        for($pid = 1; $pid <= $maxPid; $pid++){
            
            // Check if the post exitst
            if($this->posts->exists($pid)){
                
                // if the post exists, set it's info
                $singlePost['id'] = $pid;
                $singlePost['datetime'] = $this->posts->getDateTime($pid);
                $singlePost['link'] = $this->posts->getLink($pid, true);
                $singlePost['title'] = $this->posts->getTitle($pid);
                $singlePost['slug'] = $this->posts->getSlug($pid);
                
                // add it to the collection of all posts as a "struct"
                $allPostsArray[] = array($singlePost, 'struct');
            }
        }
        
        // Add the collection of posts to a "struct" for response
        $response = array($allPostsArray, 'struct');
        
        // Send the response
        return $this->xmlrpc->send_response($response);
    }

    function singlePost($request) {
        
        // Extract the request into params
        $parameters = $request->output_parameters();
        
        // Check to make sure the parameter is actually set
        if(!isset($parameters['0'])){
             return $this->xmlrpc->send_error_message('100', 'Invalid param 0');
        }
        
        $pid = $parameters['0'];
        
        // Check to make sure the desired post exists
        if(!$this->posts->exists($pid)){
             return $this->xmlrpc->send_error_message('404', 'Post not found');
        }
        
        // Create the response structure
        $response = array(
                            array(  'code'      => 'O07',
                                    'id'        => $pid,
                                    'datetime'  => $this->posts->getDateTime($pid),
                                    'link'      => $this->posts->getLink($pid, true),
                                    'title'     => $this->posts->getTitle($pid),
                                    'slug'      => $this->posts->getSlug($pid),
                                ),
                    'struct');
        
        return $this->xmlrpc->send_response($response);
    }

}
