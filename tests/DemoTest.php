<?php

use Way\Tests\Should;
use Way\Tests\Assert;

class DemoTest extends PHPUnit_Framework_TestCase {
    public function testItWorks() {
        Should::beTrue(true);
        Assert::true(true);

        Should::equal(4, 2 + 2);
        Assert::equals(4, 2 + 2);

        Should::beGreaterThan(20, 21);
        Assert::greaterThan(20, 21);

        Should::contain('Joe', ['John', 'Joe']);
        Should::have('Joe', ['John', 'Joe']);
        Assert::has('Joe', ['John', 'Joe']);
        Assert::has('Joe', 'Joey');

        Should::haveCount(2, ['1', '2']);
        Assert::count(2, ['1', '2']);
    }
}
