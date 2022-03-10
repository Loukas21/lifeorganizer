<?php

namespace Quote\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use User\Entity\User;
use Application\Entity\Post;
use Quote\Entity\Quote;
use Quote\Form\QuoteForm;

class QuoteController extends AbstractActionController
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Quote manager.
   * @var Quote\Service\QuoteManager
   */
  private $quoteManager;

  public function __construct($entityManager, $quoteManager)
  {
    $this->entityManager = $entityManager;
    $this->quoteManager = $quoteManager;
  }

  public function indexAction()
  {
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

    if (!$this->access('quotes.manage')){
      $this->getResponse()->setStatusCode(401);
      return;
    }
    $page = $this->params()->fromQuery('page', 1);
    $query = $this->entityManager->getRepository(Quote::class)
              ->findQuotesByUser($userid); //OWN CODE ELEMENT

    $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
    $paginator = new Paginator($adapter);
    $paginator->setDefaultItemCountPerPage(10);
    $paginator->setCurrentPageNumber($page);

    return new ViewModel([
      'quotes' => $paginator
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

    $form = new QuoteForm('create', $this->entityManager);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();
      $data['user'] = $userid; //OWN CODE ELEMENT

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $quote = $this->quoteManager->addQuote($data);

        return $this->redirect()->toRoute('quotes',
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

    $quote = $this->entityManager->getRepository(Quote::class)
            ->find($id);

    if ($quote == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $form = new QuoteForm('update', $this->entityManager, $quote);

    if ($this->getRequest()->isPost()) {
      $data = $this->params()->fromPost();

      $form->setData($data);

      if($form->isValid()) {
        $data = $form->getData();

        $this->quoteManager->updateQuote($quote, $data);

        return $this->redirect()->toRoute('quotes',
                    ['action' => 'index']);
      }
    } else {

      $form->setData(array(
        'author' => $quote->getAuthor(),
        'quote'=>$quote->getQuote(),
        'user'=>$quote->getUser()
      ));

      return new ViewModel(array(
        'quote' => $quote,
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

      $quote = $this->entityManager->getRepository(Quote::class)
              ->find($id);

      if ($quote == null) {
          $this->getResponse()->setStatusCode(404);
          return;
      }

      // Delete quote.
      $this->quoteManager->deleteQuote($quote);

      // Add a flash message.
      $this->flashMessenger()->addSuccessMessage('Deleted the quote.');

      // Redirect to "index" page
      return $this->redirect()->toRoute('quotes', ['action'=>'index']);
  }


}
