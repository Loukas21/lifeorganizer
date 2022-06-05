<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackCurrentProgressType extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Jeśli nie jest określony typ publikacji, to postęp powinien być równy 0',
  ];
}
