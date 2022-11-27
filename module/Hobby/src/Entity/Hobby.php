<?php
namespace Hobby\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered authority.
 * @ORM\Entity(repositoryClass="\Hobby\Repository\HobbyRepository")
 * @ORM\Table(name="hobby")
 */
class Hobby
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
