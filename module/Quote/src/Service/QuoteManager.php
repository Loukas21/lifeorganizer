<?php
namespace Quote\Service;

use Quote\Entity\Quote;

class QuoteManager
{

  /**
   * Doctrine entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * PHP template renderer.
   * @var Zend\View\Renderer\PhpRenderer
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

  public function addQuote($data)
  {

    // Create new Quote entity.
    $quote = new Quote();
    $quote->setAuthor($data['author']);
    $quote->setQuote($data['quote']);
    $quote->setUser($data['user']);

    // Add the entity to the entity manager.
    $this->entityManager->persist($quote);

    // Apply changes to database.
    $this->entityManager->flush();

    return $quote;
  }

  public function updateQuote($quote, $data)
  {

    $quote->setAuthor($data['author']);
    $quote->setQuote($data['quote']);
    //$quote->setUser($data['user']);

    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  public function deleteQuote($quote)
  {
      $this->entityManager->remove($quote);
      $this->entityManager->flush();

  }
}
