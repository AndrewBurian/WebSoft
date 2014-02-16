<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = 'java-geeks.com ... caffeinated ramblings';
        $this->data['errors'] = array();
        $this->data['pageTitle'] = 'Caffeinated Ramblings';
    }

    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->build_menu_bar($this->config->item('menu_choices'));
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['sidebar'] = $this->build_side_bar();
        $this->data['sessionid'] = $this->session->userdata('session_id');
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    /**
     * Build an unordered list of linked items, such as used for a menu bar.
     * Assumption: that the URL helper has been loaded.
     * @param mixed $choices Array of name=>link pairs
     */
    function build_menu_bar($choices) {
        $result = '<ul>';
        foreach ($choices as $name => $link)
            $result .= '<li>' . anchor($link, $name) . '</li>';
        $result .= '</ul>';
        return $result;
    }

    /**
     * Build the collection of stuff that should appear down the right.
     * This will be empty for now.
     */
    function build_side_bar() {
        $result = '';

        if ($this->session->userdata('id')) {
            // show user name etc
            $side_data = $this->session->all_userdata();
            $side_data['secret_menu'] = '';
            if ($this->session->userdata('userRole') == 'user')
                $side_data['secret_menu'] = $this->parser->parse('_user', $side_data, true);
            else if ($this->session->userdata('userRole') == 'admin')
                $side_data['secret_menu'] = $this->parser->parse('_admin', $side_data, true);
            $result .= $this->parser->parse('_loggedin', $side_data, true);
        } else {
            // show the login form
            $result .= $this->load->view('_login', $this->data, true);
        }

        // links
        //   $result .= $this->link_away();

        return $result;
    }

    /**
     * Present a nicely presented set of links for our favorites 
     */
    function link_away() {
        $links = array(
            array('name' => 'Blenz Coffee', 'link' => 'blenz.com/'),
            array('name' => 'Coffee &amp; Conservation', 'link' => 'www.coffeehabitat.com/'),
            array('name' => 'Coffee AM', 'link' => 'www.coffeeam.com/'),
            array('name' => 'Coffee Geek', 'link' => 'www.coffeegeek.com/'),
            array('name' => 'Coffee Research', 'link' => 'www.coffeeresearch.org/'),
            array('name' => 'e-Barista', 'link' => 'www.e-barista.com/'),
            array('name' => 'Espresso Tec', 'link' => 'www.espressotec.com/'),
            array('name' => 'Rocanini Coffee Roasters', 'link' => 'www.rocanini.com/'),
            array('name' => 'Starbucks Coffee', 'link' => 'www.starbucks.ca/'),
            array('name' => 'Steveston Coffee Co', 'link' => 'www.stevestoncoffee.com/'),
            array('name' => 'Waves Coffee House', 'link' => 'wavescoffee.com/'),
            array('name' => '49th Parallel Roasters', 'link' => 'www.49thparallelroasters.com'),
        );
        $data['links'] = $links;
        return $this->parser->parse('_links', $data, true);
    }

    /**
     * Enforce role-based authentication.
     * @param string $roleNeeded 
     */
    function restrict($roleNeeded = null) {
        // if we need a role, turn away anyone without the right role
        if ($roleNeeded != null) {
            $userRole = $this->session->userdata('userRole');
            if (!$userRole) {
                // no one is logged in, goodbye
                redirect("/");
                exit;
            }
            // logged in. check the role they have
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                    // Not authorized. Redirect to home page
                    redirect("/");
                    exit;
                }
            } elseif ($userRole != $roleNeeded) {
                redirect("/");
                exit;
            }
        }
    }

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */