<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Media table.
 *
 * @author		JLP
 * ------------------------------------------------------------------------
 */
class Media extends _Mymodel2 {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('images', 'iid');
    }

}

/* End of file media.php */
/* Location: application/models/media.php */