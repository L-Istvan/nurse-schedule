<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\GeneticTools;

class RuleTest extends TestCase
{

    public function test_busyDay()
    {
        $testController = new GeneticTools();

        $data = [1, -1, -2, -1, -3, 1, 2, -2, 1, 2];
        $n = 10;
        for ($i = 0; $i < $n; $i++ ){
            $this->assertFalse($testController->rule(1, $i, $data));
        }
        for ($i = 0; $i < $n; $i++ ){
            $this->assertFalse($testController->rule(2, $i, $data));
        }
    }

    public function rule1DataProvider()
    {
        return [
            [1, 0, [0, 0, 1, 1, 1], true],
            [2, 0, [0, 0, 1, 1, 1], true],
            [1, 1, [0, 0, 0, 1, 1], true],
            [2, 1, [0, 0, 0, 1, 1], true],
            [1, 4, [-1, 1, -2, 0, 0], true],
            [2, 4, [-1, 1, -2, 0, 0], true],
            [1, 0, [0, -1, -3, 1, 1], true],
            [2, 0, [0, -1, -3, 1, 1], true],
            [1, 0, [0, -2, -3, 1, 1], true],
            [2, 0, [0, -2, -3, 1, 1], true],
            [1, 0, [0, -3, -3, 1, 1], true],
            [2, 0, [0, -3, -3, 1, 1], true],
            [1, 1, [-1, 0, -2, 1, 1], true],
            [2, 1, [-1, 0, -2, 1, 1], true],
            [1, 1, [-2, 0, -3, 1, 1], true],
            [2, 1, [-2, 0, -3, 1, 1], true],
        ];
    }

    /**
     * @dataProvider rule1DataProvider
     */
    public function test_oneShift($param1, $param2, $data){

        $testController = new GeneticTools();
        $this->assertTrue($testController->rule($param1, $param2, $data));
    }



    public function criticDataProvider()
    {
        return [
            [1, 0, [0, 0, 1, 1, 1], true],
            [2, 0, [0, 0, 1, 1, 1], true],
            [1, 1, [0, 0, 0, 1, 1], true],
            [2, 1, [0, 0, 0, 1, 1], true],
            [1, 4, [-1, 1, -2, 0, 0], true],
            [2, 4, [-1, 1, -2, 0, 0], true],
            [1, 0, [0, -1, -3, 1, 1], true],
            [2, 0, [0, -1, -3, 1, 1], true],
            [1, 0, [0, -2, -3, 1, 1], true],
            [2, 0, [0, -2, -3, 1, 1], true],
            [1, 0, [0, -3, -3, 1, 1], true],
            [2, 0, [0, -3, -3, 1, 1], true],
            [1, 1, [-1, 0, -2, 1, 1], true],
            [2, 1, [-1, 0, -2, 1, 1], true],
            [1, 1, [-2, 0, -3, 1, 1], true],
            [2, 1, [-2, 0, -3, 1, 1], true],
        ];
    }

    public function test_critic($input1, $input2, $data){
        $testController = new GeneticTools();
        $this->assertTrue($testController->rule($input1, $input2, $data));
    }


}
