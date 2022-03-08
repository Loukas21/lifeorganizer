<?php
namespace Quote\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered quote.
 * @ORM\Entity(repositoryClass="\Quote\Repository\QuoteRepository")
 * @ORM\Table(name="quote")
 */
class Quote
{
    /**
     * @ORM\id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="author")
     */
    protected $author;

    /**
     * @ORM\Column(name="quote")
     */
    protected $quote;


    /**
     * @ORM\Column(name="user_id")
     */
    protected $user;
    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * Returns user ID.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets user ID.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns author.
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets author.
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Returns quote.
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Sets quote.
     * @param string $quote
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Returns user.
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets user.
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
