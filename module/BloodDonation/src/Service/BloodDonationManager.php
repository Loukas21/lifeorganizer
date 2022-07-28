<?php
namespace BloodDonation\Service;

use BloodDonation\Entity\BloodDonation;

class BloodDonationManager
{

  /**
   * Doctrine entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * PHP template renderer.
   * @var Laminas\View\Renderer\PhpRenderer
   */
  private $viewRenderer;

  /**
   * App config.
   * @var array
   */
  private $config;

  public function __construct($entityManager, $viewRenderer, $config)
  {
    $this->entityManager = $entityManager;
    $this->viewRenderer = $viewRenderer;
    $this->config = $config;
  }

  public function addBloodDonation($data)
  {

    // Create new BloodDonation entity.
    $bloodDonation = new BloodDonation();
    $bloodDonation->setPlace($data['place']);

    if ($data['donationdate'] != ''){
        $bloodDonation->setEventDate($data['donationdate'] . " 23:59:59");
    }
    else {
        $bloodDonation->setEventDate(null);
    }

    $bloodDonation->setIsPlanned($data['isplanned']);
    $bloodDonation->setIsDonationBanned($data['isdonationbanned']);
    $bloodDonation->setBanCauseType($data['bancausetype']);
    $bloodDonation->setBanCauseDescription($data['bancausedescription']);

    if ($data['bandateto'] != ''){
      $bloodDonation->setBanDateTo($data['bandateto'] . " 23:59:59");
    }
    else {
      $bloodDonation->setBanDateTo(null);
    }

    $bloodDonation->setDonatedBloodAmount($data['donatedbloodamount']);
    $bloodDonation->setUser($data['user']);

    // Add the entity to the entity manager.
    $this->entityManager->persist($bloodDonation);

    // Apply changes to database.
    $this->entityManager->flush();

    return $bloodDonation;
  }

  public function updateBloodDonation($bloodDonation, $data)
  {

    $bloodDonation->setPlace($data['place']);
    if ($data['donationdate'] != ''){
        $bloodDonation->setEventDate($data['donationdate'] . " 23:59:59");
    }
    else {
        $bloodDonation->setEventDate(null);
    }
    $bloodDonation->setIsPlanned($data['isplanned']);
    $bloodDonation->setIsDonationBanned($data['isdonationbanned']);
    $bloodDonation->setBanCauseType($data['bancausetype']);
    $bloodDonation->setBanCauseDescription($data['bancausedescription']);
    if ($data['bandateto'] != ''){
      $bloodDonation->setBanDateTo($data['bandateto'] . " 23:59:59");
    }
    else {
      $bloodDonation->setBanDateTo(null);
    }
    $bloodDonation->setDonatedBloodAmount($data['donatedbloodamount']);

    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  public function deleteBloodDonation($bloodDonation)
  {
      $this->entityManager->remove($bloodDonation);
      $this->entityManager->flush();

  }

}
