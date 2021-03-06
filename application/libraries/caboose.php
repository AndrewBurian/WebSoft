<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class to build stuff to tack on at the end of the <body>.
 * 
 * @author		JLP
 * @copyright           Copyright (c) 2013, James L. Parry
 *                      Used by Galiano Island Chamber of Commerce, with permission
 *
 */
class Caboose {

    var $result;   // where the finished form will be stored
    var $CI; // handle to CodeIgniter instance
    // define the components
    var $components = array(
        'date' => array(
            'css' => 'datepicker.css',
            'js' => 'bootstrap-datepicker.js',
            'template' => 'date'
        ),
        'time' => array(
            'css' => 'bootstrap-timepicker.css',
            'js' => 'bootstrap-timepicker.js',
            'template' => 'time'
        ),
        'editor' => array(
            'css' => array('tinyeditor.css', 'undestroy.css'),
            'js' => 'tiny.editor.packed.js',
            'template' => 'editor'
        ),
        'lightbox' => array(
            'css' => 'jquery.lightbox-0.5.css',
            'js' => 'jquery.lightbox-0.5.min.js',
            'template' => 'lightbox'
        ),
        'nod' => array(
            'css' => 'nod.css',
            'js' => 'nod.js',
            'template' => 'nod'
        ),
        'awesome' => array(
            'css' => 'font-awesome.min.css',
            'js' => '',
            'template' => ''
        ),
        'smover' => array(
            'css' => 'smover.css',
            'js' => 'hoverintent.js,jquery.smover.min.js',
            'template' => 'smover'
        ),
        // Note: jRating plugin is based on CSS class, not on CSS ID
        'rating' => array(
            'css' => 'jRating.jquery.css',
            'js' => 'jRating.jquery.js',
            'template' => 'rating'
        ),
        'CKEditor' => array(
            'css' => '',
            'js' => 'ckeditor/ckeditor.js',
            'template' => 'ckeditor'
        )
    );
    // provide for any fields they need. this should be indexed [component][field]
    var $fields = array();
    // provide for any field validations needed
    var $validations = array();

    /**
     * Constructor - Start the ball rolling.
     */
    function __construct() {
        $this->CI = &get_instance(); // handle to CodeIgniter instance
        $this->result = '';
    }

    /**
     * specify something that we need 
     */
    function needed($what, $field = null) {
        // ignore unrecognized components
        if (!isset($this->components[$what]))
            return;
        if ($field == null)
            $this->fields[$what] = array(); // remember tht we need this component
        else
            $this->fields[$what][] = $field;    // remember a field we need it for
    }

    /**
     * specify a field validation needed
     */
    function validate($field, $rule, $message) {
        // bypass for now
//        $this->needed('nod');
//        $row = array(
//            'selector' => '#' . $field,
//            'rule' => $rule,
//            'message' => $message
//        );
//        $this->validations[] = $row;
    }

    /**
     * Generate style elements for any components used 
     */
    function styles() {
        $result = '';

        // generate any needed CSS references
        foreach ($this->fields as $component => $needed) {
            $css = $this->components[$component]['css'];
            if (!empty($css)) {
                if (is_array($css)) {
                    foreach ($css as $filename)
                        $result .= '<link rel="stylesheet" type="text/css" href="/assets/css/' . $filename . '"/>' . PHP_EOL;
                } else
                    $result .= '<link rel="stylesheet" type="text/css" href="/assets/css/' . $css . '"/>' . PHP_EOL;
            }
        }
        return $result;
    }

    /**
     * Generate script elements for any components used 
     */
    function scripts() {
        $result = '';

        // load any needed javascript files
        foreach ($this->fields as $component => $needed) {
            $js = $this->components[$component]['js'];
            if (!empty($js)) {
                if (is_array($js)) {
                    foreach ($js as $filename)
                        $result .= '<script src="/assets/js/' . $filename . '"></script>' . PHP_EOL;
                } else
                    $result .= '<script src="/assets/js/' . $js . '"></script>' . PHP_EOL;
            }
        }

        // bind the fields the components are to be used for
        $result .= '<script>' . PHP_EOL;
        foreach ($this->fields as $component => $needed) {
            $template = $this->components[$component]['template'];
            if (!empty($template) && !empty($needed)) {
                if (is_array($needed)) {
                    foreach ($needed as $fieldname)
                        $result .= $this->bind($fieldname, $template);
                } else
                    $result .= $this->bind($needed, $template);
            }
        }
        $result .= '</script>' . PHP_EOL;

        // arrange any validations
//        if (isset($this->fields['nod'])) {
//            $template = $this->components['nod']['template'];
//            $result .= '<script>' . PHP_EOL;
//            $parms = array('metrics' => $this->validations);
//            $CI = &get_instance(); // handle to CodeIgniter instance
//            $result .= $CI->parser->parse('_components/' . $template, $parms, true);
//            $result .= '</script>' . PHP_EOL;
//        }

        return $result;
    }

    /**
     * Bind a field to a template 
     */
    function bind($field, $template) {
        $parms = array('field' => $field);
        $CI = &get_instance(); // handle to CodeIgniter instance
        $result = $CI->parser->parse('_components/' . $template, $parms, true);
        return $result;
    }

    /**
     * Tack something on to the end of the page.
     * @param string $what The stuff (elements) to tack on.
     */
    function trailer($what) {
        $this->result .= $what;
    }

    /**
     * Return everything that is supposed to be tacked onto the end.
     * @return string 
     */
    function trailings() {
        return $this->result;
    }

}

/* End of file bs_form.php */
/* Location: ./application/libraries/bs_form.php */