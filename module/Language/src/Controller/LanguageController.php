<?php
namespace Language\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;
use Application\Entity\Post;
use Language\Entity\Language;
use Language\Form\LanguageForm;

class LanguageController extends AbstractActionController
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Language manager.
   * @var Language\Service\LanguageManager
   */
  private $languageManager;

  public function __construct($entityManager, $languageManager)
  {
    $this->entityManager = $entityManager;
    $this->languageManager = $languageManager;
  }

  public function indexAction()
  {
    if (!$this->access('languages.manage')){
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

    $languages = $this->entityManager->getRepository(Language::class)
              ->findBy(['user'=>$userid], ['id'=>'DESC']); //OWN CODE ELEMENT

    return new ViewModel([
      'languages' => $languages
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

    $form = new LanguageForm('create', $this->entityManager);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();
      $data['user'] = $userid; //OWN CODE ELEMENT

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $language = $this->languageManager->addLanguage($data);

        return $this->redirect()->toRoute('languages',
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

    $language = $this->entityManager->getRepository(Language::class)
            ->find($id);

    if ($language == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $form = new LanguageForm('update', $this->entityManager, $language);
    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $this->languageManager->updateLanguage($language, $data);

        return $this->redirect()->toRoute('languages',
                    ['action' => 'index']);
      }
      else {
        return new ViewModel(array(
          'language' => $language,
          'form' => $form
        ));
      }
    } else {
      $form->setData(array(
        'language' => $language->getLanguage(),
        'yearsofstudy' => $language->getYearsOfStudy(),
        'level' => $language->getLevel(),
        'hascertificate' => $language->getHasCertificate(),
        'certificatedescription' => $language->getCertificateDescription(),
        //get date from datetime
        'certificatedate' => substr($language->getCertificateDate(),0,10),
        'user' => $language->getUser()
      ));

      return new ViewModel(array(
        'language' => $language,
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

      $language = $this->entityManager->getRepository(Language::class)
              ->find($id);

      if ($language == null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      // Delete language.
      $this->languageManager->deleteLanguage($language);

      // Add a flash message.
      $this->flashMessenger()->addSuccessMessage('Język został usunięty.');

      // Redirect to "index" page
      return $this->redirect()->toRoute('languages', ['action'=>'index']);
  }

}
