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
              ->findBy(['user'=>$userid], ['eventDate'=>'DESC']); //OWN CODE ELEMENT

    /*BLOOD DONATIONS STATISTICS*/
    // blood donation statistics array for dashboard
    $bloodDonationStats = [
      'bloodSum' => 0,
      'bloodDonationCount' => 0,
      'bloodDonationAttemptsCount' => 0,
      'firstBloodDonationDate' => '',
      'lastBloodDonationDate' => '',
      'lastSixBloodDonationsDates' => [],
      'lastSixBloodDonationsAmounts' => [],
      'eightWeeksConditionDate' => '',
      'sixDonationsPerYearConditionDate' => '',
      'eightWeeksConditionStringElements' => ['',''],
      'sixDonationsPerYearConditionStringElements' => ['',''],
      'nextSixPlannedBloodDonationsDates' => [],
      'nextPossibleDonationDate' => '',
      'nextPlannedDonationDate' => '',
      'lastSixBloodDonations' => [],
    ];

    //fill successful blood donation dates array with empty values
    $successfulBloodDonationDates = ['','','','','',''];
    //fill planned blood donation dates array with empty values
    $plannedBloodDonationDates = ['','','','','',''];

    $successfulBloodDonations = [

    ];

    // iterate blood donation records
    foreach ($bloodDonations as $donation) {
        // calculate blood donated amount
        $bloodDonationStats['bloodSum'] = $bloodDonationStats['bloodSum'] + (float) $donation->getDonatedBloodAmount();
        // only for donations which are not planned
        if ($donation->getIsPlanned() == false) {
          // count blood donation attempts
          $bloodDonationStats['bloodDonationAttemptsCount'] = $bloodDonationStats['bloodDonationAttemptsCount'] + 1;
          // only for donations which were not banned
          if ($donation->getIsDonationBanned() == false) {
            array_push($successfulBloodDonations,['date' => substr($donation->getEventDate(),0,10), 'amount' => $donation->getDonatedBloodAmount()]);
          }
        }
        else {
          //add planned donation
          array_push($plannedBloodDonationDates,$donation->getEventDate());
        }
    }
    $bloodDonationStats['bloodDonationCount'] = count($successfulBloodDonations);
    foreach ($successfulBloodDonations as $key => $row) {
      $date[$key] = $row['date'];
      $amount[$key] = $row['amount'];
    }

    $date  = array_column($successfulBloodDonations, 'date');
    $amount = array_column($successfulBloodDonations, 'amount');

    array_multisort($date, SORT_DESC, $amount, SORT_ASC, $successfulBloodDonations);

    if (count($successfulBloodDonations) >= 1){
        $bloodDonationStats['firstBloodDonationDate'] = end($successfulBloodDonations)['date'];
        $bloodDonationStats['lastBloodDonationDate'] = $successfulBloodDonations[0]['date'];
        $bloodDonationStats['lastSixBloodDonations'] = array_slice($successfulBloodDonations,0,6);
    }
    else {
      $bloodDonationStats['firstBloodDonationDate'] = '';
      $bloodDonationStats['lastBloodDonationDate'] = '';
    }

    $bloodDonationStats['lastSixBloodDonationsDates']  = array_column($bloodDonationStats['lastSixBloodDonations'], 'date');
    $bloodDonationStats['lastSixBloodDonationsAmounts'] = array_column($bloodDonationStats['lastSixBloodDonations'], 'amount');

    //sort successful blood donation dates
    rsort($successfulBloodDonationDates,);
    //sort planned blood donation dates
    rsort($plannedBloodDonationDates);

    //choose 6 most recent and 6 closest donations
    for ($i = 0; $i <= 5; $i++) {
        // choose 6 closest ones
        $bloodDonationStats['nextSixPlannedBloodDonationsDates'][$i] = substr($plannedBloodDonationDates[5-$i],0,10);
    }
    //calculate date of eight weeks condition
    if ($bloodDonationStats['lastBloodDonationDate'] == ''){
        $bloodDonationStats['eightWeeksConditionDate'] = date('Y-m-d');
    }
    else {
    $bloodDonationStats['eightWeeksConditionDate'] = date('Y-m-d', strtotime($bloodDonationStats['lastBloodDonationDate'] . ' + 57 days'));
    }
    //calculate date of six donations per year condition
    if (count($bloodDonationStats['lastSixBloodDonationsDates']) < 6 || $bloodDonationStats['lastSixBloodDonationsDates'][5] == '') {
          $bloodDonationStats['sixDonationsPerYearConditionDate'] = date('Y-m-d');
    }
    else {
    $bloodDonationStats['sixDonationsPerYearConditionDate'] = date('Y-m-d', strtotime($bloodDonationStats['lastSixBloodDonationsDates'][5] . ' + 366 days'));
    }
    //calculate the closest possible date of next donation
    $bloodDonationStats['nextPossibleDonationDate'] = max($bloodDonationStats['eightWeeksConditionDate'],$bloodDonationStats['sixDonationsPerYearConditionDate']);
    //choose next planned donation date

    if (empty(array_filter($bloodDonationStats['nextSixPlannedBloodDonationsDates'], function ($a) { return $a !== '';})) == true)
    {
          $bloodDonationStats['nextPlannedDonationDate'] = '';
    }
    else {
      $bloodDonationStats['nextPlannedDonationDate'] = min(array_diff($bloodDonationStats['nextSixPlannedBloodDonationsDates'],array(null)));
    }

    //if next planned donation date is set
    if ($bloodDonationStats['nextPlannedDonationDate'] != null) {
      //if next planned donation date is greater or equal than next possible donation date
      if ($bloodDonationStats['nextPlannedDonationDate'] >= $bloodDonationStats['nextPossibleDonationDate'])
      {
          //set eight weeks condition as passed
          $bloodDonationStats['eightWeeksConditionStringElements'][0] = '<i class="fas fa-check-circle" style="color: rgba(100,200,100,1);" title="Planowana data spełnia warunek"';
          $bloodDonationStats['eightWeeksConditionStringElements'][1] = 'background-good';
          //set six donations per year condition as passed
          $bloodDonationStats['sixDonationsPerYearConditionStringElements'][0] = '<i class="fas fa-check-circle" style="color: rgba(100,200,100,1);" title="Planowana data spełnia warunek"';
          $bloodDonationStats['sixDonationsPerYearConditionStringElements'][1] = 'background-good';
      }
      //if next planned donation date is less than next possible donation date
      else {
        //if next planned donation date is less than eight weeks condition date
        if ($bloodDonationStats['nextPlannedDonationDate'] < $bloodDonationStats['eightWeeksConditionDate']) {
          //set eight weeks condition as failed
          $bloodDonationStats['eightWeeksConditionStringElements'][0] = '<i class="fas fa-times-circle" style="color: rgba(200,100,100,1);" title="Planowana data nie spełnia warunku"';
          $bloodDonationStats['eightWeeksConditionStringElements'][1] = 'background-bad';
          //set six donations per year condition as passed
          $bloodDonationStats['sixDonationsPerYearConditionStringElements'][0] = '<i class="fas fa-check-circle" style="color: rgba(100,200,100,1);" title="Planowana data spełnia warunek"';
          $bloodDonationStats['sixDonationsPerYearConditionStringElements'][1] = 'background-good';
        }
        //if next planned donation date is less than six donations per year condition date
        if ($bloodDonationStats['nextPlannedDonationDate'] < $bloodDonationStats['sixDonationsPerYearConditionDate']) {
          //set six donations per year condition as failed
          $bloodDonationStats['sixDonationsPerYearConditionStringElements'][0] = '<i class="fas fa-times-circle" style="color: rgba(200,100,100,1);" title="Planowana data nie spełnia warunku"';
          $bloodDonationStats['sixDonationsPerYearConditionStringElements'][1] = 'background-bad';
        }
      }
    }
    /*END OF BLOOD DONATIONS STATISTICS*/

    return new ViewModel([
      'bloodDonations' => $bloodDonations,
      'bloodDonationStats' => $bloodDonationStats
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
