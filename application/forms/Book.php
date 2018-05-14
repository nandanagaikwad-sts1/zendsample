<?php

class Application_Form_Book extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName("book");

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $artist = new Zend_Form_Element_Text('name');
        $artist->setLabel('Title')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $title = new Zend_Form_Element_Text('author');
        $title->setLabel('Author name')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('id'=> 'submitbutton', 'class'=> 'btn btn-primary'));

        $this->addElements(array($id, $artist, $title, $submit));
    }


}

