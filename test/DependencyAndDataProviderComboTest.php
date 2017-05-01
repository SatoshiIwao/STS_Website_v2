<?php
use PHPUnit\Framework\TestCase;
class DependencyAndDataProviderComboTest extends TestCase
{
 public function provider()
 {
 return [
   ['provider1'], 
   ['provider2']
 ]; //iterator : repeat test for each data 
 }
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

 // arg's order : 
 // 1 : dataprovider 
 // 2 : depends order : from top to bottom

 // must suceed at least one depended-upon test data set when use depends and dataProvider
 
 /**
 * @depends testProducerFirst
 * @depends testProducerSecond
 * @dataProvider provider
 */
 public function testConsumer()
 {
 $this->assertEquals(
 ['provider1', 'first', 'second'],
 func_get_args()  
 );
 }
}
?>

