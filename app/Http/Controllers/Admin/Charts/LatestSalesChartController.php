<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Sale;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class LatestSalesChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LatestSalesChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(['6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/latest-sales'));

        // OPTIONAL
        // $this->chart->minimalist(false);
        // $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $today_sales = Sale::whereDate('created_at', today())->count();
        $yesterday_sales = Sale::whereDate('created_at', today()->subDays(1))->count();
        $sales_2_days_ago = Sale::whereDate('created_at', today()->subDays(2))->count();
        $sales_3_days_ago = Sale::whereDate('created_at', today()->subDays(3))->count();
        $sales_4_days_ago = Sale::whereDate('created_at', today()->subDays(4))->count();
        $sales_5_days_ago = Sale::whereDate('created_at', today()->subDays(5))->count();
        $sales_6_days_ago = Sale::whereDate('created_at', today()->subDays(6))->count();

        $this->chart->dataset('Users Created', 'bar', [
                    $sales_6_days_ago,
                    $sales_5_days_ago,
                    $sales_4_days_ago,
                    $sales_3_days_ago,
                    $sales_2_days_ago,
                    $yesterday_sales,
                    $today_sales,
                ])
            ->color('rgba(205, 32, 31, 1)')
            ->backgroundColor('rgba(205, 32, 31, 0.4)');
    }
}