<?php
namespace Hobby\Form;

use Laminas\Form\Form;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\ArrayInput;

/**
 * This form is used to collect hobby name, position, visibility in vcv The form
 * can work in two scenarios - 'create' and 'update'.
 */
class HobbyForm extends Form
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
     * Current hobby.
     * @var Hobby\Entity\Hobby
     */
    private $hobby = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $hobby = null)
    {
        // Define form name
        parent::__construct('hobby-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->hobby = $hobby;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
      //Add "name" field
      $this->add([
          'type' => 'text',
          'name' => 'name',
          'options' => [
            'label' => 'Zainteresowanie'
          ],
          'attributes' => [
            'id' => 'name'
          ],
      ]);

      //Add "ishiddeninvcv" field
      $this->add([
        'type' => 'checkbox',
        'name' => 'ishiddeninvcv',
        'options' => [
          'label' => 'Nie pokazuj w VCV',
        ],
        'attributes' => [
          'id' => 'ishiddeninvcv',
        ],
      ]);

      $this->add([
          'type'  => 'number',
          'name' => 'position',
          'options' => [
              'label' => 'Pozycja w VCV',
          ],
          'attributes' => [
              'id' => 'position',
              'min' => '1',
              'max' => '999',
              'step' => '1',
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

        $inputFilter->add([
                'name'     => 'name',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 0,
                            'max' => 100,
                            'messages' => [
                              \Laminas\Validator\StringLength::TOO_LONG => 'Wartość w polu Autorytet nie może mieć więcej niż %max% znaków'
                            ],
                        ],
                    ],
                    [
                        'name'    => 'NotEmpty',
                        'options' => [
                            'messages' => [
                              \Laminas\Validator\NotEmpty::IS_EMPTY => 'Wartość w polu Autorytet nie może być pusta'
                            ],
                        ],
                    ],
                    [
                        'name'    => 'Regex',
                        'options' => [
                            'messages' => [
                              \Laminas\Validator\Regex::NOT_MATCH => 'W polu Autorytet wyrazy nie powinny być dłuższe niż 30 znaków.',
                            ],
                            'pattern' => '(^((?!(([^\s]){31,})).)*$)',
                        ],
                    ],
                ],
            ]);

                $inputFilter->add([
                        'name'     => 'position',
                        'required' => false,
                        'filters'  => [
                            ['name' => 'ToInt'],
                        ],
                        'validators' => [
                          [
                              'name'    => 'NotEmpty',
                              'options' => [
                                  'messages' => [
                                    \Laminas\Validator\NotEmpty::IS_EMPTY => 'Wartość w polu Kolejność w VCV nie może być pusta'
                                  ],
                              ],
                          ],
                          [
                              'name'    => 'GreaterThan',
                              'options' => [
                                  'min' => 1,
                                  'inclusive' => true,
                                  'messages' => [
                                    \Laminas\Validator\GreaterThan::NOT_GREATER_INCLUSIVE => 'Pozycja w VCV nie może być mniejsza od %min%'
                                  ],
                              ],
                          ],
                          [
                              'name'    => 'LessThan',
                              'options' => [
                                  'max' => 999,
                                  'inclusive' => true,
                                  'messages' => [
                                    \Laminas\Validator\LessThan::NOT_LESS_INCLUSIVE => 'Wartość w polu Pozycja w VCV nie może być większa od %max%'
                                  ],
                              ],
                          ],
                        ],
                ]);


    }
}
