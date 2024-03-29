<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use App\Models\Holiday;
use App\Models\Setting;
use App\Models\Petition;
use App\Models\SickLeave;
use App\Models\User;
use PhpParser\Node\Expr\AssignOp\ShiftLeft;

class GeneticTools
{
    /**
     * Counts the working days in the specified month.
     *
     * @param [int] $year
     * @param [int] $month The month number (1-12)
     * @param [int] $last_day_in_month
     * @return int The number of working days.
     */
    public function workDay(int $year,int $month, int $last_day_in_month){
        CarbonPeriod::macro('countWeekdays', function () {
            $filteredDays = $this->filter(function ($date) {
                return $date->isWeekday();
            });
            return $filteredDays->count();
        });
        $start = $year."-".$month."-1";
        $end = (string)$year."-".$month."-".$last_day_in_month;
        return CarbonPeriod::create($start, $end)->countWeekdays();
    }


    /**
     * Calculates total work day in a month
     * taking into account holiday and sick leave.
     *
     * @param [int] $work_day_in_month The number of work day in a month.
     * @param [int] $holiday The number of holiday in a month
     * @param [int] $sick_leave The number of sick leave in a month
     * @return int The calculated sum
     */
    public function workTime(int $work_day_in_month, int $holiday, int $sick_leave){
        $work_time = $work_day_in_month * 8; //total work time in month
        return $work_time-($holiday*8)-($sick_leave*8);
    }


    /**
     *  Sorts the given array of users based on the number of values less than 0.
     *
     * @param [array] $arr The array is multi dimension array and specific.
     * @return array Sorted in descending order
     */
    public function sortedUser($arr){
        $collection = collect($arr)->sortByDesc(function ($item) {
            $count = collect($item)->flatten()->filter(function ($value) {
                return $value < 0;
            })->count();
                return $count;
        });
        return $collection->all();
        }


    /**
     * Days can be 0, -1, -2 , -3
     *   0 : Emploeyee can work
     *  -1 : Employee's petition
     *  -2 : Employee's holiday
     *  -3 : Employee's sick leave day
     * arr[ID][1] -> First day of the ID, starting from 1, indicating the first day.
     * @param [type] $month The month's number
     * @param [type] $monthDayNumber The days of the month
     * @return array The status of workdays for individual users in an array.
     */
    public function updateCanWorkOnThisDay($month,$monthDayNumber){
        $canWorkOnThisDay = [];
        $users = User::getPersonId(Auth::user()->id);
        foreach ($users as $user){

            // can work --> 0
            for ($i=1; $i<=$monthDayNumber; $i++){
                $canWorkOnThisDay[$user][$i] = 0;
            }

            //Petiton's value = -1
            $petitions = Petition::getPetitionbyHolidayAndUserId($user,$month);
            foreach ($petitions as $petition){
                $arr = explode("-",$petition);
                $canWorkOnThisDay[$user][intval($arr[2])] = -1;
            }

            //holiday's value = -2
            $holidays = Holiday::getHolidaybyMonthAndUserId($user,$month);
            foreach($holidays as $holiday){
                $arr = explode("-",$holiday);
                $canWorkOnThisDay[$user][intval($arr[2])] = -2;
            }

            //SickLeave's value = -3
            $sickLeaves = SickLeave::getSickLeavebyMonthAndUserId($user,$month);
            foreach($sickLeaves as $sickLeave){
                $arr = explode("-",$sickLeave);
                $canWorkOnThisDay[$user][intval($arr[2])] = -3;
            }
        }
        return $canWorkOnThisDay;
    }

    /**
     *
     * Checks int the given array whatever the employee can be assigned to on the given day($index)
     * taking into account rule or more exactly the shifts, sick leave, holidays and petitions  .
     *
     * @param integer $shift
     * @param integer $index The index start at 1.
     * @param array $data The data is a simple array consisting of integers.
     * @return true/false True if there is no schedule conflict.
     */
    public function rule(int $shift, int $index, array $data){
        $rule = ["020","010","0220","0110","0210","02210","02110"];
        $i = $index;
        $indexmin = 1;
        $indexmax = count($data);
        $value = true;
        $current = "";

        if ($data[$index] === 0){ //empty
            //left
            while($value == true && $i !== $indexmin){
                $i--;
                if ($data[$i] <= 0 ) $value = false;
                else $current .= (string)$data[$i];
            }

            //middle
            $value = true;
            $i = $index;
            $current .= "0";
            $current = strrev($current);
            $current .= $shift; //given shift

            //right
            while($value == true && $i !== $indexmax){
                $i++;
                if ($data[$i] <= 0 ) $value = false;
                else $current .= (string)$data[$i];
            }
            $current .= "0";

            //check
            return collect($rule)->contains($current);
        }
        return false;
    }

    /**
     * Counts all employee's holidays and sick leaves.
     *
     * @param array $individual
     * @param integer $holiday
     * @param integer $sick_leave
     * @param integer $work_day_in_month
     * @return array The array's appearance : $result[id] = work_time
     */
    public function totalWorkTimeTable(array $individual,int $holiday,
                                        int $sick_leave, int $work_day_in_month){
        $result = [];
        foreach ($individual as $id => $days){
            $holiday_count = 0;
            $sickLeave_count = 0;
            $count = array_count_values($days);
            if (isset($count[$holiday])) $holiday_count = $count[$holiday];
            if (isset($count[$sick_leave])) $sickLeave_count = $count[$sick_leave];
            $work_time = $this->workTime($work_day_in_month,$holiday_count,$sickLeave_count);
            $result[$id] = $work_time;
        }
        return $result;
    }

    public function rule2(int $shift, int $index, array $data){
        $rule = ["020","010","0220","0110","0210","02210","02110"];
        $i = $index;
        $indexmin = 1;
        $indexmax = count($data);
        $value = true;
        $current = "";

        if (0 < $data[$index]){ //empty
            //left
            while($value == true && $i !== $indexmin){
                $i--;
                if ($data[$i] <= 0 ) $value = false;
                else $current .= (string)$data[$i];
            }

            //middle
            $value = true;
            $i = $index;
            $current .= "0";
            $current = strrev($current);
            $current .= $shift; //given shift

            //right
            while($value == true && $i !== $indexmax){
                $i++;
                if ($data[$i] <= 0 ) $value = false;
                else $current .= (string)$data[$i];
            }
            $current .= "0";

            //check
            return collect($rule)->contains($current);
        }
        return false;
    }

    public function checkMutation(array $individual,$shift){
        $days = [];
        foreach($individual as $day => $value){
            if($this->rule2($shift,$day,$individual)){
                $days[] = $day;
            }
        }
        return $days;
    }
}
