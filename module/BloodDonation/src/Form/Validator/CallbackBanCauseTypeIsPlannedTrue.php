<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackBanCauseTypeIsPlannedTrue extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Typ powodu dyskwalifikacji nie powinien być wybrany, gdy donacja jest planowana',
  ];
}
