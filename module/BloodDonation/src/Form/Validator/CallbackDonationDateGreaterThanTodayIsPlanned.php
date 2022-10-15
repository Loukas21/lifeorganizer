<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackDonationDateGreaterThanTodayIsPlanned extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Data skutecznej donacji nie powinna być późniejsza od bieżącej.',
  ];
}
