<?php
namespace Authority\Service;

use Authority\Entity\Authority;

class AuthorityManager
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

  public function addAuthority($data)
  {

    // Create new authority entity.
    $authority = new Authority();
    $authority->setName($data['name']);
    $authority->setPosition($data['position']);
    $authority->setDomain($data['domain']);
    $authority->setExplanation($data['explanation']);
    $authority->setIsHiddenInVcv($data['ishiddeninvcv']);
    $authority->setUser($data['user']);

    // Add the entity to the entity manager.
    $this->entityManager->persist($authority);

    // Apply changes to database.
    $this->entityManager->flush();

    return $authority;
  }

  public function updateAuthority($authority, $data)
  {

    $authority->setName($data['name']);
    $authority->setPosition($data['position']);
    $authority->setDomain($data['domain']);
    $authority->setExplanation($data['explanation']);
    $authority->setIsHiddenInVcv($data['ishiddeninvcv']);

    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  public function deleteAuthority($authority)
  {
      $this->entityManager->remove($authority);
      $this->entityManager->flush();

  }

}
