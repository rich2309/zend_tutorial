<?php
namespace Application\Util;
use Zend\I18n\Translator\Translator as ZendI18nTranslator;
use Zend\Validator\Translator\TranslatorInterface;
class Translator extends ZendI18nTranslator implements TranslatorInterface{

}

namespace Article\Model;
use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Application\Util\Translator;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Resources;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class Article implements InputFilterAwareInterface
{
    public $id;
    public $designation;
    public $prix_unit;

    private $inputFilter;
    public function exchangeArray($data)
    {

        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->designation = (isset($data['designation'])) ? $data['designation'] : null;
        $this->prix_unit  = (isset($data['prix_unit'])) ? $data['prix_unit'] : null;

    }
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'designation' => $this->designation,
            'prix_unit'  => $this->prix_unit,
        ];
    }
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf("%s n'autorise pas l'injection d'une classe input filter alternative",  __CLASS__ ));
    }
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $translator = Translator:: factory(['locale' => 'fr',]);
        $translator->addTranslationFilePattern(
            'phparray', // WARNING, NO UPPERCASE
            Resources:: getBasePath(),
            Resources:: getPatternForValidator()
        );
        AbstractValidator:: setDefaultTranslator($translator);

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'designation',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'prix_unit',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

}