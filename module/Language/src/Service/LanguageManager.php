<?php
namespace Language\Service;

use Language\Entity\Language;

class LanguageManager
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

  public function addLanguage($data)
  {

    // Create new Language entity.
    $language = new Language();
    $language->setLanguage($data['language']);
    $language->setYearsOfStudy($data['yearsofstudy']);
    $language->setLevel($data['level']);
    $language->setHasCertificate($data['hascertificate']);
    $language->setCertificateDescription($data['certificatedescription']);
    if ($data['certificatedate'] == '') {
          $language->setCertificateDate(null);
    }
    else {
        $language->setCertificateDate($data['certificatedate']);
    }
    $language->setUser($data['user']);

    // Add the entity to the entity manager.
    $this->entityManager->persist($language);

    // Apply changes to database.
    $this->entityManager->flush();

    return $language;
  }

  public function updateLanguage($language, $data)
  {

    $language->setLanguage($data['language']);
    $language->setYearsOfStudy($data['yearsofstudy']);
    $language->setLevel($data['level']);
    $language->setHasCertificate($data['hascertificate']);
    $language->setCertificateDescription($data['certificatedescription']);
    if ($data['certificatedate'] == '') {
          $language->setCertificateDate(null);
    }
    else {
        $language->setCertificateDate($data['certificatedate']);
    }

    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  public function deleteLanguage($language)
  {
      $this->entityManager->remove($language);
      $this->entityManager->flush();

  }

}
