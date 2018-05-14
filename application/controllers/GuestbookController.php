<?php

class GuestbookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $guestbook = new Application_Model_GuestbookMapper();
        $this->view->entries = $guestbook->fetchAll();
        $id = 1;
        $model = new Application_Model_Guestbook();
        $res = $guestbook->find($id, $model);
        $this->view->records = $res;
    }

    public function signAction()
    {
        // action body
        $request = $this->getRequest();
        $form    = new Application_Form_Guestbook();

        /*$form->setElementDecorators(array(
            'viewHelper',
            'Errors',
            // array('Errors', array('class' => 'errors', 'style'=>'list-style: none; color:red;')),
            array('Label'),
            array(
                array('row'=>'HtmlTag'),
                array('tag'=>'div', 'class'=>'form-group'),
            ),
            array('HtmlTag', array('tag'=>'div', 'class'=>'col-md-3', 'style'=>'width:25%')),
        ));*/
        /*foreach($form->getElements() as $element){

            if($element->id != 'submitbutton' && $element->id != 'captcha-input' && $element->id != 'captcha' ){
                $element->setAttrib('class', 'form-control');
                //$element->removeDecorator('Errors');

            } else {
                //$element->removeDecorator('label');
            }
            $deco_html_tag = $element->getDecorator('HtmlTag');
            $deco_html_tag->setOption('class', 'clearfix');
            //$element->addDecorator('FormErrors');
        }*/

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $comment = new Application_Model_Guestbook($form->getValues());
                $mapper  = new Application_Model_GuestbookMapper();
                //echo "<pre>"; var_dump($comment); exit;
                $mapper->save($comment);
                return $this->_helper->redirector('index');
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        // action body
        $id = $this->_getParam('id', 0);
        $mapper = new Application_Model_GuestbookMapper();
        $mapper->delete($id);
    }


}





