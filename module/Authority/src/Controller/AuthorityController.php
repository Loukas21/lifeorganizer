<?php
namespace Authority\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;
use Application\Entity\Post;
use Authority\Entity\Authority;
use Authority\Form\AuthorityForm;

class AuthorityController extends AbstractActionController
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Authority manager.
   * @var Authority\Service\AuthorityManager
   */
  private $authorityManager;

  public function __construct($entityManager, $authorityManager)
  {
    $this->entityManager = $entityManager;
    $this->authorityManager = $authorityManager;
  }

  public function indexAction()
  {
    if (!$this->access('authorities.manage')){
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

    $authorities = $this->entityManager->getRepository(Authority::class)
              ->findBy(['user'=>$userid], ['id'=>'DESC']); //OWN CODE ELEMENT

    return new ViewModel([
      'authorities' => $authorities
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

    $form = new AuthorityForm('create', $this->entityManager);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();
      $data['user'] = $userid; //OWN CODE ELEMENT

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $authority = $this->authorityManager->addAuthority($data);

        return $this->redirect()->toRoute('authorities',
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

    $authority = $this->entityManager->getRepository(Authority::class)
            ->find($id);

    if ($authority == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $form = new AuthorityForm('update', $this->entityManager, $authority);
    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $this->authorityManager->updateAuthority($authority, $data);

        return $this->redirect()->toRoute('authorities',
                    ['action' => 'index']);
      }
      else {
        return new ViewModel(array(
          'authority' => $authority,
          'form' => $form
        ));
      }
    } else {
      $form->setData(array(
        'name' => $authority->getName(),
        'position' => $authority->getPosition(),
        'domain' => $authority->getDomain(),
        'explanation' => $authority->getExplanation(),
        'ishiddeninvcv' => $authority->getIsHiddenInVcv(),
        'user' => $authority->getUser()
      ));

      return new ViewModel(array(
        'authority' => $authority,
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

      $authority = $this->entityManager->getRepository(Authority::class)
              ->find($id);

      if ($authority == null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      // Delete authority.
      $this->authorityManager->deleteAuthority($authority);

      // Add a flash message.
      $this->flashMessenger()->addSuccessMessage('Autorytet został usunięty.');

      // Redirect to "index" page
      return $this->redirect()->toRoute('authorities', ['action'=>'index']);
  }

}
