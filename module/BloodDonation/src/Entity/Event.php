<?php
namespace BloodDonation\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered event.
 * @ORM\Entity(repositoryClass="\BloodDonation\Repository\Event")
 * @ORM\Table(name="event")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="event_type", type="string")
 * @ORM\DiscriminatorMap({"event" = "Event", "blood_donation" = "BloodDonation"})
 */

class Event
{

  /**
   * @ORM\id
   * @ORM\Column(name="id")
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(name="creation_date")
   */
  protected $creationDate;

  /**
   * @ORM\Column(name="event_date")
   */
  protected $eventDate;

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
   * Returns blood donation ID.
   * @return integer
   */
  public function getId()
  {
      return $this->id;
  }

  /**
   * Sets blood donation ID.
   * @param int $id
   */
  public function setId($id)
  {
      $this->id = $id;
  }

  /**
   * Returns creation date.
   * @return string
   */
  public function getCreationDate()
  {
      return $this->creationDate;
  }

  /**
   * Sets creation date.
   * @param string $creationDate
   */
  public function setCreationDate($creationDate)
  {
      $this->creationDate = $creationDate;
  }

  /**
   * Returns event date.
   * @return string
   */
  public function getEventDate()
  {
      return $this->eventDate;
  }

  /**
   * Sets event date.
   * @param string $creationDate
   */
  public function setEventDate($eventDate)
  {
      $this->eventDate = $eventDate;
  }


  /**
   * Returns user.
   * @return integer
   */
  public function getUser()
  {
      return $this->user;
  }

  /**
   * Sets user.
   * @param int $user
   */
  public function setUser($user)
  {
      $this->user = $user;
  }

}
