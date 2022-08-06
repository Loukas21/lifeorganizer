<?php
  namespace BloodDonationTest\Model;

  use BloodDonation\Entity\BloodDonation;
  use BloodDonation\Form\BloodDonationForm;
  use PHPUnit\Framework\TestCase;

  class BloodDonationTest extends testCase
  {
    public function testInitialBloodDonationValuesAreNull()
    {
      $bloodDonation = new BloodDonation();

      $this->assertNull($bloodDonation->getId(), '"id" should be null by default');
      $this->assertNull($bloodDonation->getPlace(), '"place" should be null by default');
      $this->assertNull($bloodDonation->getIsPlanned(), '"is planned" should be null by default');
      $this->assertNull($bloodDonation->getIsDonationBanned(), '"is donation banned" should be null by default');
      $this->assertNull($bloodDonation->getBanCauseType(), '"ban cause type" should be null by default');
      $this->assertNull($bloodDonation->getBanCauseDescription(), '"ban cause description" should be null by default');
      $this->assertNull($bloodDonation->getBanDateTo(), '"ban date to" should be null by default');
      $this->assertNull($bloodDonation->getUser(), '"user" should be null by default');
    }

    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'update';
      $bloodDonationform = new BloodDonationForm($scenario);

      $inputFilter = $bloodDonationform->getInputFilter();

      //$this->assertSame(5, $inputFilter->count());
      $this->assertTrue($inputFilter->has('place'));
      $this->assertTrue($inputFilter->has('donationdate'));
      $this->assertTrue($inputFilter->has('donatedbloodamount'));
      $this->assertTrue($inputFilter->has('isdonationbanned'));
      $this->assertTrue($inputFilter->has('bancausetype'));
      $this->assertTrue($inputFilter->has('bancausedescription'));
      $this->assertTrue($inputFilter->has('bandateto'));

    }

    public function testClassHasAttribute()
    {
      //Test attributes of class BloodDonation
      $this->assertClassHasAttribute('id', BloodDonation::class);
      $this->assertClassHasAttribute('place', BloodDonation::class);
      $this->assertClassHasAttribute('isPlanned', BloodDonation::class);
      $this->assertClassHasAttribute('isDonationBanned', BloodDonation::class);
      $this->assertClassHasAttribute('banCauseType', BloodDonation::class);
      $this->assertClassHasAttribute('banCauseDescription', BloodDonation::class);
      $this->assertClassHasAttribute('banDateTo', BloodDonation::class);
      $this->assertClassHasAttribute('donatedBloodAmount', BloodDonation::class);
      //Test attributes of parent class - Event
      $this->assertClassHasAttribute('creationDate', BloodDonation::class);
      $this->assertClassHasAttribute('eventDate', BloodDonation::class);
      $this->assertClassHasAttribute('user', BloodDonation::class);
    }

    public function testBanCauseValuesAreCorrectlySet()
    {
      $bloodDonation = new BloodDonation();
      $this->assertEquals($bloodDonation::BAN_CAUSE_MEDICAL_TESTS,1);
      $this->assertEquals($bloodDonation::BAN_CAUSE_SCHEDULE,2);
      $this->assertEquals($bloodDonation::BAN_CAUSE_SELF_RESIGNATION,3);
      $this->assertEquals($bloodDonation::BAN_CAUSE_OTHER_CAUSE,4);

    }
  }
?>
