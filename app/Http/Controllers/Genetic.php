<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GeneticTools;
use Barryvdh\Debugbar\Facades\Debugbar;

class Genetic extends GeneticTools
{
    private $year;
    private $month;
    private $last_day_in_month;
    private $arr;
    private $work_day_in_month;
    private $population_size;
    private $generation;
    private $mutation_rate;

    private $day = 2;
    private $night = 1;
    private $free_day = 0;
    private $petition = -1;
    private $holiday = -2;
    private $sickLeave = -3;


    public function __construct(int $year,int $month,
    int $last_day_in_month,$population_size,$mutation_rate,$generation) {
        $this->year = $year;
        $this->month = $month;
        $this->last_day_in_month = $last_day_in_month;
        $this->arr = $this->updateCanWorkOnThisDay($month,$last_day_in_month);
        $this->work_day_in_month = $this->workDay($year,$month,$last_day_in_month);
        $this->population_size = $population_size;
        $this->mutation_rate = $mutation_rate;
        $this->generation = $generation;
    }

    public function initialChromosome($schedule_table_line){
        $holiday_count = 0;
        $sickLeave_count = 0;

        $count = array_count_values($schedule_table_line);
        if (isset($count[$this->holiday])) $holiday_count = $count[$this->holiday];
        if (isset($count[$this->sickLeave])) $sickLeave_count = $count[$this->sickLeave];
        $work_time = $this->workTime($this->work_day_in_month,$holiday_count,$sickLeave_count);
        $work_day = $work_time / 12;

        //day
        for($i=0;$i<ceil($work_day/2);$i++){
            $randomNumber = rand(1, $this->last_day_in_month);
            for ($j = 0; $j < 10; $j++){
                if ($this->rule($this->day,$randomNumber,$schedule_table_line)){
                    $schedule_table_line[$randomNumber] = $this->day;
                    break;
                }
                $randomNumber = rand(1, $this->last_day_in_month);
            }
        }

        //night
        for($i=0;$i<$work_day/2;$i++){
            $randomNumber = rand(1, $this->last_day_in_month);
            for ($j = 0; $j < 10; $j++){
                if ($this->rule($this->night,$randomNumber,$schedule_table_line)){
                    $schedule_table_line[$randomNumber] = $this->night;
                    break;
                }
                $randomNumber = rand(1, $this->last_day_in_month);
            }
        }

        return $schedule_table_line;
    }

    public function initialPopulation($arr){
        $schedule_table= [];
        for ($i = 0; $i < $this->population_size; $i++){
            $chromosome_array = [];
            foreach($arr as $key => $employee){
                $chromosome_array[$key] = $this->initialChromosome($employee);
            }

            $schedule_table[] = $chromosome_array;
        }
        return $schedule_table;
    }

    /**
     * napokra adok fitnesz értékeket
     * +1 pont ha max és minimum között van
     * -0.2 pont ha maximum fölött van
     * -1 pont ha minimum alatt van 1 nap ha több akkor
     *
    */
    public function fitness(array $individual, array $totoalWorkTimeTable,
                            int $min_day, int $max_day, int $min_night, int $max_night){
        $count = 0;
        $work_day = 0;
        for ($i=1; $i<=$this->last_day_in_month; $i++ ){
            $day_count = 0;
            $night_count = 0;
            foreach ($individual as $id){
                if ($this->day == $id[$i]) $day_count++;
                if ($this->night == $id[$i]) $night_count++;
            }

            //positive by day
            if ($min_day <= $day_count) $count += 1;
            if ($min_night <= $night_count) $count += 1;
            if ($max_day >= $day_count) $count += 0.7;
            if ($max_night >= $night_count) $count += 0.7;

            //negative by day
            if ($min_day > $day_count) $count -= 3;
            if ($min_night > $night_count) $count -= 3;
            if ($max_day < $day_count) $count -= 0.3;
            if ($max_night < $night_count) $count -= 0.3;

        }

        foreach($individual as $id => $days){
            $day_count_by_id = 0;
            $night_count_by_id = 0;
            $counter = array_count_values($days);
            if (isset($counter[$this->day])) $day_count_by_id = $counter[$this->day];
            if (isset($counter[$this->night])) $night_count_by_id = $counter[$this->night];
            $work_day = $totoalWorkTimeTable[$id] / 12;
            //equals
            if (ceil($work_day/2) == $day_count_by_id) $count += 0.3;
            if ((int)$work_day/2 == $night_count_by_id) $count += 0.3;
            //more
            if (ceil($work_day/2) < $day_count_by_id) $count += 0.2;
            if ((int)$work_day/2 < $night_count_by_id) $count += 0.2;
            //fewer
            if (ceil($work_day/2) > $day_count_by_id) $count -= 0.3;
            if ((int)$work_day/2 > $night_count_by_id) $count -= 0.3;
        }
        return $count;

        return 0;
    }

    public function rouletteSelection(array $population,array $fitness_scores){
        $sum_fitness = array_sum($fitness_scores);
        $probabilities = [];
        foreach($fitness_scores as $fitness){
            $probabilities[] = $fitness / $sum_fitness;
        }

        //roulette wheel
        $random = mt_rand() / mt_getrandmax();
        $value = 0;
        for($i =0; $i < count($fitness_scores); $i++){
            $value += $probabilities[$i];
            if ($random <= $value){
                return $population[$i];
            }
        }
        return null;
    }

    public function twoPointCrossover(array $parent1, array $parent2){
        $length = count($parent1);

        $point1 = mt_rand(0, $length - 1);
        $point2 = mt_rand(0, $length - 1);


        //if equals
        while ($point1 == $point2) {
            $point2 = mt_rand(0, $length - 1);
        }

        //sort
        if ($point1 > $point2) {
            $temp = $point1;
            $point1 = $point2;
            $point2 = $temp;
        }

        $child1 = array_slice($parent1, $point1, $point2 - $point1 + 1, true);
        $child2 = array_slice($parent2, $point1, $point2 - $point1 + 1, true);

        foreach ($parent2 as $key => $gene) {
            if (!array_key_exists($key, $child1)) {
                $child1[$key] = $gene;
            }
        }
        foreach ($parent1 as $key => $gene) {
            if (!array_key_exists($key, $child2)) {
                $child2[$key] = $gene;
            }
        }

        return array($child1, $child2);
    }

    public function mutation(array $individual){
        if (mt_rand() / mt_getrandmax() < $this->mutation_rate){
            $id = array_rand($individual);
            $shift = rand(1,2);
            $days = $this->checkMutation($individual[$id],$shift);
            $selected_day = collect($days)->random();
            $individual[$id][$selected_day] = $shift;
        }
        return $individual;
    }


    public function main(){

        // INITIAL
        $sorted_arr = $this->sortedUser($this->arr);
        $totoalWorkTimeTable = $this->totalWorkTimeTable($sorted_arr,$this->holiday,$this->sickLeave,$this->work_day_in_month);
        $population = $this->initialPopulation($sorted_arr);

        for ($w=0;$w<400;$w++){
        $new_population = [];
        $fitness_array = [];
        // FITNESS
        $min_index = [];
        $min = 1000;
        $max = 0;
        $max_index = [];
        foreach ($population as $key => $individual){
            $fitness_value = $this->fitness($individual,$totoalWorkTimeTable,3,4,2,3);
            $fitness_array[] = $fitness_value;
            if ($max < $fitness_value){
                $max = $fitness_value;
                $max_index = $population[$key];
            }
            if ($min > $fitness_value){
                $min = $fitness_value;
                $min_index = $population[$key];
            }
        }

        //nővekvő sorrendbe rendezés
        $aMAX = $max_index;
        $bMIN = $min_index;
        array_multisort($fitness_array,$population);

        //elitizmus
        $elit1 = $population[count($population)-1];
        $elit2 = $population[count($population)-2];
        $elit3 = $population[count($population)-3];
        $elit4 = $population[count($population)-4];

        //keresztezés és mutáció
        for ($i=0; $i<count($population)/2-2;$i++){
            $children = $this->twoPointCrossover($this->rouletteSelection($population,$fitness_array),
                                                $this->rouletteSelection($population,$fitness_array));
            $new_population[] = $this->mutation($children[0]);
            $new_population[] = $this->mutation($children[1]);
        }

        $new_population [] = $elit1;
        $new_population [] = $elit2;
        $new_population [] = $elit3;
        $new_population [] = $elit4;

        $population = $new_population;
        Debugbar::info($max);
        }

        return $elit1;
    }



}
