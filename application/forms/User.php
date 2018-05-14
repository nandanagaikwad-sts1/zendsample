<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setName("user");

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $fname = new Zend_Form_Element_Text('fname');
        $fname->setLabel('First Name')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $lname = new Zend_Form_Element_Text('lname');
        $lname->setLabel('Last Name')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('EmailAddress')
            ->addValidator('NotEmpty');

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->setAttrib('id', 'password')
            ->addValidator('StringLength', false, array(6,24))
            ->addValidator('NotEmpty');

        $pass = isset($_POST['password'])?$_POST['password']:'';
        $c_password = new Zend_Form_Element_Password('c_password');
        $c_password->setLabel('Confirm Password')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->setAttrib('id', 'c_password')
            ->addValidator('NotEmpty')
            ->addValidator('StringLength', false, array(6,24))
            ->addValidator(new Zend_Validate_Identical($pass));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('id'=> 'submitbutton', 'class'=> 'btn btn-primary'));

        $this->addElements(array($id,$fname,$lname, $email, $password, $c_password, $submit));
    }


}

