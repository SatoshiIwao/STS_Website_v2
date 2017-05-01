<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\YamlDataSet;
use Test\DatabaseDAO\Generic_Tests_DatabaseTestCase;

class YamlGuestbookTest extends Generic_Tests_DatabaseTestCase
{
 use TestCaseTrait;
 protected function getDataSet()
 {
 return new YamlDataSet(dirname(__FILE__)."/src/guestbook.yml");
 }

 public function testGetRowCount() {
 $this->assertEquals(2, $this->getConnection()->getRowCount('guestbook'));
 }
}
?>
