<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackBanCauseTypeIsDonationBannedFalse extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Typ powodu nie powinien być ustawiony, gdy dyskwalifikacja z oddania nie jest zaznaczona',
  ];
}
