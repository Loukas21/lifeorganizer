<?php
namespace BloodDonation\Form;

use Laminas\Form\Form;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\ArrayInput;
use BloodDonation\Form\Validator as CustomBloodDonationValidator;

/**
 * This form is used to collect blood donation, level, certificate, years of study. The form
 * can work in two scenarios - 'create' and 'update'.
 */
class BloodDonationForm extends Form
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
     * Current blood donation.
     * @var BloodDonation\Entity\BloodDonation
     */
    private $bloodDonation = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $bloodDonation = null)
    {
        // Define form name
        parent::__construct('blooddonation-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->bloodDonation = $bloodDonation;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {

        //Add "place" fields
        $this->add([
            'type' => 'text',
            'name' => 'place',
            'options' => [
              'label' => 'Nazwa punktu krwiodawstwa'
            ],
            'attributes' => [
              'id' => 'place'
            ],
        ]);

        //Add "donationdate" fields
        $this->add([
            'type' => 'date',
            'name' => 'donationdate',
            'options' => [
              'label' => 'Data donacji'
            ],
            'attributes' => [
              'id' => 'donationdate',
            ],
        ]);

        //Add "isplanned" field
        $this->add([
          'type' => 'checkbox',
          'name' => 'isplanned',
          'options' => [
            'label' => 'Planowana donacja',
          ],
          'attributes' => [
            'id' => 'isplanned',
          ],
        ]);

        $this->add([
            'type'  => 'number',
            'name' => 'donatedbloodamount',
            'options' => [
                'label' => 'Ilość oddanej krwi (ml)',
            ],
            'attributes' => [
                'id' => 'donatedbloodamount',
                'min' => '0',
                'step' => '1',
                'default' => '0',
            ],
        ]);
        /*
        //Add "relatedeventholiday" field
        $this->add([
          'type' => 'search',
          'name' => 'relatedeventholiday',
          'options' => [
            'label' => 'Powiązany urlop',
          ],
          'attributes' => [
            'id' => 'relatedeventholiday',
          ],
        ]);

        //Add "relatedeventmedicalexamination" field
        $this->add([
          'type' => 'search',
          'name' => 'relatedeventmedicalexamination',
          'options' => [
            'label' => 'Powiązane badanie',
          ],
          'attributes' => [
            'id' => 'relatedeventmedicalexamination',
          ],
        ]);
        */
        //Add "isdonationbanned" field
        $this->add([
          'type' => 'checkbox',
          'name' => 'isdonationbanned',
          'options' => [
            'label' => 'Dyskwalifikacja z oddania',
          ],
          'attributes' => [
            'id' => 'isdonationbanned',
          ],
        ]);

        //Add "bancausetype" field
        $this->add([
          'type' => 'select',
          'name' => 'bancausetype',
          'options' => [
            'label' => 'Typ powodu dyskwalifikacji',
            'value_options' => [
                '0' => '--wybierz--',
                '1' => 'wyniki badań',
                '2' => 'termin oddania',
                '3' => 'rezygnacja własna',
                '4' => 'inny powód'
            ],

          ],
          'attributes' => [
            'id' => 'bancausetype',
          ],
        ]);

        //Add "bancausedescription" fields
        $this->add([
            'type' => 'textarea',
            'name' => 'bancausedescription',
            'options' => [
              'label' => 'Opis powodu dyskwalifikacji'
            ],
            'attributes' => [
              'id' => 'bancausedescription',
              'rows' => '2',
            ],
        ]);

        //Add "bandateto" fields
        $this->add([
            'type' => 'date',
            'name' => 'bandateto',
            'options' => [
              'label' => 'Data dyskwalifikacji'
            ],
            'attributes' => [
              'id' => 'bandateto',
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

        // Add input for "place" field
        $inputFilter->add([
                'name'     => 'place',
                'required' => true,
                'filters'  => [
                  ['name' => 'StringTrim'],
                ],
                'validators' => [
                  [
                      'name'    => 'StringLength',
                      'options' => [
                          'max' => 200,
                          'messages' => [
                            \Laminas\Validator\StringLength::TOO_LONG => 'Nazwa punktu krwiodawstwa nie może mieć więcej niż %max% znaków.',
                          ],
                      ],
                  ],
                  [
                      'name'    => 'NotEmpty',
                      'options' => [
                          'messages' => [
                            \Laminas\Validator\NotEmpty::IS_EMPTY => 'Nazwa punktu krwiodawstwa nie może być pusta'
                          ],
                      ],
                  ],
                ],
            ]);

            // Add input for "donationdate" field
            $inputFilter->add([
                    'name'     => 'donationdate',
                    'required' => false,
                    'filters'  => [
                    ],
                    'validators' => [
                      [
                          'name'    => CustomBloodDonationValidator\CallbackDonationDateGreaterThanTodayIsPlanned::class,
                          'options' => [
                            'callback' => function($value, $context=[]) {
                                if ($context['isplanned'] != 1) {
                                  $donationDate = $value;
                                  $today = date("Y-m-d H:i:s", mktime(23,59,59));
                                  if ($donationDate > $today) {
                                    return false;
                                  }
                                }
                              return true;
                            }
                          ]
                      ],
                    ],
                ]);

        // Add input for "donatedbloodamount" field
        $inputFilter->add([
                'name'     => 'donatedbloodamount',
                'required' => false,
                'filters'  => [
                ],
                'validators' => [
                  [
                      'name'    => 'LessThan',
                      'options' => [
                          'max' => 450,
                          'inclusive' => true,
                          'messages' => [
                            \Laminas\Validator\LessThan::NOT_LESS_INCLUSIVE => 'Ilość oddanej krwi nie może być większa niż %max% ml'
                          ],
                      ],
                  ],
                  [
                      'name'    => 'GreaterThan',
                      'options' => [
                          'min' => 0,
                          'inclusive' => true,
                          'messages' => [
                            \Laminas\Validator\GreaterThan::NOT_GREATER_INCLUSIVE => 'Ilość oddanej krwi nie może być mniejsza od %min%'
                          ],
                      ],
                  ],
                  [
                      'name'  => CustomBloodDonationValidator\CallbackDonatedBloodAmountIsPlanned::class,
                      'options' => [
                        'callback' => function($value, $context=[]) {
                            if ($context['isplanned'] == 1) {
                              $donatedBloodAmount = $value;
                              if ($donatedBloodAmount > 0) {
                                return false;
                              }
                            }
                          return true;
                        }
                      ]
                  ],
                  [
                      'name'  => CustomBloodDonationValidator\CallbackDonatedBloodAmountIsDonationBanned::class,
                      'options' => [
                        'callback' => function($value, $context=[]) {
                            if ($context['isdonationbanned'] == 1) {
                              $donatedBloodAmount = $value;
                              if ($donatedBloodAmount > 0) {
                                return false;
                              }
                            }
                          return true;
                        }
                      ]
                  ],
                ],
            ]);

    // Add input for "bandateto" field
    $inputFilter->add([
            'name'     => 'isdonationbanned',
            'required' => false,
            'filters'  => [
            ],
            'validators' => [
              [
                  'name'  => CustomBloodDonationValidator\CallbackIsDonationBannedIsPlannedTrue::class,
                  'options' => [
                    'callback' => function($value, $context=[]) {
                        if ($context['isplanned'] == 1) {
                          $isDonationBanned = $value;
                          if ($isDonationBanned == 1) {
                            return false;
                          }
                        }
                      return true;
                    }
                  ],
              ],
            ],
        ]);

        // Add input for "bancausetype" field
        $inputFilter->add([
                'name'     => 'bancausetype',
                'required' => false,
                'filters'  => [
                ],
                'validators' => [
                  [
                      'name'  => CustomBloodDonationValidator\CallbackBanCauseTypeIsPlannedTrue::class,
                      'options' => [
                        'callback' => function($value, $context=[]) {
                            if ($context['isplanned'] == 1) {
                              $banCauseType = $value;
                              if ($banCauseType > 0) {
                                return false;
                              }
                            }
                          return true;
                        }
                      ]
                  ],
                  [
                      'name'  => CustomBloodDonationValidator\CallbackBanCauseTypeIsDonationBannedTrue::class,
                      'options' => [
                        'callback' => function($value, $context=[]) {
                            if ($context['isdonationbanned'] == 1) {
                              $banCauseType = $value;
                              if ($banCauseType <= 0) {
                                return false;
                              }
                            }
                          return true;
                        }
                      ]
                  ],
                  [
                      'name'  => CustomBloodDonationValidator\CallbackBanCauseTypeIsDonationBannedFalse::class,
                      'options' => [
                        'callback' => function($value, $context=[]) {
                            if ($context['isdonationbanned'] == 0) {
                              $banCauseType = $value;
                              if ($banCauseType > 0) {
                                return false;
                              }
                            }
                          return true;
                        }
                      ]
                  ],
                ],
            ]);

            // Add input for "bancausedescription" field
            $inputFilter->add([
                    'name'     => 'bancausedescription',
                    'required' => false,
                    'filters'  => [
                    ],
                    'validators' => [
                      [
                          'name'    => 'StringLength',
                          'options' => [
                              'max' => 500,
                              'messages' => [
                                \Laminas\Validator\StringLength::TOO_LONG => 'Opis powodu dyskwalifikacji nie może mieć więcej niż %max% znaków.',
                              ],
                          ],
                      ],
                      [
                          'name'  => CustomBloodDonationValidator\CallbackBanCauseDescriptionIsPlannedTrue::class,
                          'options' => [
                            'callback' => function($value, $context=[]) {
                                if ($context['isplanned'] == 1) {
                                  $banCauseDescription = $value;
                                  if (strlen($banCauseDescription) > 0) {
                                    return false;
                                  }
                                }
                              return true;
                            }
                          ]
                      ],
                      [
                          'name'  => CustomBloodDonationValidator\CallbackBanCauseDescriptionIsDonationBannedFalse::class,
                          'options' => [
                            'callback' => function($value, $context=[]) {
                                if ($context['isdonationbanned'] == 0) {
                                  $banCauseDescription = $value;
                                  if (strlen($banCauseDescription) > 0) {
                                    return false;
                                  }
                                }
                              return true;
                            }
                          ]
                      ],
                    ],
                ]);

            // Add input for "bandateto" field
            $inputFilter->add([
                    'name'     => 'bandateto',
                    'required' => false,
                    'filters'  => [
                    ],
                    'validators' => [
                      [
                          'name'  => CustomBloodDonationValidator\CallbackBanDateToIsPlannedTrue::class,
                          'options' => [
                            'callback' => function($value, $context=[]) {
                                if ($context['isplanned'] == 1) {
                                  $banDateTo = $value;
                                  if ($banDateTo != "") {
                                    return false;
                                  }
                                }
                              return true;
                            }
                          ]
                      ],
                      [
                          'name'  => CustomBloodDonationValidator\CallbackBanDateToIsDonationBannedFalse::class,
                          'options' => [
                            'callback' => function($value, $context=[]) {
                                if ($context['isdonationbanned'] == 0) {
                                  $banDateTo = $value;
                                  if ($banDateTo != "") {
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
