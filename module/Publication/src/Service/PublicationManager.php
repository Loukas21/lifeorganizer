<?php
namespace Publication\Service;

use Publication\Entity\Publication;

class PublicationManager
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

  public function addPublication($data)
  {

    // Create new Publication entity.
    $publication = new Publication();

    // Hidden field with user logged in
    $publication->setUser($data['user']);
    // Always displayed fields on add form
    $publication->setTitle($data['title']);
    $publication->setAuthor($data['author']);
    $publication->setType($data['type']);
    $publication->setDescription($data['description']);
    $publication->setIsHiddenInVcv($data['ishiddeninvcv']);
    // IsWanted field
    $publication->setIsWanted($data['iswanted']);
    $publication->setTotality($data['totality']);
    $publication->setCurrentProgress(0);
    // Fields hidden when IsWanted field is checked
    if ($data['totality'] == null) {
        $publication->setTotality(0);
    }

    // Add the entity to the entity manager.
    $this->entityManager->persist($publication);

    // Apply changes to database.
    $this->entityManager->flush();

    return $publication;
  }

  public function updatePublication($publication, $data)
  {

    //Text data
    // set 'author'
    $publication->setAuthor($data['author']);
    // set 'title'
    $publication->setTitle($data['title']);
    // set 'iswanted'
    $publication->setIsWanted($data['iswanted']);
    // set 'type'
    $publication->setType($data['type']);
    // set 'description'
    $publication->setDescription($data['description']);
    // set 'ishiddeninvcv'
    $publication->setIsHiddenInVcv($data['ishiddeninvcv']);

    // set last value in 'start date' field
    $publication->setStartDate($publication->getStartDate());
    // set last value in 'start date' field
    $publication->setFinishDate($publication->getFinishDate());
    // set last value in 'start date' field
    $publication->setCurrentProgressDate($publication->getCurrentProgressDate());
    // set last value in 'start date' field
    $publication->setLastProgressDate($publication->getLastProgressDate());

    // if publication is finished at the moment
    if ($publication->getIsFinished() == 0 && $data['isfinished'] == 1) {
          //set 'finish date'
          $publication->setFinishDate(date("Y-m-d H:i:s"));
    }
    // if last value in 'current progress' field is less than current value
    if ($publication->getCurrentProgress() < $data['currentprogress']){
        // if last value in 'current progress' field was zero
        if ($publication->getCurrentProgress() == 0) {
          // set 'start date'
          $publication->setStartDate(date("Y-m-d H:i:s"));
        }
        // if last value in 'current progress' field was more than zero
        else {
          // set 'last progress date'
          $publication->setLastProgressDate($publication->getCurrentProgressDate());
          // set 'last progress'
          $publication->setLastProgress($publication->getCurrentProgress());
        }
        // set 'current progress'
        $publication->setCurrentProgress($data['currentprogress']);
        // set 'current progress date'
        $publication->setCurrentProgressDate(date("Y-m-d H:i:s"));
    }
    // set 'totality'
    $publication->setTotality($data['totality']);
    // set 'is finished'
    $publication->setIsFinished($data['isfinished']);

    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  public function deletePublication($publication)
  {
      $this->entityManager->remove($publication);
      $this->entityManager->flush();

  }

}
