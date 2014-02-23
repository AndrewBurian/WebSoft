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
        $this->data['title'] = '?';
        $this->errors = array();
        $this->data['pageTitle'] = '??';
    }

    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->build_menu_bar($this->config->item('menu_choices'));
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['session_id'] = $this->session->userdata('session_id');
        $this->data['login'] = $this->activeuser->buildLoginBar();
        
        // Caboose
        $this->data['caboose_styles'] = $this->caboose->styles();
        $this->data['caboose_scripts'] = $this->caboose->scripts();
        $this->data['caboose_trailings'] = $this->caboose->trailings();
        
        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    /**
     * Build an unordered list of linked items, such as used for a menu bar.
     * @param mixed $choices Array of name=>link pairs
     */
    function build_menu_bar($choices) {
        $menudata = array();
        foreach ($choices as $name => $link)
            $menudata['menudata'][] = array('menulink' => $link, 'menuname' => $name);
        // if($this->session->userdata['role']=='admin')
        if ($this->activeuser->isLoggedIn()) {
            if ($this->activeuser->isAuthorized(ROLE_ADMIN)) {
                $menudata['menudata'][] = array('menulink' => '/usermtce', 'menuname' => 'User Man.');
            }
            if ($this->activeuser->isAuthorized(ROLE_USER) || $this->activeuser->isAuthorized(ROLE_ADMIN)) {
                $menudata['menudata'][] = array('menulink' => '/postmtce', 'menuname' => 'Post Man.');
            }
        }
        return $this->parser->parse('_menubar', $menudata, true);
    }

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */