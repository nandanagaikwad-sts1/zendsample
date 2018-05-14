<?php

class BookController extends Zend_Controller_Action
{
    public $db;

    public function init()
    {
        /* Initialize action controller here */
        $config = new Zend_Config(
            array(
                'database' => array(
                    'adapter' => 'Mysqli',
                    'params'  => array(
                        'host'     => 'localhost',
                        'dbname'   => 'zend-sample',
                        'username' => 'root',
                        'password' => '',
                    )
                )
            )
        );

        $this->db = Zend_Db::factory($config->database);
        //var_dump($db); exit;
        $messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($messages))
            $this->_helper->layout->getView()->message = $messages[0];


    }

    public function indexAction()
    {
        // action body

        $book = new Application_Model_DbTable_Book();
        $res = $book->getList($this->db);
        $this->view->books = $res;

    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_Book();
        $form->setElementDecorators(array(
            'viewHelper',
            'Errors',
            // array('Errors', array('class' => 'errors', 'style'=>'list-style: none; color:red;')),
            array('Label'),
            array(
                array('row'=>'HtmlTag'),
                array('tag'=>'div', 'class'=>'form-group'),
            ),
            array('HtmlTag', array('tag'=>'div', 'class'=>'col-md-3', 'style'=>'width:25%')),
        ));
        foreach($form->getElements() as $element){

            if($element->id != 'submitbutton'){
                $element->setAttrib('class', 'form-control');
                //$element->removeDecorator('Errors');

            } else {
                $element->removeDecorator('label');
            }
            $deco_html_tag = $element->getDecorator('HtmlTag');
            $deco_html_tag->setOption('class', 'clearfix');
            //$element->addDecorator('FormErrors');
        }
        $form->submit->setLabel('Add');
        $this->view->form = $form;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid(($formData))) {
                $title = $form->getValue('name');
                $author = $form->getValue('author');
                $book = new Application_Model_DbTable_Book();
                $book->addBook($this->db,$title,$author);
                $msg =  "Book added successfully.";
                $this->_helper->flashMessenger($msg);
                $this->_helper->redirector('index');

            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        // action body
        $form = new Application_Form_Book();
        $form->setElementDecorators(array(
            'viewHelper',
            'Errors',
            // array('Errors', array('class' => 'errors', 'style'=>'list-style: none; color:red;')),
            array('Label'),
            array(
                array('row'=>'HtmlTag'),
                array('tag'=>'div', 'class'=>'form-group'),
            ),
            array('HtmlTag', array('tag'=>'div', 'class'=>'col-md-3', 'style'=>'width:25%')),
        ));
        foreach($form->getElements() as $element){

            if($element->id != 'submitbutton'){
                $element->setAttrib('class', 'form-control');
                //$element->removeDecorator('Errors');

            } else {
                $element->removeDecorator('label');
            }
            $deco_html_tag = $element->getDecorator('HtmlTag');
            $deco_html_tag->setOption('class', 'clearfix');
            //$element->addDecorator('FormErrors');
        }
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        $id = $this->_getParam('id', 0);

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid(($formData))) {
                $title = $form->getValue('name');
                $author = $form->getValue('author');
                $book = new Application_Model_DbTable_Book();
                $book->updateBook($this->db,$id,$title, $author);
                $msg =  "Book updated successfully.";
                $this->_helper->flashMessenger($msg);
                $this->_helper->redirector('index');

            } else {
                $form->populate($formData);
            }
        } else {
            if($id > 0) {
                $books = new Application_Model_DbTable_Book();
                $form->populate($books->getBook($this->db,$id));
            }
        }
    }

    public function deleteAction()
    {
        // action body
        if($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $book = new Application_Model_DbTable_Book();
                $book->deleteBook($this->db,$id);
                $msg =  "Book deleted successfully.";
                $this->_helper->flashMessenger($msg);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $book = new Application_Model_DbTable_Book();
            $this->view->book = $book->getBook($this->db,$id);
        }
    }


}







