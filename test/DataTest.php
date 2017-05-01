<?php
use PHPUnit\Framework\TestCase;
class DataTest extends TestCase
{
 /**
 * @dataProvider additionProvider
 */
 public function testAdd($a, $b, $expected)
 {
 $this->assertEquals($expected, $a + $b);
 }

 /**
 *  must be public 
 *  must return either array or object that implement Iterator interface and yields an array
 */
 public function additionProvider()
 {
 return [
 [0, 0, 0],
 [0, 1, 1],
 [1, 0, 1],
 [1, 1, 3]
 ];
 }
}
?>
