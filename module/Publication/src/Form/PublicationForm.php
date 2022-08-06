<?php
namespace Publication\Form;

use Laminas\Form\Form;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\ArrayInput;
use Publication\Form\Validator as CustomPublicationValidator;

/**
 * This form is used to collect publication's author, publication's title. The form
 * can work in two scenarios - 'create' and 'update'.
 */
class PublicationForm extends Form
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
     * Current publication.
     * @var Publication\Entity\Publication
     */
    private $publication = null;


    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $publication = null)
    {
        // Define form name
        parent::__construct('publication-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->publication = $publication;

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
                'id' => 'author'
            ],
        ]);

        // Add "title" field
        $this->add([
            'type'  => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'Tytuł',
            ],
            'attributes' => [
                'id' => 'title',
                'maxlength' => 500,
            ],
        ]);

        //Add "iswanted" field
        $this->add([
          'type' => 'checkbox',
          'name' => 'iswanted',
          'options' => [
            'label' => 'Na liście życzeń',
          ],
          'attributes' => [
            'id' => 'iswanted',
          ],
        ]);

        //Add "description" fields
        $this->add([
            'type' => 'textarea',
            'name' => 'description',
            'options' => [
              'label' => 'Opis'
            ],
            'attributes' => [
              'id' => 'description',
              'rows' => '6',
              'maxlength' => 5000,
            ],
        ]);

        // Add "type" field
        $this->add([
            'type'  => 'select',
            'name' => 'type',
            'options' => [
                'label' => 'Typ',
                'value_options' => [
                    '0' => '--wybierz--',
                    '1' => 'książka',
                    '2' => 'ebook',
                    '3' => 'audiobook',
                    '4' => 'artykuł',
                //    '5' => 'audycja',
                //    '6' => 'wykład',
                //    '7' => 'film',
                //    '8' => 'podcast'
                ],
            ],
            'attributes' => [
                'id' => 'type'
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

        //Add "totality" field
        $this->add([
          'type' => 'number',
          'name' => 'totality',
          'options' => [
            'label' => 'Całość',
          ],
          'attributes' => [
            'id' => 'totality',
            'min' => '0',
            'max' => '99999',
            'step' => '1',
          ],
        ]);

        $this->add([
          'type' => 'hidden',
          'name' => 'user',
        ]);

        if ($this->scenario == 'update')
        {
          $this->add([
            'type' => 'hidden',
            'name' => 'id',
            'attributes' => [
              'id' => 'id',
            ],
          ]);

        //Add "currentprogress" field
        $this->add([
          'type' => 'number',
          'name' => 'currentprogress',
          'options' => [
            'label' => 'Aktualny postęp',
          ],
          'attributes' => [
            'id' => 'currentprogress',
            'min' => '0',
            'max' => '99999',
            'step' => '1',
          ],
        ]);

        //Add "isfinished" field
        $this->add([
          'type' => 'checkbox',
          'name' => 'isfinished',
          'options' => [
            'label' => 'Ukończono',
          ],
          'attributes' => [
            'id' => 'isfinished',
          ],
        ]);
        }

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
                            'max' => 300,
                            'messages' => [
                              \Laminas\Validator\StringLength::TOO_LONG => 'Pole Autor nie może mieć więcej niż %max% znaków.',
                            ],
                        ],
                    ],
                ],
            ]);


        // Add input for "title" field
        $inputFilter->add([
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'max' => 500,
                            'messages' => [
                              \Laminas\Validator\StringLength::TOO_LONG => 'Tytuł nie może mieć więcej niż %max% znaków.',
                            ],
                        ],
                    ],
                    [
                        'name'    => 'NotEmpty',
                        'options' => [
                            'messages' => [
                              \Laminas\Validator\NotEmpty::IS_EMPTY => 'Tytuł nie może być pusty'
                            ],
                        ],
                    ],
                ],
            ]);

            // Add input for "type" field
            $inputFilter->add([
                    'name'     => 'type',
                    'required' => false,
                    'filters'  => [
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name'  => CustomPublicationValidator\CallbackTypeIsWantedTrue::class,
                            'options' => [
                              'callback' => function($value, $context=[]) {
                                  if ($context['iswanted'] == 1) {
                                    if ($value != 0){
                                      return false;
                                    }
                                  }
                                return true;
                              }
                            ]
                        ],
                        [
                            'name'  => CustomPublicationValidator\CallbackTypeIsWantedFalse::class,
                            'options' => [
                              'callback' => function($value, $context=[]) {
                                  if ($context['iswanted'] == 0) {
                                    if ($value == 0){
                                      return false;
                                    }
                                  }
                                return true;
                              }
                            ]
                        ],
                    ],
                ]);

            // Add input for "description" field
            $inputFilter->add([
                    'name'     => 'description',
                    'required' => false,
                    'filters'  => [
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name'    => 'StringLength',
                            'options' => [
                                'max' => 5000,
                                'messages' => [
                                  \Laminas\Validator\StringLength::TOO_LONG => 'Opis nie może mieć więcej niż %max% znaków.',
                                ]
                            ],
                        ],

                    ],
                ]);

            // Add input for "totality" field
            $inputFilter->add([
                    'name'     => 'totality',
                    'required' => false,
                    'filters'  => [
                      ['name' => 'Digits'],
                    ],
                    'validators' => [
                      [
                          'name'    => 'GreaterThan',
                          'options' => [
                              'min' => 0,
                              'inclusive' => true,
                              'messages' => [
                                \Laminas\Validator\GreaterThan::NOT_GREATER_INCLUSIVE => 'Całość nie może być mniejsza od %min%',
                              ]
                          ],
                      ],
                      [
                          'name'    => 'LessThan',
                          'options' => [
                              'max' => 99999,
                              'inclusive' => true,
                              'messages' => [
                                \Laminas\Validator\LessThan::NOT_LESS_INCLUSIVE => 'Całość nie może być większa od %max%',
                              ]
                          ],
                      ],
                      [
                          'name'    => 'Regex',
                          'options' => [
                              'messages' => [
                                \Laminas\Validator\Regex::NOT_MATCH => 'Wartość w polu Całość może zawierać tylko liczby',
                              ],
                              'pattern' => '(^-?\d*(\.\d+)?$)',
                          ],
                      ],
                    ],
                ]);
            if ($this->scenario == 'update')
            {


            // Add input for "currentprogress" field
            $inputFilter->add([
                    'name'     => 'currentprogress',
                    'required' => false,
                    'filters'  => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'GreaterThan',
                            'options' => [
                                'min' => 0,
                                'inclusive' => true,
                                'messages' => [
                                  \Laminas\Validator\GreaterThan::NOT_GREATER_INCLUSIVE => 'Aktualny postęp nie może być mniejszy od %min%',
                                ]
                            ],
                        ],
                        [
                            'name'    => 'LessThan',
                            'options' => [
                                'max' => 99999,
                                'inclusive' => true,
                                'messages' => [
                                  \Laminas\Validator\LessThan::NOT_LESS_INCLUSIVE => 'Aktualny postęp nie może być większy od %max%',
                                ]
                            ],
                        ],
                        [
                            'name'  => CustomPublicationValidator\CallbackCurrentProgressType::class,
                            'options' => [
                              'callback' => function($value, $context=[]) {
                                  if ($context['type'] == 0) {
                                    $currentprogress = $value;
                                    if ($currentprogress > 0) {
                                      return false;
                                    }
                                  }
                                return true;
                              }
                            ]
                        ],
                        [
                            'name'  => CustomPublicationValidator\CallbackCurrentProgressIsWanted::class,
                            'options' => [
                              'callback' => function($value, $context=[]) {
                                  if ($context['iswanted'] == 1) {
                                    $currentprogress = $value;
                                    if ($currentprogress > 0) {
                                      return false;
                                    }
                                  }
                                return true;
                              }
                            ]
                        ],
                        [
                            'name'  => CustomPublicationValidator\CallbackCurrentProgressTotality::class,
                            'options' => [
                              'callback' => function($value, $context=[]) {
                                $currentprogress = $value;
                                $totality = $context['totality'];
                                $isValid = ($currentprogress <= $totality);
                                return $isValid;
                              }
                            ]
                        ],
                        [
                            'name'    => 'Regex',
                            'options' => [
                                'messages' => [
                                  \Laminas\Validator\Regex::NOT_MATCH => 'Wartość w polu Aktualny postęp może zawierać tylko liczby',
                                ],
                                'pattern' => '(^-?\d*(\.\d+)?$)',
                            ],
                        ],
                    ],
                ]);


                // Add input for "isfinished" field
                $inputFilter->add([
                        'name'     => 'isfinished',
                        'required' => false,
                        'filters'  => [
                        ],
                        'validators' => [
                            [
                                'name'  => CustomPublicationValidator\CallbackIsFinishedTotality::class,
                                'options' => [
                                  'callback' => function($value, $context=[]) {
                                    if ($value == 1) {
                                      if ($context['totality'] == 0) {
                                        return false;
                                      }
                                    }
                                    return true;
                                  }
                                ]
                            ],
                            [
                                'name'  => CustomPublicationValidator\CallbackIsFinishedCurrentProgress::class,
                                'options' => [
                                  'callback' => function($value, $context=[]) {
                                    if ($value == 1) {
                                      if ($context['totality'] > $context['currentprogress']) {
                                        return false;
                                      }
                                  }
                                  return true;
                                }
                                ]
                            ],
                        ],
                    ]);


            }
    }

}
