<?php
  namespace UserTest\Model;

  use User\Entity\User;
  use User\Form\UserForm;
  use PHPUnit\Framework\TestCase;

  class UserTest extends testCase
  {
    public function testInitialUserValuesAreNull()
    {
      $quote = new User();

      $this->assertNull($quote->getId(), '"id" should be null by default');
      $this->assertNull($quote->getEmail(), '"email" should be null by default');
      $this->assertNull($quote->getFullName(), '"full name" should be null by default');
      $this->assertNull($quote->getPassword(), '"password" should be null by default');
      $this->assertNull($quote->getStatus(), '"status" should be null by default');
      $this->assertNull($quote->getDateCreated(), '"date created" should be null by default');
      $this->assertNull($quote->getPasswordResetToken(), '"password reset token" should be null by default');
      $this->assertNull($quote->getPasswordResetTokenCreationDate(), '"password reset token creation date" should be null by default');
      $this->assertEmpty($quote->getRoles(), 'array "roles" should be empty by default');
    }

    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'create';
      $userform = new UserForm($scenario);

      $inputFilter = $userform->getInputFilter();

      //$this->assertSame(5, $inputFilter->count());
      $this->assertTrue($inputFilter->has('email'));
      $this->assertTrue($inputFilter->has('full_name'));
      $this->assertTrue($inputFilter->has('password'));
      $this->assertTrue($inputFilter->has('confirm_password'));
      $this->assertTrue($inputFilter->has('status'));
      $this->assertTrue($inputFilter->has('roles'));
    }

    /**
     * @dataProvider getInvalidUserData
     * @group inputFilters
     */
    public function testInputFiltersIncorrect($row)
    {
      $scenario = 'update';
      $user = new User();
      $userform = new UserForm($scenario);

      $userform->setInputFilter($userform->getInputFilter());
      $userform->setHydrator(new \Laminas\Hydrator\ObjectPropertyHydrator());
      $userform->bind($user);
      $userform->setData($row);

      $this->assertFalse($userform->isValid());
      $this->assertTrue(count($userform->getMessages()) > 0);
    }

    public function getInvalidUserData()
    {
      return [
        [
          [
            'id' => null,
            'email' => null,
            'fullName' => null,
            'password' => null,
            'status' => null,
            'dateCreated' => null,
            'passwordResetToken' => null,
            'passwordResetTokenCreationDate'=> null,
            'roles' => [],

          ],
          [
            'id' => 0,
            'email' => 123,
            'fullName' => null,
            'password' => null,
            'status' => null,
            'dateCreated' => null,
            'passwordResetToken' => null,
            'passwordResetTokenCreationDate'=> null,
            'roles' => [],
          ]
        ]
      ];
    }

  }
?>
