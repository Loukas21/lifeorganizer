<?php
  namespace LanguageTest\Model;

  use Language\Entity\Language;
  use Language\Form\LanguageForm;
  use PHPUnit\Framework\TestCase;

  class LanguageTest extends testCase
  {
    public function testInitialLanguageValuesAreNull()
    {
      $language = new Language();

      $this->assertNull($language->getId(), '"id" should be null by default');
      $this->assertNull($language->getLanguage(), '"language" should be null by default');
      $this->assertNull($language->getYearsOfStudy(), '"years of study" should be null by default');
      $this->assertNull($language->getLevel(), '"level" should be null by default');
      $this->assertNull($language->getHasCertificate(), '"has certificate" should be null by default');
      $this->assertNull($language->getCertificateDescription(), '"certificate description" should be null by default');
      $this->assertNull($language->getCertificateDate(), '"certificate date" should be null by default');
      $this->assertNull($language->getUser(), '"user" should be null by default');
    }

    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'update';
      $languageform = new LanguageForm($scenario);

      $inputFilter = $languageform->getInputFilter();

      //$this->assertSame(5, $inputFilter->count());
      $this->assertTrue($inputFilter->has('yearsofstudy'));
      $this->assertTrue($inputFilter->has('certificatedescription'));
      //$this->assertTrue($inputFilter->has('user'));

    }
  }
?>
