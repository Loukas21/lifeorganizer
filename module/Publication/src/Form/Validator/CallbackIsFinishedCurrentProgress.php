<?php
namespace Publication\Form\Validator;

use Laminas\Validator\Callback;

class CallbackIsFinishedCurrentProgress extends Callback
{
  /**
   * Validation failure message template definitions
   *
   * @var array
   */
  protected $messageTemplates = [
      self::INVALID_VALUE    => 'Nie można oznaczyć publikacji jako ukończonej - aktualny postęp jest mniejszy od całości',
  ];
}
