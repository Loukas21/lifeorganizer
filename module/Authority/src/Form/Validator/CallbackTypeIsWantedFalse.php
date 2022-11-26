<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackTypeIsWantedFalse extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Wybierz typ publikacji',
  ];
}
