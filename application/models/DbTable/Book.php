<?php

class Application_Model_DbTable_Book extends Zend_Db_Table_Abstract
{

    protected $_name = 'book';

    public function getList($db)
    {
        $result = [];

        $stmt = $db->query('SELECT * FROM book');

        while ($row = $stmt->fetch()) {
            $result[] = $row;
        }
        return $result;
    }

    public function getBook($db,$id)
    {
        $result = [];
        $id = (int)$id;

        $sql = 'SELECT * FROM book where id=?';

        $stmt = new Zend_Db_Statement_Mysqli($db, $sql);
        $stmt->execute(array($id));
        while ($row = $stmt->fetch()) {
            $result[] = $row;
        }
        return $result[0];
    }

    public function addBook($db,$name,$author)
    {

        $created =  date('Y-m-d H:i:s');
        $sql = "insert into book (`name`, `author`, `created`) VALUES (?,?, ?)";
        $stmt = new Zend_Db_Statement_Mysqli($db, $sql);
        $stmt->execute(array($name, $author, $created));
    }

    public function updateBook($db,$id, $name, $author)
    {
        $sql = "UPDATE `book` SET `name`= ?,`author`= ? WHERE id= ?";
        $stmt = new Zend_Db_Statement_Mysqli($db, $sql);
        $stmt->execute(array($name, $author, $id));

       /* $data = array(
            'name' => $name,
            'author' => $author,
        );
        $this->update($data, 'id = '. (int)$id);*/
    }

    public function deleteBook($db,$id)
    {
        $sql = "DELETE FROM `book` WHERE id = ?";
        $stmt = new Zend_Db_Statement_Mysqli($db, $sql);
        $stmt->execute(array($id));
        //$this->delete('id = '. (int)$id);
    }


}

