<?php

class Application_Model_DbTable_Guestbook extends Zend_Db_Table_Abstract
{

    protected $_name = 'guestbook';

    public function deleteComment($id)
    {
        $this->delete('id = '. (int)$id);
    }


}

