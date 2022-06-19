<?php
namespace Language\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a registered language.
 * @ORM\Entity(repositoryClass="\Language\Repository\LanguageRepository")
 * @ORM\Table(name="language")
 */
class Language
{
  // Language name constants.
  const LANGUAGE_POLISH     = 1; // polish.
  const LANGUAGE_ENGLISH    = 2; // english.
  const LANGUAGE_GERMAN     = 3; // german.
  const LANGUAGE_RUSSIAN    = 4; // russian.

  const LEVEL_A1            = 1;
  const LEVEL_A2            = 2;
  const LEVEL_B1            = 3;
  const LEVEL_B2            = 4;
  const LEVEL_C1            = 5;
  const LEVEL_C2            = 6;


    /**
     * @ORM\id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="language")
     */
    protected $language;

    /**
     * @ORM\Column(name="years_of_study")
     */
    protected $yearsOfStudy;

    /**
     * @ORM\Column(name="has_certificate")
     */
    protected $hasCertificate;

    /**
     * @ORM\Column(name="certificate_description")
     */
    protected $certificateDescription;

    /**
     * @ORM\Column(name="certificate_date")
     */
    protected $certificateDate;

    /**
     * @ORM\Column(name="level")
     */
    protected $level;

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
     * Returns language ID.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets language ID.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns language.
     * @return integer
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Returns possible polish language names as array.
     * @return array
     */
    public static function getLanguageList()
    {
        return [
            self::LANGUAGE_POLISH => 'polski',
            self::LANGUAGE_ENGLISH => 'angielski',
            self::LANGUAGE_GERMAN => 'niemiecki',
            self::LANGUAGE_RUSSIAN => 'rosyjski',
        ];
    }

    /**
     * Returns language flags as array.
     * @return array
     */
    public static function getFlagStringListByLanguage()
    {
        return [
            self::LANGUAGE_POLISH => 'pl',
            self::LANGUAGE_ENGLISH => 'gb',
            self::LANGUAGE_GERMAN => 'de',
            self::LANGUAGE_RUSSIAN => 'ru',
        ];
    }

    /**
     * Returns language as string.
     * @return string
     */
    public function getLanguageAsString()
    {
        $list = self::getLanguageList();
        if (isset($list[$this->language]))
            return $list[$this->language];

        return 'nieznany';
    }

    /**
     * Returns language country flag as string.
     * @return string
     */
    public function getLanguageCountryFlagAsString()
    {
        $list = self::getFlagStringListByLanguage();
        if (isset($list[$this->language]))
            $flagString = $list[$this->language] . ".svg";
            return $flagString;

        return 'nieznany';
    }

    /**
     * Sets language.
     * @param int $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Returns years of study.
     * @return float
     */
    public function getYearsOfStudy()
    {
        return $this->yearsOfStudy;
    }

    /**
     * Setss years_of_study.
     * @param float $yearsOfStudy
     */
    public function setYearsOfStudy($yearsOfStudy)
    {
        $this->yearsOfStudy = $yearsOfStudy;
    }

    /**
     * Returns hasCertificate.
     * @return bool
     */
    public function getHasCertificate()
    {
        return $this->hasCertificate;
    }

    /**
     * Sets hasCertificate.
     * @param bool $hasCertificate
     */
    public function setHasCertificate($hasCertificate)
    {
        $this->hasCertificate = $hasCertificate;
    }

    /**
     * Returns certificateDescription.
     * @return string
     */
    public function getCertificateDescription()
    {
        return $this->certificateDescription;
    }

    /**
     * Sets certificateDescription.
     * @param string $certificateDescription
     */
    public function setCertificateDescription($certificateDescription)
    {
        $this->certificateDescription = $certificateDescription;
    }

    /**
     * Returns the date of certificate.
     * @return string
     */
    public function getCertificateDate()
    {
        return $this->certificateDate;

    }

    /**
     * Sets the date of certificate.
     * @param string $certificateDate
     */
    public function setCertificateDate($certificateDate)
    {
        $this->certificateDate = $certificateDate;
    }

    /**
     * Returns level.
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Returns language levels as array.
     * @return array
     */
    public static function getLevelList()
    {
        return [
            self::LEVEL_A1 => 'początkujący (A1)',
            self::LEVEL_A2 => 'podstawowy (A2)',
            self::LEVEL_B1 => 'średnio zaawansowany (B1)',
            self::LEVEL_B2 => 'wyższy średnio zaawansowany (B2)',
            self::LEVEL_C1 => 'zaawansowany (C1)',
            self::LEVEL_C2 => 'zaawansowany biegły (C2)',
        ];
    }

    /**
     * Returns language level as string.
     * @return string
     */
    public function getLanguageLevelAsString()
    {
        $list = self::getLevelList();
        if (isset($list[$this->level]))
            return $list[$this->level];
    }


    /**
     * Sets level.
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
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
