<?php
namespace Quote\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper is used to check user permissions.
 */
class RandomQuote extends AbstractHelper
{
    private $quoteManager = null;

    public function __construct($quoteManager)
    {
        $this->quoteManager = $quoteManager;
    }

    public function __invoke($userid)
    {
        return $this->quoteManager->getRandomQuoteByUserId($userid);
    }
}
