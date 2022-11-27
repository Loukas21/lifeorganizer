<?php
  namespace HobbyTest\Model;

  use Hobby\Entity\Hobby;
  use Hobby\Form\HobbyForm;
  use PHPUnit\Framework\TestCase;

  class HobbyTest extends testCase
  {
    public function testInitialAuthorityValuesAreNull()
    {
      $authority = new Hobby();

      $this->assertNull($hobby->getId(), '"id" should be null by default');
      $this->assertNull($hobby->getName(), '"authority name" should be null by default');
      $this->assertNull($hobby->getPosition(), '"position" should be null by default');
      $this->assertNull($hobby->getIsHiddenInVcv(), '"isHiddenInVcv" should be null by default');
      $this->assertNull($hobby->getUser(), '"user" should be null by default');
    }

    public function testInputFiltersAreSetCorrectly()
    {
      $scenario = 'update';
      $hobbyform = new HobbyForm($scenario);

      $inputFilter = $hobbyform->getInputFilter();

      //$this->assertSame(5, $inputFilter->count());
      $this->assertTrue($inputFilter->has('name'));
      //$this->assertTrue($inputFilter->has('user'));

    }

    public function testClassHasAttribute()
    {
      //Test attributes of class Authority
      $this->assertClassHasAttribute('id', Hobby::class);
      $this->assertClassHasAttribute('name', Hobby::class);
      $this->assertClassHasAttribute('position', Hobby::class);
      $this->assertClassHasAttribute('isHiddenInVcv', Hobby::class);
      $this->assertClassHasAttribute('user', Hobby::class);
    }

  }
?>
