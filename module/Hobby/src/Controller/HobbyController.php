<?php
namespace Hobby\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;
use Application\Entity\Post;
use Hobby\Entity\Hobby;
use Hobby\Form\HobbyForm;

class HobbyController extends AbstractActionController
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Hobby manager.
   * @var Hobby\Service\HobbyManager
   */
  private $hobbyManager;

  public function __construct($entityManager, $hobbyManager)
  {
    $this->entityManager = $entityManager;
    $this->hobbyManager = $hobbyManager;
  }

  public function indexAction()
  {
    if (!$this->access('hobbies.manage')){
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

    $hobbies = $this->entityManager->getRepository(Hobby::class)
              ->findBy(['user'=>$userid], ['id'=>'DESC']); //OWN CODE ELEMENT

    return new ViewModel([
      'hobbies' => $hobbies
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

    $form = new HobbyForm('create', $this->entityManager);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();
      $data['user'] = $userid; //OWN CODE ELEMENT

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $hobby = $this->hobbyManager->addHobby($data);

        return $this->redirect()->toRoute('hobbies',
              ['action' => 'index']); //tu albo akcja view z Id albo akcja indexAction
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

    $hobby = $this->entityManager->getRepository(Hobby::class)
            ->find($id);

    if ($hobby == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $form = new HobbyForm('update', $this->entityManager, $hobby);
    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $this->hobbyManager->updateHobby($hobby, $data);

        return $this->redirect()->toRoute('hobbies',
                    ['action' => 'index']);
      }
      else {
        return new ViewModel(array(
          'hobby' => $hobby,
          'form' => $form
        ));
      }
    } else {
      $form->setData(array(
        'name' => $hobby->getName(),
        'position' => $hobby->getPosition(),
        'ishiddeninvcv' => $hobby->getIsHiddenInVcv(),
        'user' => $hobby->getUser()
      ));

      return new ViewModel(array(
        'hobby' => $hobby,
        'form' => $form
      ));
    }
  }

  public function deleteAction()
  {
      $id = (int)$this->params()->fromRoute('id', -1);
      if ($id<1) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      $hobby = $this->entityManager->getRepository(Hobby::class)
              ->find($id);

      if ($hobby == null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      // Delete hobby.
      $this->hobbyManager->deleteHobby($hobby);

      // Add a flash message.
      $this->flashMessenger()->addSuccessMessage('Zainteresowanie zostało usunięte.');

      // Redirect to "index" page
      return $this->redirect()->toRoute('hobbies', ['action'=>'index']);
  }

}
