<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackBanDateToIsDonationBannedFalse extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Data dyskwalifikacji nie może być ustawiona, gdy nie doszło do dyskwalifikacji z oddania',
  ];
}
