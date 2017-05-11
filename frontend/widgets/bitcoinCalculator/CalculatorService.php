<?php

namespace frontend\widgets\bitcoinCalculator;


use yii\base\ErrorException;
use Yii;

abstract class CalculatorService
{
    public $price = 0;
    public $hashRate = 0;
    public $powerWatt = 0;
    public $blockReward = 0;
    public $difficultyIncrease = 0;
    public $conversionIncrease = 0;
    public $poolFees = 0;
    public $hostingFees = 0;

    public function getStatToMonth($units = 1, $monthNumber = 1)
    {
        $data = [];
        for ($month = 1; $month <= $monthNumber; $month++) {
            $bitcoins = $this->blockReward /
                ((Calculator::getVolume() * pow(1 + $this->difficultyIncrease, $month)) * pow(2, 32) / (3600 *
                        pow(10, 9)
                        *
                        $this->hashRate *
                        $units)) *
                24 *
                30;
            $monthlyRevenue = $bitcoins * Yii::$app->calculator->getExchangeRate() * pow(
                    1 + $this->conversionIncrease, $month);
            $monthPower = $this->hostingFees*24*30/100;
            $monthlyCost = $monthlyRevenue * $this->poolFees + $monthPower * $this->powerWatt * $units / 1000;
            $profit = $monthlyRevenue - $monthlyCost;

            $data[] = [$month, $bitcoins, $monthlyRevenue, $monthlyCost, $profit];
        }

        return $data;
    }

    public function getBitcoinCost($units = 1, $monthNumber = 12)
    {
        $data = $this->getStatToMonth($units, $monthNumber);
        $hostingCosts = $data[0][3] / $data[0][1];
        $investment = $units * $this->price;
        $revenue = array_sum(
            array_map(
                function ($item) {
                    return $item[2];
                }, $data));
        $equipmentCosts = $investment / ($revenue / Yii::$app->calculator->getExchangeRate());
        return round($equipmentCosts + $hostingCosts, 2);
    }
}