<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackIsFinishedTotality extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Nie można oznaczyć publikacji jako ukończonej - całość jest równa 0',
  ];
}
