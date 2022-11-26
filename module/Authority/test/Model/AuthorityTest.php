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
      $this->assertNull($authority->getYearsOfStudy(), '"years of study" should be null by default');
      $this->assertNull($authority->getLevel(), '"level" should be null by default');
      $this->assertNull($authority->getHasCertificate(), '"has certificate" should be null by default');
      $this->assertNull($authority->getCertificateDescription(), '"certificate description" should be null by default');
      $this->assertNull($authority->getCertificateDate(), '"certificate date" should be null by default');
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
      //Test attributes of class BloodDonation
      $this->assertClassHasAttribute('id', Authority::class);
      $this->assertClassHasAttribute('name', Authority::class);
      $this->assertClassHasAttribute('user', Authority::class);
    }

  }
?>
