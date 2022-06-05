<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackCurrentProgressTotality extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Aktualny postęp nie może być większy niż całość',
  ];
}
