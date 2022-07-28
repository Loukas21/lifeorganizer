<?php
namespace Language\Form;

use Laminas\Form\Form;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\ArrayInput;

/**
 * This form is used to collect language, level, certificate, years of study. The form
 * can work in two scenarios - 'create' and 'update'.
 */
class LanguageForm extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Current language.
     * @var Language\Entity\Language
     */
    private $language = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $language = null)
    {
        // Define form name
        parent::__construct('language-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->language = $language;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "language" field
        $this->add([
            'type'  => 'select',
            'name' => 'language',
            'options' => [
                'label' => 'Język',
                'value_options' => [
                    '0' => '--wybierz--',
                    '1' => 'polski',
                    '2' => 'angielski',
                    '3' => 'niemiecki',
                    '4' => 'rosyjski',
                ],
            ],
            'attributes' => [
                'id' => 'language'
            ],
        ]);

        // Add "years of study" field
        $this->add([
            'type'  => 'number',
            'name' => 'yearsofstudy',
            'options' => [
                'label' => 'Lata nauki',
            ],
            'attributes' => [
                'id' => 'yearsofstudy',
                'min' => '0',
                'step' => '0.1',
                'max' => '150',
            ],
        ]);

        // Add "level" field
        $this->add([
            'type'  => 'select',
            'name' => 'level',
            'options' => [
                'label' => 'Poziom',
                'value_options' => [
                    '0' => '--nieokreślony--',
                    '1' => 'A1',
                    '2' => 'A2',
                    '3' => 'B1',
                    '4' => 'B2',
                    '5' => 'C1',
                    '6' => 'C2',
                    '7' => 'język ojczysty'
                ],
            ],
            'attributes' => [
                'id' => 'level'
            ],
        ]);

        //Add "hascertificate" field
        $this->add([
          'type' => 'checkbox',
          'name' => 'hascertificate',
          'options' => [
            'label' => 'Certyfikat potwierdzający',
          ],
          'attributes' => [
            'id' => 'hascertificate',
          ],
        ]);

        //Add "description" fields
        $this->add([
            'type' => 'textarea',
            'name' => 'certificatedescription',
            'options' => [
              'label' => 'Opis certyfikatu'
            ],
            'attributes' => [
              'id' => 'certificatedescription',
              'rows' => '2',
              'maxlength' => 200,
            ],
        ]);

        //Add "description" fields
        $this->add([
            'type' => 'date',
            'name' => 'certificatedate',
            'options' => [
              'label' => 'Data wystawienia certyfikatu'
            ],
            'attributes' => [
              'id' => 'certificatedate',
            ],
        ]);

        $this->add([
          'type' => 'hidden',
          'name' => 'user',
          'attributes' => [
              'id' => 'user',
          ],
        ]);


        // Add the CSRF field
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Utwórz'
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = $this->getInputFilter();


        // Add input for "certificatedescription" field
        $inputFilter->add([
                'name'     => 'language',
                'required' => true,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => 'GreaterThan',
                        'options' => [
                          'min' => 0,
                            'messages' => [
                              \Laminas\Validator\GreaterThan::NOT_GREATER => 'Wybierz język'
                            ],
                        ],
                    ],
                ],
            ]);

        // Add input for "yearsofstudy" field
        $inputFilter->add([
                'name'     => 'yearsofstudy',
                'required' => false,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => 'NotEmpty',
                        'options' => [
                            'messages' => [
                              \Laminas\Validator\NotEmpty::IS_EMPTY => 'Liczba lat nauki nie może być pusta'
                            ],
                        ],
                    ],
                    [
                        'name'    => 'LessThan',
                        'options' => [
                            'max' => 150,
                            'inclusive' => true,
                            'messages' => [
                              \Laminas\Validator\LessThan::NOT_LESS_INCLUSIVE => 'Liczba lat nauki nie może być większa niż %max%'
                            ],
                        ],
                    ],
                    [
                        'name'    => 'GreaterThan',
                        'options' => [
                            'min' => 0,
                            'messages' => [
                              \Laminas\Validator\GreaterThan::NOT_GREATER_INCLUSIVE => 'Liczba lat nauki nie może być mniejsza niż %min%'
                            ],
                        ],
                    ],
                ],
            ]);



        // Add input for "certificatedescription" field
        $inputFilter->add([
                'name'     => 'certificatedescription',
                'required' => false,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'max' => 200,
                            'messages' => [
                              \Laminas\Validator\StringLength::TOO_LONG => 'Opis certyfikatu nie może mieć więcej niż %max% znaków'
                            ],
                        ],
                    ],
                ],
            ]);

        // Add input for "certificatedate" field
        $inputFilter->add([
                'name'     => 'certificatedate',
                'required' => false,
                'filters'  => [
                ],
                'validators' => [
                ],
            ]);
    }
}
