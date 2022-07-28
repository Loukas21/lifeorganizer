<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackDonatedBloodAmountIsPlanned extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Dla planowanej donacji ilość oddanej krwi nie powinna być większa od 0',
  ];
}
