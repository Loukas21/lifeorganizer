<?php
namespace BloodDonation\Form\Validator;

use Laminas\Validator\Callback;

class CallbackBanCauseDescriptionIsPlannedTrue extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Opis powodu dyskwalifikacji nie może być wypełniony, gdy donacja jest planowana',
  ];
}
