<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackTypeIsWantedTrue extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Typ nie powinien być określony dla publikacji z listy życzeń',
  ];
}
