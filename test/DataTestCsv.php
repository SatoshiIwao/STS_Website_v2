<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/class/CsvFileIterator.php';
class DataTest extends TestCase
{
 /**
 * @dataProvider additionProvider
 */
 public function testAdd($a, $b, $expected)
 {
 $this->assertEquals($expected, $a + $b);
 }
 public function additionProvider()
 {
 return new CsvFileIterator( __DIR__ . '/src/data.csv' );
 }
}
?>

