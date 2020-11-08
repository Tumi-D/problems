<?php

abstract class Payroll
{
  public $hours;
  const WORK_HOURS = 40;
  public $rate;
  protected $lightBlue="\e[94m";
  protected $green ="\e[32m";
  protected $concat = "\e[0m";
  public function __construct($hours, $rate = 50)
  {
    $this->hours = $hours;
    $this->rate =  $rate;
  }
  abstract public function CalculatePayroll(): float;
  public function __destruct()
  {
    echo "$this->lightBlue The employee is to be paid {$this->concat}  {$this->green}" . number_format($this->CalculatePayroll(), 2) . "RM {$this->concat}";
  }
}





class FullTime extends Payroll
{
  private $overTimeRate = 40;
  private $salary = 0.00;
  public function CalculatePayroll(): float
  {
    switch ($this->hours) {
      case  $this->hours <= self::WORK_HOURS &&  $this->hours > 0:
        $this->salary =  $this->rate * $this->hours;
        return  $this->salary;
        break;
      case  $this->hours > self::WORK_HOURS:
        $normalWage =  $this->rate *  self::WORK_HOURS;
        $this->salary =  $normalWage + (($this->hours - self::WORK_HOURS) * $this->overTimeRate);
        return $this->salary;
        break;
      default:
        return $this->salary;
        break;
    }
  }
}

class PartTime extends Payroll
{
  private $overTimeRate = 30;
  private $salary = 0.00;
  public function CalculatePayroll(): float
  {
    switch ($this->hours) {
      case  $this->hours <= self::WORK_HOURS &&  $this->hours > 0:
        $this->salary =  $this->rate * $this->hours;
        return  $this->salary;
        break;
      case  $this->hours > self::WORK_HOURS:
        $normalWage =  $this->rate *  self::WORK_HOURS;
        $this->salary =  $normalWage + (($this->hours - self::WORK_HOURS) * $this->overTimeRate);
        return $this->salary;
        break;
      default:
        return $this->salary;
        break;
    }
  }
}

function collectInput()
{
  $handle = fopen("php://stdin", "r");
  $input = fgets($handle, 1024);
  return trim($input);
}

function runStaffPayRoll()
{
  $blue ="\e[34m";
  $concat ="\e[0m";
  $yellow ="\e[33m";
  $red ="\e[31m";
  $magenta ="\e[35m";
  $run = "";
  do {
    echo "\n\n$magenta PRESS ANY KEY TO RUN PROGRAM OR 'exit' TO STOP THE PROGRAM $concat \n";
    $run = collectInput();
    if ($run == "exit") {
      break;
    }
    echo "\n\n{$blue}WELCOME TO PAYROLL APPLICATION \n";
    echo str_repeat("*",30)."\n\n";
    echo "Please select employee status.\n\n";
    echo "1. FULL TIME EMPLOYEES\n";
    echo "2. PART TIME EMPLOYEES\n $concat";
    echo "$yellow NB: If you wish to use default rate leave empty and press enter\n";
    echo "      TYPE CMD+C exit program $concat \n\n";
    do {
      $employeeStatus = collectInput();
      if ($employeeStatus <> "1" && $employeeStatus <> "2") {
        echo "$red Please select correct employee status. $concat \n";
      }
    } while ($employeeStatus <>  "1" && $employeeStatus <> "2");

    echo "$blue Please enter hours worked: $concat";
    $hours = collectInput();
    echo "\n";
    echo "$blue Please enter rate in RM: $concat";
    $rate = collectInput();
    echo "\n";
    if ($employeeStatus == "1" && $rate != "") {
      new FullTime(floatval($hours), floatval($rate));
    } elseif ($employeeStatus == "1" && $rate == "") {
      new FullTime(floatval($hours));
    } elseif ($employeeStatus == "2" && $rate != "") {
      new PartTime(floatval($hours), floatval($rate));
    } elseif ($employeeStatus == "2" && $rate == "") {
      new PartTime(floatval($hours));
    } else {
      echo "The hours : $hours entered and Rate : $rate. Please make sure they are valid";
      exit;
    }
  } while ($run != "exit");
  echo "\n $yellow GOODBYE ! PROGRAM EXITED $concat";
}

runStaffPayRoll();
