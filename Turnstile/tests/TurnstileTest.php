<?php
require '../Turnstile.php';

/**
 * Tests for Turnstile class
 *
 * @author shcherbakov pavel
 */
class TurnstileTests extends PHPUnit_Framework_TestCase
{
    private $turnstile;

    protected function setUp()
    {
        $this->turnstile = new Turnstile();
    }

    protected function tearDown()
    {
        $this->turnstile = NULL;
    }

    public function testInsertCoin()
    {
        $this->assertTrue($this->turnstile->insertCoin(1));
    }

    public function testInsertNoCoin()
    {
        $this->assertFalse($this->turnstile->insertCoin('garbage'));
    }

    public function testPassTroughTurnstileWithCoin()
    {
        $this->turnstile->insertCoin(1);
        $this->assertTrue($this->turnstile->checkUnLocked());
    }

    public function testPassTroughTurnstileWithoutCoin()
    {
        $this->assertFalse($this->turnstile->checkUnLocked());
    }

    public function testAlarmWithCoin()
    {
        $this->turnstile->insertCoin(1);
        $this->assertFalse($this->turnstile->checkIsAlarm());
    }

    public function testAlarmWithNoCoin()
    {
        $this->turnstile->insertCoin('garbage');
        $this->assertTrue($this->turnstile->checkIsAlarm());
    }

    public function testEjectWithCoin()
    {
        $this->turnstile->insertCoin(1);
        $this->assertFalse($this->turnstile->ejectCoin());
    }

    public function testEjectWithNoCoin()
    {
        $this->turnstile->insertCoin('garbage');
        $this->assertFalse($this->turnstile->ejectCoin());
    }

}
