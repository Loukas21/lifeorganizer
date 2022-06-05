<?php
namespace Publication\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered publication.
 * @ORM\Entity(repositoryClass="\Publication\Repository\PublicationRepository")
 * @ORM\Table(name="publication")
 */
class Publication
{
    // Publication type constants.
    const TYPE_BOOK       = 1; // book.
    const TYPE_EBOOK      = 2; // ebook.
    const TYPE_AUDIOBOOK  = 3; // audiobook.
    const TYPE_ARTICLE    = 4; // article.
    const TYPE_HEARING    = 5; // hearing.
    const TYPE_LECTURE    = 6; // lecture.
    const TYPE_FILM       = 7; // film.
    const TYPE_PODCAST    = 8; // podcast.


    /**
     * @ORM\id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="user_id")
     */
    protected $user;

    /**
     * @ORM\Column(name="title")
     */
    protected $title;

    /**
     * @ORM\Column(name="author")
     */
    protected $author;

    /**
     * @ORM\Column(name="type")
     */
    protected $type;

    /**
     * @ORM\Column(name="description")
     */
    protected $description;

    /**
     * @ORM\Column(name="is_wanted")
     */
    protected $isWanted;

    /**
     * @ORM\Column(name="is_hidden_in_vcv")
     */
    protected $isHiddenInVcv;

    /**
     * @ORM\Column(name="is_finished")
     */
    protected $isFinished;

    /**
     * @ORM\Column(name="totality")
     */
    protected $totality;

    /**
     * @ORM\Column(name="start_date")
     */
    protected $startDate;

    /**
     * @ORM\Column(name="current_progress")
     */
    protected $currentProgress;

    /**
     * @ORM\Column(name="current_progress_date")
     */
    protected $currentProgressDate;

    /**
     * @ORM\Column(name="last_progress")
     */
    protected $lastProgress;

    /**
     * @ORM\Column(name="last_progress_date")
     */
    protected $lastProgressDate;

    /**
     * @ORM\Column(name="finish_date")
     */
    protected $finishDate;

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * Returns publication ID.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets publication ID.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * Returns title.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title.
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Returns type.
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns possible types as array.
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_BOOK => 'książka',
            self::TYPE_EBOOK => 'ebook',
            self::TYPE_AUDIOBOOK => 'audiobook',
            self::TYPE_ARTICLE => 'artykuł',
            self::TYPE_HEARING => 'audycja',
            self::TYPE_LECTURE => 'wykład',
            self::TYPE_FILM => 'film',
            self::TYPE_PODCAST => 'podcast'
        ];
    }

    /**
     * Returns possible progress unit by types as array.
     * @return array
     */
    public static function getProgressUnitListByType()
    {
        return [
            self::TYPE_BOOK => 'strony',
            self::TYPE_EBOOK => 'strony',
            self::TYPE_AUDIOBOOK => 'minuty',
            self::TYPE_ARTICLE => 'strony',
            self::TYPE_HEARING => 'minuty',
            self::TYPE_LECTURE => 'minuty',
            self::TYPE_FILM => 'minuty',
            self::TYPE_PODCAST => 'minuty'
        ];
    }

    /**
     * Returns possible progress unit by types as array.
     * @return array
     */
    public static function getIconStringListByType()
    {
        return [
            self::TYPE_BOOK => '<i class="fas fa-book" title="książka"></i>',
            self::TYPE_EBOOK => '<i class="fas fa-tablet-alt" title="ebook"></i>',
            self::TYPE_AUDIOBOOK => '<i class="fas fa-headphones" title="audiobook"></i>',
            self::TYPE_ARTICLE => '<i class="fa-solid fa-memo" title="artykuł"></i>',
            self::TYPE_HEARING => '<i class="fa-solid fa-radio" title="audycja"></i>',
            self::TYPE_LECTURE => '<i class="fas fa-chalkboard-teacher" title="wykład"></i>',
            self::TYPE_FILM => '<i class="fa-solid fa-film" title="film"></i>',
            self::TYPE_PODCAST => '<i class="fas fa-podcast" title="podcast"></i>'
        ];
    }

    /**
     * Returns publication type as string.
     * @return string
     */
    public function getTypeAsString()
    {
        $list = self::getTypeList();
        if (isset($list[$this->type]))
            return $list[$this->type];

        return 'Unknown';
    }

    /**
     * Returns publication type as string.
     * @return string
     */
    public function getProgressUnitAsString()
    {
        $list = self::getProgressUnitListByType();
        if (isset($list[$this->type]))
            return $list[$this->type];

        return 'brak';
    }

    /**
     * Returns publication type icon as string.
     * @return string
     */
    public function getIconAsString()
    {
        $list = self::getIconStringListByType();
        if (isset($list[$this->type]))
            return $list[$this->type];

        return '<i class="fas fa-cart-arrow-down" title="na liście życzeń"></i>';
    }

    /**
     * Sets type.
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns description.
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets description.
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns isWanted.
     * @return bool
     */
    public function getIsWanted()
    {
        return $this->isWanted;
    }

    /**
     * Sets isWanted.
     * @param bool $isWanted
     */
    public function setIsWanted($isWanted)
    {
        $this->isWanted = $isWanted;
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
     * Returns isFinished.
     * @return bool
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Sets isFinished.
     * @param bool $isFinished
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;
    }

    /**
     * Returns totality.
     * @return float
     */
    public function getTotality()
    {
        return $this->totality;
    }

    /**
     * Sets totality.
     * @param float $totality
     */
    public function setTotality($totality)
    {
        $this->totality = $totality;
    }

    /**
     * Returns the date of start reading publication.
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the date of start reading publication.
     * @param string $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Returns currentProgress.
     * @return float
     */
    public function getCurrentProgress()
    {
        return $this->currentProgress;
    }

    /**
     * Sets currentProgress.
     * @param float $currentProgress
     */
    public function setCurrentProgress($currentProgress)
    {
        $this->currentProgress = $currentProgress;
    }

    /**
     * Returns progress as string.
     * @return string
     */
    public function getProgressAsString()
    {
        if ($this->getIsWanted() == 1) {
          return '';
        }
        $totality = 0;
        $currentProgress = 0;
        if ($this->getTotality()) {
          $totality = $this->getTotality();
        }
        if ($this->getCurrentProgress()) {
          $currentProgress = $this->getCurrentProgress();
        }
        $progressUnit = $this->getProgressUnitAsString();
        $progressString = "<span title='$progressUnit'>" . $currentProgress."/".$totality."</span>";
        if ($this->getIsFinished() == 1) {
            $progressString .= ' <i class="fas fa-check-square" title="ukończono"></i>';
        }

        return $progressString;
    }

    /**
     * Returns currentProgressDate.
     * @return string
     */
    public function getCurrentProgressDate()
    {
        return $this->currentProgressDate;
    }

    /**
     * Sets currentProgressDate.
     * @param string $currentProgressDate
     */
    public function setCurrentProgressDate($currentProgressDate)
    {
        $this->currentProgressDate = $currentProgressDate;
    }

    /**
     * Returns lastProgress.
     * @return float
     */
    public function getLastProgress()
    {
        return $this->lastProgress;
    }

    /**
     * Sets lastProgress.
     * @param float $lastProgress
     */
    public function setLastProgress($lastProgress)
    {
        $this->lastProgress = $lastProgress;
    }

    /**
     * Returns lastProgressDate.
     * @return string
     */
    public function getLastProgressDate()
    {
        return $this->lastProgressDate;
    }

    /**
     * Sets lastProgressDate.
     * @param string $lastProgressDate
     */
    public function setLastProgressDate($lastProgressDate)
    {
        $this->lastProgressDate = $lastProgressDate;
    }

    /**
     * Returns finishDate.
     * @return string
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * Sets finishDate.
     * @param string $finishDate
     */
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;
    }
}
