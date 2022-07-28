<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackIsDonationBannedIsPlannedTrue extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Nie można ustawić rezygnacji z oddania dla planowanej donacji',
  ];
}
