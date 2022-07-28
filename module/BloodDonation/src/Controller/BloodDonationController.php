<?php
namespace BloodDonation\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;
use Application\Entity\Post;
use BloodDonation\Entity\Event;
use BloodDonation\Entity\BloodDonation;
use BloodDonation\Form\BloodDonationForm;

class BloodDonationController extends AbstractActionController
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * BloodDonation manager.
   * @var BloodDonation\Service\BloodDonationManager
   */
  private $bloodDonationManager;

  public function __construct($entityManager, $bloodDonationManager)
  {
    $this->entityManager = $entityManager;
    $this->bloodDonationManager = $bloodDonationManager;
  }

  public function indexAction()
  {
    if (!$this->access('blooddonation.manage')){
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

    $bloodDonations = $this->entityManager->getRepository(BloodDonation::class)
              ->findBy(['user'=>$userid], ['eventDate'=>'ASC']); //OWN CODE ELEMENT

    return new ViewModel([
      'bloodDonations' => $bloodDonations
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

    $form = new BloodDonationForm('create', $this->entityManager);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();
      $data['user'] = $userid; //OWN CODE ELEMENT

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $bloodDonation = $this->bloodDonationManager->addBloodDonation($data);

        return $this->redirect()->toRoute('blooddonation',
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

    $bloodDonation = $this->entityManager->getRepository(BloodDonation::class)
            ->find($id);

    if ($bloodDonation == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $form = new BloodDonationForm('update', $this->entityManager, $bloodDonation);
    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $this->bloodDonationManager->updateBloodDonation($bloodDonation, $data);

        return $this->redirect()->toRoute('blooddonation',
                    ['action' => 'index']);
      }
      else {
        return new ViewModel(array(
          'bloodDonation' => $bloodDonation,
          'form' => $form
        ));
      }
    } else {
      $form->setData(array(
        'place' => $bloodDonation->getPlace(),
        'donationdate' => substr($bloodDonation->getEventDate(),0,10),
        'isplanned' => $bloodDonation->getIsPlanned(),
        'isdonationbanned' => $bloodDonation->getIsDonationBanned(),
        'bancausetype' => $bloodDonation->getBanCauseType(),
        'bancausedescription' => $bloodDonation->getBanCauseDescription(),
        'bandateto' => substr($bloodDonation->getBanDateTo(),0,10),
        'donatedbloodamount' => $bloodDonation->getDonatedBloodAmount(),
        'user' => $bloodDonation->getUser()
      ));

      return new ViewModel(array(
        'bloodDonation' => $bloodDonation,
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

      $bloodDonation = $this->entityManager->getRepository(BloodDonation::class)
              ->find($id);

      if ($bloodDonation == null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      // Delete blood donation.
      $this->bloodDonationManager->deleteBloodDonation($bloodDonation);

      // Add a flash message.
      $this->flashMessenger()->addSuccessMessage('Donacja została usunięta.');

      // Redirect to "index" page
      return $this->redirect()->toRoute('blooddonation', ['action'=>'index']);
  }

}
