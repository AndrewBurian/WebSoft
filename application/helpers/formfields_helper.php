<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/forms_helper.php
 *
 * Functions to help with form generation
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2013, James L. Parry
 *                      Used by Galiano Island Chamber of Commerce, with permission
 *
 * Updated              v4.0.0: Port to CI2.0
 * Updated              v5.0: Reskin with bootstrap
 * ------------------------------------------------------------------------
 */

/**
 *  Construct a text input.
 * 
 * @param string $label Descriptive label for the control
 * @param string $name ID and name of the control; s/b the same as the RDB table column
 * @param mixed $value Initial value for the control
 * @param string $explain Help text for the control
 * @param int $maxlen Maximum length of the value, characters
 * @param int $size width in ems of the input control
 * @param boolean $disabled True if non-editable
 */
function makeTextField($label, $name, $value, $explain = "", $maxlen = 40, $size = 25, $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
        'maxlen' => $maxlen,
        'size' => $size,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/textfield', $parms, $keep);
}

/**
 *  Construct a bogus input field, used to detect bots.
 * 
 * @param string $label Descriptive label for the control
 * @param string $name ID and name of the control; s/b the same as the RDB table column
 */
function makeBogusField($label, $name) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name
    );
    return $CI->parser->parse('_fields/bogusfield', $parms);
}

/**
 *  Construct a password text input.
 * 
 * @param string $label Descriptive label for the control
 * @param string $name ID and name of the control; s/b the same as the RDB table column
 * @param mixed $value Initial value for the control
 * @param string $explain Help text for the control
 * @param int $maxlen Maximum length of the value, characters
 * @param int $size width in ems of the input control
 * @param boolean $disabled True if non-editable
 */
function makePasswordField($label, $name, $value, $explain = "", $maxlen = 40, $size = 25, $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
        'maxlen' => $maxlen,
        'size' => $size,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/password', $parms, $keep);
}

/**
 * Construct a form row to edit a combo box field.
 * 
 * @param string $label Descriptive label for the control
 * @param string $name ID and name of the control; s/b the same as the RDB table column
 * @param string $value Initial value for the control
 * @param mixed $options Array of key/value pairs for the combobox
 * @param string $explain Help text for the control
 * @param int $maxlen Maximum length of the value, characters
 * @param int $size width in ems of the input control
 * @param boolean $disabled True if non-editable
 */
function makeComboField($label, $name, $value, $options, $explain = "", $maxlen = 40, $size = 25, $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
        'maxlen' => $maxlen,
        'size' => $size,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );

    $choices = array();
    foreach ($options as $val => $display) {
        $row = array(
            'val' => $val,
            'selected' => ($val == $value) ? 'selected="true"' : '',
            'display' => htmlentities($display)
        );
        $choices[] = $row;
    }
    $parms['options'] = $choices;

    return $CI->parser->parse('_fields/combofield', $parms, $keep);
}

/**
 * Make a link button.
 * 
 * @param string $label Label to appear on the button
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param string $css_extras Extra CSS class information
 */
function makeLinkButton($label, $href, $title, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'href' => $href,
        'title' => $title,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/link', $parms, $keep);
}

/**
 * Make an icon button.
 * 
 * @param string $icon Name of icon
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param string $css_extras Extra CSS class information
 */
function makeIconButton($icon, $href, $title, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'icon' => $icon,
        'href' => $href,
        'title' => $title,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/ilink', $parms, $keep);
}

function makeImageButton($image, $href, $title, $width = 20, $height = 20, $onclick = "", $css_extras = "", $keep = true){
    $CI = &get_instance();
    $parms = array(
        'src' => $image,
        'href' => $href,
        'title' => $title,
        'height' => $height,
        'width' => $width,
        'onclick' => $onclick,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/image_button', $parms, $keep);
}

/**
 * Make a combo icon button.
 * 
 * @param string $icon Name of icon
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param array $options array for dropdown links
 * @param string $css_extras Extra CSS class information
 */
function makeComboButton($icon, $href, $title, $options, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'icon' => $icon,
        'href' => $href,
        'title' => $title,
        'options' => $options,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/combobutton', $parms, $keep);
}

/**
 * Make a submit button.
 * 
 * @param string $label Label to appear on the button
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param string $css_extras Extra CSS class information
 */
function makeSubmitButton($label, $title, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'title' => $title,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/submit', $parms, $keep);
}

/**
 * Make a date selector. 
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $size 
 */
function makeDateSelector($label, $name, $value, $explain = "", $size = 10, $disabled = false, $keep = TRUE) {
    $CI = &get_instance(); // handle to CodeIgniter instance
    $CI->caboose->needed('date', $name);
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'explain' => $explain,
        'size' => $size,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/date', $parms, $keep);
}

/**
 * Construct a form row to edit a large field.
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $maxlen
 * @param <type> $size
 * @param <type> $rows 
 */
function makeTextArea($label, $name, $value, $explain = "", $maxlen = 40, $size = 25, $rows = 5, $disabled = false, $keep = TRUE) {
    $height = (int) (strlen($value) / 80) + 1;
    if ($rows < $height)
        $rows = $height;
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
        'maxlen' => $maxlen,
        'size' => $size,
        'rows' => $rows,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/textarea', $parms, $keep);
}

/**
 * Construct a form row to hold a "real" editor for a large field.
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $maxlen (ignored)
 * @param <type> $size (ignored)
 * @param <type> $rows  (ignored)
 */
function makeTextEditor($label, $name, $value, $explain = "", $maxlen = 40, $size = 25, $rows = 5, $disabled = false, $keep = TRUE) {
    $CI = &get_instance(); // handle to CodeIgniter instance
    $CI->caboose->needed('editor', $name);
    $height = (int) (strlen($value) / 80) + 1;
    if ($rows < $height)
        $rows = $height;
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
//        'maxlen' => $maxlen,
        'size' => $size,
        'rows' => $rows,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/textarea', $parms, $keep);
}


function makeCKEditor($label, $name, $value, $explain = "", $maxlen = 1000, $size = 25, $rows = 5, $disabled = false, $keep = TRUE){
    $CI = &get_instance();
    $CI->caboose->needed('CKEditor', $name);
    $height = (int) (strlen($value) / 80) + 1;
    if ($rows < $height)
        $rows = $height;
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'maxlen' => $maxlen,
        'explain' => $explain,
        'size' => $size,
        'rows' => $rows,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/ckeditor', $parms, $keep);
}


/**
 * Construct a form row to select a file to upload.
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $explain
 */
function makeImageUploader($label, $name, $explain = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'explain' => $explain
    );
    return $CI->parser->parse('_fields/image_upload', $parms, $keep);
}

/**
 * Construct a form row to edit a checkbox.
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $disable 
 */
function makeOptionCheckbox($label, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/checkbox', $parms, $keep);
}

/**
 * Construct a stand-alone form field for choosing something (options)
 * @param <type> $number
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeComboSelector($number, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'number' => $number,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? htmlentities($explain) : htmlentities($name),
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/combo_selector', $parms, $keep);
}

/**
 * Construct a form row to edit a checkbox
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeCheckbox($label, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/checkbox', $parms, $keep);
}

/**
 * Construct a form row to edit a radiobutton
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeRadioButton($label, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/checkbox', $parms, $keep);
}

/**
 * Construct a form row to edit a radiobutton
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeRadioButtons($title, $parms, $name, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'title' => $title,
        'name' => $name,
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    $choices = array();
    $first = true;
    foreach ($parms as $value => $label) {
        $row = array(
            'value' => $value,
            'checked' => ($first) ? 'checked' : '',
            'label' => $label
        );
        $choices[] = $row;
        $first = false;
    }
    $parms['options'] = $choices;
    return $CI->parser->parse('_fields/radio_buttons', $parms, $keep);
}

/* End of file */
