<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Posts table.
 *
 * @author		JLP
 * ------------------------------------------------------------------------
 */
class Posts extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('posts', 'pid');
    }

    // Return the latest 3 posts, in revverse order (newest first)
    function newest($count = 3) {
        $this->db->order_by($this->_keyField, 'desc');
        $this->db->limit($count);
        $query = $this->db->get($this->_tableName);
        return $query->result_array();
    }

}

/* End of file posts.php */
/* Location: application/models/posts.php */