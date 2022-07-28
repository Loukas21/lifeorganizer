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
  }
?>
