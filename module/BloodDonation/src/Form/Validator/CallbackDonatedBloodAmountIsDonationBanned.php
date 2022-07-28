<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackDonatedBloodAmountIsDonationBanned extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Przy dyskwalifikacji z oddania, ilość oddanej krwi nie powinna być większa od 0',
  ];
}
