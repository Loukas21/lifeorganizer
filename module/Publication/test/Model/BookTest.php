<?php
  namespace BookTest\Model;

  use Publication\Entity\Publication;
  use Publication\Form\PublicationForm;
  use PHPUnit\Framework\TestCase;

  class BookTest extends testCase
  {
    public function testInitialQuoteValuesAreNull()
    {
      $book = new Publication();

      $this->assertNull($book->getId(), '"id" should be null by default');
      $this->assertNull($book->getAuthor(), '"author" should be null by default');
      $this->assertNull($book->getTitle(), '"title" should be null by default');
      $this->assertNull($book->getIsWanted(), '"is_wanted" should be null by default');
    }


    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'update';
      $bookform = new PublicationForm($scenario);

      $inputFilter = $bookform->getInputFilter();

      //$this->assertSame(13, $inputFilter->count());
      $this->assertTrue($inputFilter->has('author'));
      $this->assertTrue($inputFilter->has('title'));
      $this->assertTrue($inputFilter->has('iswanted'));
      $this->assertTrue($inputFilter->has('type'));
      $this->assertTrue($inputFilter->has('description'));
      $this->assertTrue($inputFilter->has('totality'));
      $this->assertTrue($inputFilter->has('currentprogress'));
      $this->assertTrue($inputFilter->has('isfinished'));
      $this->assertTrue($inputFilter->has('user'));
      $this->assertTrue($inputFilter->has('id'));

    }

    /**
     * @dataProvider getInvalidBookData
     * @group inputFilters
     */
     /*
    public function testInputFiltersIncorrect($row)
    {
      $scenario = 'update';
      $book = new Publication();
      $bookform = new PublicationForm($scenario);

      $bookform->setInputFilter($bookform->getInputFilter());
      $bookform->setHydrator(new \Laminas\Hydrator\ObjectPropertyHydrator());
      $bookform->bind($book);
      $bookform->setData($row);

      $this->assertFalse($bookform->isValid());
      //$this->assertTrue(count($bookform->getMessages()) > 0);
    }
    */
    /**
     * @group inputFilters
     */
     /*
    public function testInputFiltersSuccess()
    {
      $scenario = 'update';
      $book = new Publication();
      $bookform = new PublicationForm($scenario);

      $bookform->setInputFilter($bookform->getInputFilter());
      $bookform->setHydrator(new \Laminas\Hydrator\ObjectPropertyHydrator());
      $bookform->bind($book);

      $bookform->setData($this->getBookData());

      $this->assertTrue($bookform->isValid());
      //$this->assertCount(0, $bookform->getMessages());
    }
    */
    /*
    public function getBookData()
    {
      return [
        [
          [
            'id' => 1,
            'user' => 3,
            'author' => "Test",
            'title' => "Test",
            'isWanted' => 0,
            'type' => 1,
            'description' => "test",
            'totality' => 10,
            'currentProgress' => 5,
            'isFinished' => 0,
            'currentProgressDate' => null,
            'lastProgressDate' => null,
            'finishDate' => null,
            'startDate' => null,
          ]
        ]
      ];
    }

    public function getInvalidBookData()
    {
      return [
        [
          [
            'id' => null,
            'user' => null,
            'author' => null,
            'title' => null,
            'iswanted' => null,
            'type' => null,
            'description' => null,
            'totality' => null,
            'currentprogress' => null,
            'isfinished' => null,
          ],
          [
            'id' => 1,
            'user' => null,
            'author' => null,
            'title' => null,
            'iswanted' => null,
            'type' => null,
            'description' => null,
            'totality' => null,
            'currentprogress' => null,
            'isfinished' => null,
          ],
          [
            'id' => 1,
            'user' => 3,
            'author' => "Test",
            'title' => "Test",
            'iswanted' => 0,
            'type' => 1,
            'description' => "test",
            'totality' => 10,
            'currentprogress' => 5,
            'isfinished' => 0,
          ]
        ]
      ];
    }
    */
  }
?>
