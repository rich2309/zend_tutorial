<?php
namespace Client\Form;

use Zend\Form\Form;

class ClientForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('client');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'nom',
            'type' => 'text',
            'options' => [
                'label' => 'Nom',
            ],
        ]);
        $this->add([
            'name' => 'prenom',
            'type' => 'text',
            'options' => [
                'label' => 'Prénom',
            ],
        ]);
        $this->add([
            'name' => 'adresse',
            'type' => 'text',
            'options' => [
                'label' => 'Adresse',
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
            'name' => 'date_naissance',
            'type' => 'date',
            'options' => [
                'label' => 'Date de naissance',
            ],
        ]);
        $this->add([
            'name' => 'sexe',
            'type' => 'select',
            'options' => [
                'label' => 'Sexe',
                'empty_option' => 'Veuillez choisir votre sexe',
                'value_options' => [
                    'F' => 'Féminin',
                    'M' => 'Masculin'
                ]
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