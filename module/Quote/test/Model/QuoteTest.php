<?php
  namespace QuoteTest\Model;

  use Quote\Entity\Quote;
  use Quote\Form\QuoteForm;
  use PHPUnit\Framework\TestCase;

  class QuoteTest extends testCase
  {
    public function testInitialQuoteValuesAreNull()
    {
      $quote = new Quote();

      $this->assertNull($quote->getId(), '"id" should be null by default');
      $this->assertNull($quote->getAuthor(), '"author" should be null by default');
      $this->assertNull($quote->getQuote(), '"quote" should be null by default');
    }

    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'update';
      $quoteform = new QuoteForm($scenario);

      $inputFilter = $quoteform->getInputFilter();

      //$this->assertSame(5, $inputFilter->count());
      $this->assertTrue($inputFilter->has('author'));
      $this->assertTrue($inputFilter->has('quote'));
      $this->assertTrue($inputFilter->has('user'));

    }

    /**
     * @dataProvider getInvalidQuoteData
     * @group inputFilters
     */
     /*
    public function testInputFiltersIncorrect($row)
    {
      $scenario = 'update';
      $quote = new Quote();
      $quoteform = new QuoteForm($scenario);

      $quoteform->setInputFilter($quoteform->getInputFilter());
      $quoteform->setHydrator(new \Laminas\Hydrator\ObjectPropertyHydrator());
      $quoteform->bind($quote);
      $quoteform->setData($row);

      $this->assertFalse($quoteform->isValid());
      $this->assertTrue(count($quoteform->getMessages()) > 0);
    }
    */

    /**
     * @group inputFilters
     */

     /*
    public function testInputFiltersSuccess()
    {
      $scenario = 'update';
      $quote = new Quote();

      $data = [
        'user'    => 3,
        'author'   => 'test',
        'quote' => 'test',
      ];

      $quoteform = new QuoteForm($scenario);

      $quoteform->setInputFilter($quoteform->getInputFilter());
      $quoteform->setHydrator(new \Laminas\Hydrator\ObjectPropertyHydrator());
      $quoteform->bind($quote);

      $quoteform->setData($data);

      //$quoteform->setData($this->getQuoteData());
      //$quoteform->setData($row);

      $this->assertTrue($quoteform->isValid());
      $this->assertCount(0, $quoteform->getMessages());
    }

    public function getInvalidQuoteData()
    {
      return [
        [
          [
            'user' => null,
            'author' => null,
            'quote' => null,
          ],
          [
            'user' => 0,
            'author' => 123,
            'quote' => null,
          ]
        ]
      ];
    }

    public function getQuoteData()
    {
      return [
        [
          [
              'user' => 3,
              'author' => 'test',
              'quote' => 'testewdssdwqasrfwerwqed'
          ],
        ]

      ];
    }
    */
  }
?>
