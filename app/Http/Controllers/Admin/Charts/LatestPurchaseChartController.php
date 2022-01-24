<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Purchase;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class LatestPurchaseChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LatestPurchaseChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(['6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/latest-purchase'));

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
        $today_purchase = \App\Models\Purchase::whereDate('created_at', today())->count();
        $yesterday_purchase = Purchase::whereDate('created_at', today()->subDays(1))->count();
        $purchase_2_days_ago = Purchase::whereDate('created_at', today()->subDays(2))->count();
        $purchase_3_days_ago = Purchase::whereDate('created_at', today()->subDays(3))->count();
        $purchase_4_days_ago = Purchase::whereDate('created_at', today()->subDays(4))->count();
        $purchase_5_days_ago = Purchase::whereDate('created_at', today()->subDays(5))->count();
        $purchase_6_days_ago = Purchase::whereDate('created_at', today()->subDays(6))->count();

        $this->chart->dataset('Purchase Made', 'bar', [
                    $purchase_6_days_ago,
                    $purchase_5_days_ago,
                    $purchase_4_days_ago,
                    $purchase_3_days_ago,
                    $purchase_2_days_ago,
                    $yesterday_purchase,
                    $today_purchase,
                ])
            ->color('rgba(143, 94, 158, 1)')
            ->backgroundColor('rgba(143, 94, 158, 0.5)');
    }
}