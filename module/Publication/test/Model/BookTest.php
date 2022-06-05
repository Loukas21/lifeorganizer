<?php
  namespace BookTest\Model;

  use Publication\Entity\Publication;
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
    /*
    public function testExchangeArraySetsPropertiesCorrectly()
    {
      $quote = new Quote();
      $data = [
        'artist' => 'some artist',
        'id' => 123,
        'title' => 'some title'
      ];

      $album->exchangeArray($data);

      $this->assertSame(
        $data['id'],
        $quote->getId(),
        '"id" was not set correctly'
      );

      $this->assertSame(
        $data['author'],
        $quote->getAuthor(),
        '"artist" was not set correctly'
      );

      $this->assertSame(
        $data['quote'],
        $quote->getQuote(),
        '"title" was not set correctly'
      );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
      $album = new Album();

      $album->exchangeArray([
        'artist' => 'some artist',
        'id' => 123,
        'title' => 'some title'
      ]);
      $album->exchangeArray([]);

      $this->assertNull($album->artist, '"artist" should default to null');
      $this->assertNull($album->id, '"id" should default to null');
      $this->assertNull($album->title, '"title" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
      $album = new Album();
      $data = [
        'artist' => 'some artist',
        'id' => 123,
        'title' => 'some title'
      ];

      $album->exchangeArray($data);
      $copyArray = $album->getArrayCopy();

      $this->assertSame($data['artist'], $copyArray['artist'], '"artist" was not set correctly');
      $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
      $this->assertSame($data['title'], $copyArray['title'], '"title" was not set correctly');
    }

    public function testInputFilterAreSetCorrectly()
    {
      $album = new Album();

      $inputFilter = $album->getInputFilter();

      $this->assertSame(3, $inputFilter->count());
      $this->assertTrue($inputFilter->has('artist'));
      $this->assertTrue($inputFilter->has('id'));
      $this->assertTrue($inputFilter->has('title'));
    }
    */
  }
?>
