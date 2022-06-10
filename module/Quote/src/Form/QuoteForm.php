<?php
namespace Quote\Form;

use Laminas\Form\Form;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\ArrayInput;

/**
 * This form is used to collect quote's author, quote text. The form
 * can work in two scenarios - 'create' and 'update'.
 */
class QuoteForm extends Form
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
     * Current quote.
     * @var Quote\Entity\Quote
     */
    private $quote = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $quote = null)
    {
        // Define form name
        parent::__construct('quote-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->quote = $quote;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "author" field
        $this->add([
            'type'  => 'text',
            'name' => 'author',
            'options' => [
                'label' => 'Autor',
            ],
            'attributes' => [
              'id' => 'author',
              'maxlength' => 150,
            ],
        ]);

        // Add "quote" field
        $this->add([
            'type'  => 'textarea',
            'name' => 'quote',
            'options' => [
                'label' => 'Cytat',
            ],
            'attributes' => [
                'id' => 'quote',
                'rows' => '6',
                'maxlength' => 1000,
            ],
        ]);

        $this->add([
          'type' => 'hidden',
          'name' => 'user',
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

        // Add input for "author" field
        $inputFilter->add([
                'name'     => 'author',
                'required' => false,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 0,
                            'max' => 150,
                            'messages' => [
                              \Laminas\Validator\StringLength::TOO_LONG => 'Autor nie może mieć więcej niż %max% znaków'
                            ],
                        ],
                    ],
                ],
            ]);

        // Add input for "quote" field
        $inputFilter->add([
                'name'     => 'quote',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'max' => 1000,
                            'messages' => [
                              \Laminas\Validator\StringLength::TOO_LONG => 'Cytat nie może mieć więcej niż %max% znaków'
                            ],
                        ],
                    ],
                    [
                        'name'    => 'NotEmpty',
                        'options' => [
                            'messages' => [
                              \Laminas\Validator\NotEmpty::IS_EMPTY => 'Cytat nie może być pusty'
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
