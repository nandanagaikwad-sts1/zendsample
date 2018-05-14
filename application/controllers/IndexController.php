<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($messages))
            $this->_helper->layout->getView()->message = $messages[0];
    }

    public function indexAction()
    {
        // action body
        $albums = new Application_Model_DbTable_Albums();
        $this->view->albums = $albums->fetchAll();

    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_Album();
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
        //var_dump($this->getRequest()->isPost()); exit;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                    $artist = $form->getValue('artist');
                    $title = $form->getValue('title');
                    $albums = new Application_Model_DbTable_Albums();
                    $albums->addAlbum($artist, $title);

                    $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        // action body
        $form = new Application_Form_Album();

        $form->submit->setLabel('Save');
        $this->view->form = $form;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $albums = new Application_Model_DbTable_Albums();
                $albums->updateAlbum($id, $artist, $title);

                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if($id > 0) {
                $albums = new Application_Model_DbTable_Albums();
                $form->populate($albums->getAlbum($id));
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
                $albums = new Application_Model_DbTable_Albums();
                $albums->deleteAlbum($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $albums = new Application_Model_DbTable_Albums();
            $this->view->album = $albums->getAlbum($id);
        }

    }

    public function listuserAction()
    {
        $users = Doctrine_Core::getTable('Model_User')->findAll();

        $this->view->users = $users;

    }

    public function adduserAction()
    {
        $msg = '';

        $form = new Application_Form_User();
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
        $form->submit->setLabel('Add User');
        $this->view->form = $form;

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $fname = $form->getValue('fname');
                $lname = $form->getValue('lname');
                $email = $form->getValue('email');
                $password = $form->getValue('password');
                $user = new Model_User();
                $user->fname = $fname;
                $user->lname = $lname;
                $user->email = $email;
                $user->password = $password;
                $user->salt = sha1(time());
                $user->date_created = date('Y-m-d H:i:s');
                $user->save();
                $msg =  "User created successfully.";
                $this->_helper->flashMessenger($msg);
                $this->_helper->redirector('adduser');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function edituserAction()
    {
        $form = new Application_Form_User();
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

            if($element->id == 'password') {
                $element->setAttrib('autocomplete', 'on');
                $element ->setRequired(false);
            }
            if($element->id == 'c_password') {
                $element ->setRequired(false);
            }

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
        $form->submit->setLabel('Save User');
        $this->view->form = $form;
        $id = $this->_getParam('id', 0);

        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $user = Doctrine_Core::getTable('Model_User')->findOneById($id);
                $fname = $form->getValue('fname');
                $lname = $form->getValue('lname');
                $email = $form->getValue('email');
                $password = $form->getValue('password');
                $user->fname = $fname;
                $user->lname = $lname;
                $user->email = $email;
                if(!empty($password)) {
                    $user->password = $password;
                }
                $user->save();
                $msg =  "User updated successfully.";
                $this->_helper->flashMessenger($msg);
                $this->_helper->redirector('listuser');
            } else {
                $form->populate($formData);
            }
        } else {
            if($id > 0) {
                $userdata = Doctrine_Core::getTable('Model_User')->findOneById($id);
                $userData = $userdata->toArray();
                $form->populate($userData);
            }
        }

    }

    public function userdeleteAction()
    {
        // action body
        if($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $user = Doctrine_Core::getTable('Model_User')->findOneById($id);
                $user->delete();
                if(!empty($user->UserSettings)) {
                    $user->UserSettings->delete();
                }
                $msg =  "User deleted successfully.";
                $this->_helper->flashMessenger($msg);

            }
            $this->_helper->redirector('listuser');
        } else {
            $id = $this->_getParam('id', 0);
            $userdata = Doctrine_Core::getTable('Model_User')->findOneById($id);
            //var_dump($userdata->toArray()); exit;
            $this->view->user = $userdata->toArray();
        }

    }

    public function testAction()
    {
        $id =5 ;
        $sql = "SELECT * FROM albums WHERE id = :id ";
        $stmt  = Zend_Registry::get("db")->prepare($sql);
        $data=array(':id'=> $id);

        $stmt->execute($data);
        echo "<pre>";
        print_r($stmt->fetchAll()); exit;


    }

    public function mockerAction()
    {
        //$obj = Mockery::mock('AClassToBeMocked');
        //var_dump($obj); exit;
        $object = new JustToCheckMockeryTest();
        $res = $object->AClassToWorkWith();
        var_dump($res); exit;


       // $mock = \Mockery::mock('AClassToBeMocked');
        //$mock->shouldReceive('someMethod')->once();

    }


}







