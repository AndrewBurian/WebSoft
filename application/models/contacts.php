<?php

class Contacts extends _Mymodel {

// Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('contacts', 'id');
    }

}

/* End of file contacts.php */
/* Location: application/models/contacts.php */