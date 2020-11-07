<?php

abstract class Payroll
{
  public $hours;
  const WORK_HOURS = 40;
  public function __construct($hours, $rate = 50)
  {
    $this->hours = $hours;
    $this->rate =  $rate;
  }
  abstract public function CalculatePayroll(): float;
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
  $run = "";
  do {
    echo "\n\n\nPRESS ANY KEY TO RUN PROGRAM OR 'exit' TO STOP THE PROGRAM \n";
    $run = collectInput();
    if ($run == "exit") {
      break;
    }
    echo "\n\nWELCOME TO PAYROLL APPLICATION\n";
    echo "******************************\n\n";
    echo "Please select employee status.\n\n";
    echo "1. FULL TIME EMPLOYEES\n";
    echo "2. PART TIME EMPLOYEES\n";
    echo "NB: if you wish to use default rate leave empty and press enter\n";
    echo "TYPE CMD+C exit program \n\n";
    do {
      $employeeStatus = collectInput();
      if ($employeeStatus <> "1" && $employeeStatus <> "2") {
        echo "Please select correct employee status.\n";
      }
    } while ($employeeStatus <>  "1" && $employeeStatus <> "2");

    echo "Please enter hours worked. ";
    $hours = collectInput();
    echo "\n";
    echo "Please enter rate in RM ";
    $rate = collectInput();
    echo "\n";
    if ($employeeStatus == "1" && $rate != "") {
      $staffPayroll = new FullTime(floatval($hours), floatval($rate));
      echo "The employee is to be paid " . number_format($staffPayroll->CalculatePayroll(), 2) . " RM";
    } elseif ($employeeStatus == "1" && $rate == "") {
      $staffPayroll = new FullTime(floatval($hours));
      echo "The employee is to be paid " . number_format($staffPayroll->CalculatePayroll(), 2) . " RM";
    } elseif ($employeeStatus == "2" && $rate != "") {
      $staffPayroll = new PartTime(floatval($hours), floatval($rate));
      echo "The employee is to be paid " . number_format($staffPayroll->CalculatePayroll(), 2) . " RM";
    } elseif ($employeeStatus == "2" && $rate == "") {
      $staffPayroll = new PartTime(floatval($hours));
      echo "The employee is to be paid " . number_format($staffPayroll->CalculatePayroll(), 2) . " RM";
    } else {
      echo "The hours : $hours entered and Rate : $rate. Please make sure they are valid";
      exit;
    }
  } while ($run != "exit");
  echo "\nGOODBYE ! PROGRAM EXITED";
}

runStaffPayRoll();
