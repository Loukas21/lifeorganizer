<?php

namespace Publication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;
use Application\Entity\Post;
use Publication\Entity\Publication;
use Publication\Form\PublicationForm;

class BookController extends AbstractActionController
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Publication manager.
   * @var Publication\Service\PublicationManager
   */
  private $publicationManager;

  public function __construct($entityManager, $publicationManager)
  {
    $this->entityManager = $entityManager;
    $this->publicationManager = $publicationManager;
  }

  public function indexAction()
  {
    if (!$this->access('books.manage')){
      $this->getResponse()->setStatusCode(401);
      return;
    }

    /*OWN CODE*/
    $userid = 0;
    //check if user is logged in
    if ($this->identity()!=null)
    {
      //find user by email
      $user = $this->entityManager->getRepository(User::class)
              ->findOneByEmail($this->identity());
      //get user ID
      $userid = $user->getId();
    }
    /*END OF OWN CODE*/

    $publications = $this->entityManager->getRepository(Publication::class)
              ->findBy(['user'=>$userid], ['id'=>'DESC']); //OWN CODE ELEMENT

    return new ViewModel([
      'publications' => $publications
    ]);
  }

  public function addAction()
  {
    /*OWN CODE*/
    $userid = 0;
    //check if user is logged in
    if ($this->identity()!=null)
    {
      //find user by email
      $user = $this->entityManager->getRepository(User::class)
              ->findOneByEmail($this->identity());
      //get user id
      $userid = $user->getId();
    }

    /*END OF OWN CODE*/

    $form = new PublicationForm('create', $this->entityManager);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();
      $data['user'] = $userid; //OWN CODE ELEMENT

      $form->setData($data);
      if($form->isValid()) {
        $data = $form->getData();

        $publication = $this->publicationManager->addPublication($data);

        return $this->redirect()->toRoute('books',
              ['action' => 'index']); //tu albo akcja view z Id albo akcja indexAction
      }
      else {
        return new ViewModel([
          'form' => $form,
        ]);
      }
    }
    return new ViewModel([
      'form' => $form
    ]);
  }

  public function viewAction()
  {
      //póki co bez ciała funkcji
  }

  public function editAction()
  {
    $id = (int)$this->params()->fromRoute('id', -1);
    if ($id<1) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $publication = $this->entityManager->getRepository(Publication::class)
            ->find($id);

    if ($publication == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $form = new PublicationForm('update', $this->entityManager, $publication);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $this->publicationManager->updatePublication($publication, $data);

        return $this->redirect()->toRoute('books',
                    ['action' => 'index']);

      }
      else{ //TEST
        //  echo "Form is not valid"; //TEST
          //return new ViewModel(array(
        //    'publication' => $publication,
        //    'form' => $form,
      //    ));
      } //TEST

    } else {

      $form->setData(array(
        'id' => $publication->getId(),
        'user' => $publication->getUser(),
        'author' => $publication->getAuthor(),
        'title' => $publication->getTitle(),
        'type' => $publication->getType(),
        'description' => $publication->getDescription(),
        'iswanted' => $publication->getIsWanted(),
        'totality' => $publication->getTotality(),
        'startdate' => $publication->getStartDate(),
        'currentprogress' => $publication->getCurrentProgress(),
        'currentprogressdate' => $publication->getCurrentProgressDate(),
        'lastprogress' => $publication->getLastProgress(),
        'lastprogressdate' => $publication->getLastProgressDate(),
        'ishiddeninvcv' => $publication->getIsHiddenInVcv(),
        'isfinished' => $publication->getIsFinished(),
        'finishdate' => $publication->getFinishDate()
      ));
    }
    return new ViewModel(array(
      'publication' => $publication,
      'form' => $form,
    ));
  }

  public function deleteAction()
  {
      $id = (int)$this->params()->fromRoute('id', -1);
      if ($id<1) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      $publication = $this->entityManager->getRepository(Publication::class)
              ->find($id);

      if ($publication == null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      // Delete book.
      $this->publicationManager->deletePublication($publication);

      // Add a flash message.
      $this->flashMessenger()->addSuccessMessage('Publikacja została usunięta.');

      // Redirect to "index" page
      return $this->redirect()->toRoute('books', ['action'=>'index']);
  }

}
