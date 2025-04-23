<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyAyamChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    } 
   
    public function build($labels, $data)
    {
        return $this->chart->pieChart()
            ->setTitle('Sesi Barak Ini')
            ->setLabels($labels)
            ->addData($data)
            ->setWidth(250) 
            ->setHeight(300)
            ->setColors(['#4CAF50', '#2196F3']);
    }
}
