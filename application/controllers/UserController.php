<?php

class UserController extends Zend_Controller_Action
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
        $user = new Model_User();
        $users = $user->listuser();
        //echo $user->getSqlQuery(); exit;
        $this->view->users = $users;
    }

    public function addAction()
    {
        // action body
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
                //$user->adduser($form);
                $user->fname = $fname;
                $user->lname = $lname;
                $user->email = $email;
                $user->password = $password;
                $user->salt = sha1(time());
                $user->date_created = date('Y-m-d H:i:s');
                $craeted = date('Y-m-d H:i:s');
                $salt = sha1(time());
                /* $sqlstmt = "insert into user ('fname','lname','email','salt','date_created') VALUES ('".$fname."', '".$lname."', '".$email."', '".$salt."', '".$craeted."')";
                $q = Doctrine_Query::create()
                    ->query($sqlstmt);
                //echo $q->getSqlQuery(); exit;
                $save = $q->execute();*/
                $user->save();
                    $msg =  "User created successfully.";
                    $this->_helper->flashMessenger($msg);
                    $this->_helper->redirector('add');


            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        // action body
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
                $update = new Model_User();
                $save = $update->updateuser($form, $id);
                //echo $q->getSqlQuery(); exit;
                if($save){
                    $msg =  "User updated successfully.";
                    $this->_helper->flashMessenger($msg);
                    $this->_helper->redirector('index');
                }
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

    public function deleteAction()
    {
        // action body for delete action
        if($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $user = new Model_User();
                $del = $user->deleteuser($id);
                if($del){
                    $msg =  "User deleted successfully.";
                    $this->_helper->flashMessenger($msg);
                }
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $userdata = Doctrine_Core::getTable('Model_User')->findOneById($id);
            //var_dump($userdata->toArray()); exit;
            $this->view->user = $userdata->toArray();
        }
    }


}







