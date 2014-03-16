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

    function info($request = null) {
        // set up the response, which is an array of structures
        $response = array();
        
        // load all the info into one array
        $info = array(
                array('code' => array('O07', 'string')),
                array('name' => array('Vancouver Pub Reviews', 'string')),
                array('link' => array('vancouverpubreviews.bcitxml.com', 'string')),
                array('plug' => array('Casual reviews of our favorite watering holes.', 'string'))
                );
        
        // load each of the info elements into the response as it's own struct
        foreach($info as $item){
            $response[] = array($item, 'struct');
        }
        
        // cast it back into one struct? What the actual fuck?
        $response = array($response, 'struct');
        
        // Send the mess back
        return $this->xmlrpc->send_response($response);
    }

    function latest($request = null) {
        $pid = $this->posts->getLatestID();
        
        $response = $this->makeSinglePostReply($pid);
        
        return $this->xmlrpc->send_response($response);
    }

    function allPosts($request = null) {
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
        
        $response = $this->makeSinglePostReply($pid);
        
        return $this->xmlrpc->send_response($response);
    }
    
    
    function makeSinglePostReply($pid){
        $response = array();
        
        // get the post information
        $post =  array(  array('code'      => 'O07'),
                         array('id'        => $pid),
                         array('datetime'  => $this->posts->getDateTime($pid)),
                         array('link'      => $this->posts->getLink($pid, true)),
                         array('title'     => $this->posts->getTitle($pid)),
                         array('slug'      => $this->posts->getSlug($pid)),
                        );
        
        // load each item into it's own flippin struct
        foreach($post as $item){
            $response[] = array($item, 'struct');
        }
        
        // cast it back to a single struct...
        $response = array($response, 'struct');
        
        return $response;
    }
}
