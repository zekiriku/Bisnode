<?php
namespace App\form;

use Zend\Form\Element;
use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct('user');

        $this->add([
           'name' => 'id',
           'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options' => [
                'label' => 'First Name',
            ],
        ]);

        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options' => [
                'label' => 'Last Name',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'name' => 'position',
            'type' => 'text',
            'options' => [
                'label' => 'Position',
            ],
        ]);
        $this->add(new Element\Csrf('csrf'));
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}