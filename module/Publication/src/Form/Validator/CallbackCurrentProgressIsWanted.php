<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackCurrentProgressIsWanted extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Postęp publikacji na liście życzeń nie może być większy od 0',
  ];
}
