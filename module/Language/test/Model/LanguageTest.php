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
      $this->assertTrue($inputFilter->has('language'));
      $this->assertTrue($inputFilter->has('yearsofstudy'));
      $this->assertTrue($inputFilter->has('certificatedescription'));
      $this->assertTrue($inputFilter->has('certificatedate'));
      //$this->assertTrue($inputFilter->has('user'));

    }

    public function testClassHasAttribute()
    {
      //Test attributes of class BloodDonation
      $this->assertClassHasAttribute('id', Language::class);
      $this->assertClassHasAttribute('language', Language::class);
      $this->assertClassHasAttribute('yearsOfStudy', Language::class);
      $this->assertClassHasAttribute('level', Language::class);
      $this->assertClassHasAttribute('hasCertificate', Language::class);
      $this->assertClassHasAttribute('certificateDescription', Language::class);
      $this->assertClassHasAttribute('certificateDate', Language::class);
      $this->assertClassHasAttribute('user', Language::class);
    }

    public function testLanguageIdValuesAreCorrectlySet()
    {
      $language = new Language();
      $this->assertEquals($language::LANGUAGE_POLISH,1);
      $this->assertEquals($language::LANGUAGE_ENGLISH,2);
      $this->assertEquals($language::LANGUAGE_GERMAN,3);
      $this->assertEquals($language::LANGUAGE_RUSSIAN,4);

    }

    public function testLanguageLevelValuesAreCorrectlySet()
    {
      $language = new Language();
      $this->assertEquals($language::LEVEL_UNDETERMINED,0);
      $this->assertEquals($language::LEVEL_A1,1);
      $this->assertEquals($language::LEVEL_A2,2);
      $this->assertEquals($language::LEVEL_B1,3);
      $this->assertEquals($language::LEVEL_B2,4);
      $this->assertEquals($language::LEVEL_C1,5);
      $this->assertEquals($language::LEVEL_C2,6);
      $this->assertEquals($language::LEVEL_NATIVE,7);

    }

    public function testFlagStringsAreCorrectlySet()
    {
      $language = new Language();
      $flagStrings = $language->getFlagStringListByLanguage();
      $this->assertEquals($flagStrings[Language::LANGUAGE_POLISH],'pl');
      $this->assertEquals($flagStrings[Language::LANGUAGE_ENGLISH],'gb');
      $this->assertEquals($flagStrings[Language::LANGUAGE_GERMAN],'de');
      $this->assertEquals($flagStrings[Language::LANGUAGE_RUSSIAN],'ru');
    }

    public function testLanguageHasCorrectlyPolishNames()
    {
      $language = new Language();
      $languagePolishNames = $language->getLanguageList();
      $this->assertEquals($languagePolishNames[Language::LANGUAGE_POLISH],'polski');
      $this->assertEquals($languagePolishNames[Language::LANGUAGE_ENGLISH],'angielski');
      $this->assertEquals($languagePolishNames[Language::LANGUAGE_GERMAN],'niemiecki');
      $this->assertEquals($languagePolishNames[Language::LANGUAGE_RUSSIAN],'rosyjski');
    }

    public function testLanguageLevelsHasCorrectlyPolishNames()
    {
      $language = new Language();
      $languageLevelPolishNames = $language->getLevelList();
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_UNDETERMINED],'--nieokreślony--');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_A1],'początkujący (A1)');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_A2],'podstawowy (A2)');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_B1],'średnio zaawansowany (B1)');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_B2],'wyższy średnio zaawansowany (B2)');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_C1],'zaawansowany (C1)');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_C2],'zaawansowany biegły (C2)');
      $this->assertEquals($languageLevelPolishNames[Language::LEVEL_NATIVE],'język ojczysty');
    }

  }
?>
