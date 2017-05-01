<?php
use PHPUnit\Framework\TestCase;
class MultipleDependenciesTest extends TestCase
{
 public function testProducerFirst()
 {
 $this->assertTrue(true);
 return 'first';
 }
 public function testProducerSecond()
 {
 $this->assertTrue(true);
 return 'second';
 }
 // arg's order is from top to bottom
 /**
 * @depends testProducerSecond   
 * @depends testProducerFirst   
 */
 public function testConsumer()
 {
 $this->assertEquals(
 ['first', 'second'],
 func_get_args() // get an array of the function's argument list;
 );
 }
}
?>

