<?php
  namespace AuthorityTest\Model;

  use Authority\Entity\Authority;
  use Authority\Form\AuthorityForm;
  use PHPUnit\Framework\TestCase;

  class AuthorityTest extends testCase
  {
    public function testInitialAuthorityValuesAreNull()
    {
      $authority = new Authority();

      $this->assertNull($authority->getId(), '"id" should be null by default');
      $this->assertNull($authority->getName(), '"authority name" should be null by default');
      $this->assertNull($authority->getPosition(), '"position" should be null by default');
      $this->assertNull($authority->getDomain(), '"domain" should be null by default');
      $this->assertNull($authority->getExplanation(), '"explanation" should be null by default');
      $this->assertNull($authority->getIsHiddenInVcv(), '"isHiddenInVcv" should be null by default');
      $this->assertNull($authority->getUser(), '"user" should be null by default');
    }

    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'update';
      $authorityform = new AuthorityForm($scenario);

      $inputFilter = $authorityform->getInputFilter();

      //$this->assertSame(5, $inputFilter->count());
      $this->assertTrue($inputFilter->has('name'));
      //$this->assertTrue($inputFilter->has('user'));

    }

    public function testClassHasAttribute()
    {
      //Test attributes of class Authority
      $this->assertClassHasAttribute('id', Authority::class);
      $this->assertClassHasAttribute('name', Authority::class);
      $this->assertClassHasAttribute('position', Authority::class);
      $this->assertClassHasAttribute('domain', Authority::class);
      $this->assertClassHasAttribute('explanation', Authority::class);
      $this->assertClassHasAttribute('isHiddenInVcv', Authority::class);
      $this->assertClassHasAttribute('user', Authority::class);
    }

  }
?>
