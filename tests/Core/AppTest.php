<?php

use \Core\App;
class AppTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    $this->app = new App();

  }

  public function testItCanParseUrl()
  {
    $reflectedMethod = new ReflectionMethod('\Core\App', 'parseUrl');
    $reflectedMethod->setAccessible(true);
    $this->assertEquals(
      ['test', 'case', 'new'], 
      $reflectedMethod->invokeArgs(
        $this->app, 
        array('test/case/new/')
      )
    );
  }
}