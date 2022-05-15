<?php
namespace Quote\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * This controller plugin is used for role-based access control (RBAC).
 */
class RandomQuotePlugin extends AbstractPlugin
{
    private $quoteManager;

    public function __construct($quoteManager)
    {
        $this->quoteManager = $quoteManager;
    }

    public function __invoke($userid)
    {
        return $this->quoteManager->getRandomQuoteByUserId($userid);
    }
}
