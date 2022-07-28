<?php
namespace BloodDonation\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use BloodDonation\Entity\Event;

/**
 * This class represents a registered event blood donation.
 * @ORM\Entity(repositoryClass="\BloodDonation\Repository\BloodDonationRepository")
 * @ORM\Table(name="event_blood_donation")
 */
class BloodDonation extends Event
{

  //blood donation ban causes
  const BAN_CAUSE_MEDICAL_TESTS = 1;
  const BAN_CAUSE_SCHEDULE = 2;
  const BAN_CAUSE_SELF_RESIGNATION = 3;
  const BAN_CAUSE_OTHER_CAUSE = 4;

    /**
     * @ORM\id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="donation_place")
     */
    protected $place;

    /**
     * @ORM\Column(name="is_planned")
     */
    protected $isPlanned;

    /**
     * @ORM\Column(name="is_donation_banned")
     */
    protected $isDonationBanned;

    /**
     * @ORM\Column(name="ban_cause_type")
     */
    protected $banCauseType;

    /**
     * @ORM\Column(name="ban_cause_description")
     */
    protected $banCauseDescription;

    /**
     * @ORM\Column(name="ban_date_to")
     */
    protected $banDateTo;

    /**
     * @ORM\Column(name="donated_blood_amount")
     */
    protected $donatedBloodAmount;


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
     * Returns donation place.
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Sets donation place.
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * Returns donation is planned variable.
     * @return boolean
     */
    public function getIsPlanned()
    {
        return $this->isPlanned;
    }

    /**
     * Sets donation is planned variable.
     * @param bool $isPlanned
     */
    public function setIsPlanned($isPlanned)
    {
        $this->isPlanned = $isPlanned;
    }

    /**
     * Returns donation is banned variable.
     * @return boolean
     */
    public function getIsDonationBanned()
    {
        return $this->isDonationBanned;
    }

    /**
     * Sets donation is banned variable.
     * @param bool $isDonationBanned
     */
    public function setIsDonationBanned($isDonationBanned)
    {
        $this->isDonationBanned = $isDonationBanned;
    }

    /**
     * Returns ban cause type.
     * @return integer
     */
    public function getBanCauseType()
    {
        return $this->banCauseType;
    }

    /**
     * Returns possible donation ban cause types as array.
     * @return array
     */
    public static function getBanCauseTypeList()
    {
        return [
            self::BAN_CAUSE_MEDICAL_TESTS => 'wyniki badań',
            self::BAN_CAUSE_SCHEDULE => 'termin oddania',
            self::BAN_CAUSE_SELF_RESIGNATION => 'rezygnacja własna',
            self::BAN_CAUSE_OTHER_CAUSE => 'inny powód',
        ];
    }

    /**
     * Returns donation ban cause type as string.
     * @return string
     */
    public function getBanCauseTypeAsString()
    {
        $list = self::getBanCauseTypeList();
        if (isset($list[$this->banCauseType]))
            return $list[$this->banCauseType];

        return 'nieznany typ powodu';
    }

    /**
     * Sets ban cause type.
     * @param int $banCauseType
     */
    public function setBanCauseType($banCauseType)
    {
        $this->banCauseType = $banCauseType;
    }

    /**
     * Returns ban cause description.
     * @return string
     */
    public function getBanCauseDescription()
    {
        return $this->banCauseDescription;
    }

    /**
     * Sets ban cause description.
     * @param string $banCauseDescription
     */
    public function setBanCauseDescription($banCauseDescription)
    {
        $this->banCauseDescription = $banCauseDescription;
    }

    /**
     * Returns donation ban date to.
     * @return string
     */
    public function getBanDateTo()
    {
        return $this->banDateTo;
    }

    /**
     * Sets donation ban date to.
     * @param string $banDateTo
     */
    public function setBanDateTo($banDateTo)
    {
        $this->banDateTo = $banDateTo;
    }

    /**
     * Returns donated blood amount.
     * @return integer
     */
    public function getDonatedBloodAmount()
    {
        return $this->donatedBloodAmount;
    }

    /**
     * Sets donated blood amount.
     * @param int $donatedBloodAmount
     */
    public function setDonatedBloodAmount($donatedBloodAmount)
    {
        $this->donatedBloodAmount = $donatedBloodAmount;
    }

    public function getDonationInfoIcons()
    {
      $iconString = "";

      if ($this->isPlanned != 1 && $this->isDonationBanned != 1 && $this->donatedBloodAmount > 0) {
          $iconString .= "<i class='fas fa-check-square' title='skuteczna donacja'></i>";
      }
      if ($this->isPlanned == 1) {
          $iconString .= "<i class='fas fa-calendar-day' title='planowana donacja'></i>";
      }
      if ($this->isDonationBanned == 1) {
          $iconString .= "<i class='fas fa-ban' title='rezygnacja z oddania'></i>";
          $iconString .= '<i class="fas fa-info-circle" title="Kategoria powodu rezygnacji: ' . $this->getBanCauseTypeAsString() . '"></i>';
      }

      return $iconString;
    }



}
