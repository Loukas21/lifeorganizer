<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackBanDateToIsPlannedTrue extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Data dyskwalifikacji nie może być ustawiona, gdy donacja jest planowana',
  ];
}
