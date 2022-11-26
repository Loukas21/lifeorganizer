<?php
namespace Authority\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered authority.
 * @ORM\Entity(repositoryClass="\Authority\Repository\AuthorityRepository")
 * @ORM\Table(name="authority")
 */
class Authority
{
    /**
     * @ORM\id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="position")
     */
    protected $position;

    /**
     * @ORM\Column(name="domain")
     */
    protected $domain;

    /**
     * @ORM\Column(name="explanation")
     */
    protected $explanation;

    /**
     * @ORM\Column(name="is_hidden_in_vcv")
     */
    protected $isHiddenInVcv;

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
     * Returns authority ID.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets authority ID.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name.
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns position.
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Setss position.
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Returns domain.
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets domain.
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Returns explanation.
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * Sets explanation.
     * @param string $explanation
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
    }

    /**
     * Returns isHiddenInVcv.
     * @return bool
     */
    public function getIsHiddenInVcv()
    {
        return $this->isHiddenInVcv;
    }

    /**
     * Sets isHiddenInVcv.
     * @param bool $isHiddenInVcv
     */
    public function setIsHiddenInVcv($isHiddenInVcv)
    {
        $this->isHiddenInVcv = $isHiddenInVcv;
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
