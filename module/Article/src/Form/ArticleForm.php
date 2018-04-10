<?php
namespace Article\Form;

use Zend\Form\Form;

class ArticleForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('article');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'designation',
            'type' => 'text',
            'options' => [
                'label' => 'Designation',
            ],
        ]);
        $this->add([
            'name' => 'prix_unit',
            'type' => 'number',
            'options' => [
                'label' => 'Prix unitaire',
            ],
            'attributes' => [
                'min' => '1',
                'max' => '99999',
                'step' => 'any'
            ]
        ]);

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