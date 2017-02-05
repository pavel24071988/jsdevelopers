<?php

/**
 * Turnstile class
 *
 * @author shcherbakov pavel
 */
class Turnstile {
    private $messages = [];

    private $coin = 0;
    private $isUnlocked = false;
    private $isAlarm = false;

    public function __construct(){
        $this->messages[] = 'turnstile is ready';
    }

    public function __destruct(){
        echo 'end of scenario';
    }

    public function checkCoinExist(){
        return $this->coin > 0 ? true : false;
    }

    public function checkUnLocked(){
        return $this->isUnlocked;
    }

    public function checkIsAlarm(){
        return $this->isAlarm;
    }

    public function validateCoin($coin){
        return is_int($coin) ? true : false;
    }

    public function unlockedTurnstile(){
        $this->messages[] = 'turnstile is unlocked';
        return $this->isUnlocked = true;
    }

    public function lockedTurnstile(){
        $this->messages[] = 'turnstile is locked';
        return $this->isUnlocked = false;
    }

    public function startAlarmTurnstile(){
        if($this->checkIsAlarm()){
            $this->messages[] = 'alarm started before...';
            return true;
        }
        $this->messages[] = 'alarm...';
        return $this->isAlarm = true;
    }

    public function endAlarmTurnstile(){
        if(!$this->checkIsAlarm()) return false;
        $this->messages[] = 'end of alarm';
        return $this->isAlarm = false;
    }

    public function addCoin($coin){
        return $this->coin = $this->coin + $coin;
    }

    public function removeCoin(){
        return $this->coin--;
    }

    public function ejectCoin(){
        $this->messages[] = 'you can`t eject a coin';
        $this->startAlarmTurnstile();
        $this->lockedTurnstile();
        return false;
    }

    public function insertCoin($coin){
        $this->messages[] = 'insert a coin: '. $coin;
        if(!$this->validateCoin($coin)){
            $this->messages[] = 'is not a coin';
            $this->startAlarmTurnstile();
            $this->lockedTurnstile();
            return false;
        }
        $coins = $this->addCoin($coin);
        if(!$this->checkCoinExist()){
            $this->messages[] = 'no coins';
            return false;
        }
        $this->messages[] = 'turnstile has '. $coins .' coin(s)';
        $this->endAlarmTurnstile();
        $this->unlockedTurnstile();
        return true;
    }

    public function passTroughTurnstile(){
        $this->messages[] = 'pass trough the turnstile';
        if(!$this->isUnlocked){
            $this->startAlarmTurnstile();
            return false;
        };
        $this->removeCoin();
        $this->messages[] = 'success';
        $this->lockedTurnstile();
        return true;
    }

    public function showHistory(){
        foreach($this->messages as $message){
            echo $message ."<br/>"."\n";
        }
    }
}

// User Story: Unlocking the turnstile
$turnstile = new Turnstile();
$turnstile->lockedTurnstile();
$turnstile->insertCoin(1);
$turnstile->showHistory();
$turnstile = null;

echo "<br/>"."\n";
echo "<br/>"."\n";

// User Story: Locking the turnstile
$turnstile = new Turnstile();
$turnstile->unlockedTurnstile();
$turnstile->passTroughTurnstile();
$turnstile->showHistory();
$turnstile = null;

echo "<br/>"."\n";
echo "<br/>"."\n";

// User Story: Raising an alarm
$turnstile = new Turnstile();
$turnstile->lockedTurnstile();
$turnstile->passTroughTurnstile();
$turnstile->insertCoin(1);
$turnstile->showHistory();
$turnstile = null;

echo "<br/>"."\n";
echo "<br/>"."\n";

// User Story: Gracefuly eating money
$turnstile = new Turnstile();
$turnstile->lockedTurnstile();
$turnstile->insertCoin(1);
$turnstile->insertCoin(1);
$turnstile->passTroughTurnstile();
$turnstile->showHistory();
$turnstile = null;