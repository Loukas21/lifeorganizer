<?php
namespace Hobby\Service;

use Hobby\Entity\Hobby;

class HobbyManager
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

  public function addHobby($data)
  {

    // Create new hobby entity.
    $hobby = new Hobby();
    $hobby->setName($data['name']);
    $hobby->setPosition($data['position']);
    $hobby->setIsHiddenInVcv($data['ishiddeninvcv']);
    $hobby->setUser($data['user']);

    // Add the entity to the entity manager.
    $this->entityManager->persist($hobby);

    // Apply changes to database.
    $this->entityManager->flush();

    return $hobby;
  }

  public function updateHobby($hobby, $data)
  {

    $hobby->setName($data['name']);
    $hobby->setPosition($data['position']);
    $hobby->setIsHiddenInVcv($data['ishiddeninvcv']);

    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  public function deleteHobby($hobby)
  {
      $this->entityManager->remove($hobby);
      $this->entityManager->flush();

  }

}
