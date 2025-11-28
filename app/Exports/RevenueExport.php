<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Carbon\Carbon;

class RevenueExport implements FromCollection, WithHeadings, WithCharts, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->subDays(6)->startOfDay();
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
    }

    public function collection()
    {
        $data = [];
        
        // Generate date range
        for ($d = $this->startDate->copy(); $d->lte($this->endDate); $d->addDay()) {
            $dateKey = $d->format('Y-m-d');
            
            // Get revenue for this day
            $amount = Payment::whereDate('paid_at', $dateKey)->sum('amount');
            
            $data[] = [
                'date' => $d->format('Y-m-d'),
                'revenue' => (float) $amount
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pendapatan (Rp)',
        ];
    }

    public function title(): string
    {
        return 'Laporan Pendapatan';
    }

    public function charts()
    {
        $count = $this->startDate->diffInDays($this->endDate) + 1;
        
        // Define labels (Dates) - Column A, Rows 2 to N
        $categories = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Laporan Pendapatan'!\$A\$2:\$A\$" . ($count + 1), null, $count);
        
        // Define values (Revenue) - Column B, Rows 2 to N
        $values = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'Laporan Pendapatan'!\$B\$2:\$B\$" . ($count + 1), null, $count);

        $series = new DataSeries(
            DataSeries::TYPE_LINECHART, // Plot Type
            DataSeries::GROUPING_STANDARD, // Plot Grouping
            [0], // Plot Order
            [], // Labels (Empty because we only have one series)
            [$categories], // Categories
            [$values] // Values
        );

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_TOP, null, false);
        $title = new Title('Grafik Pendapatan');
        
        $chart = new Chart(
            'revenue_chart', // Name
            $title, // Title
            $legend, // Legend
            $plotArea, // PlotArea
            true, // plotVisibleOnly
            DataSeries::EMPTY_AS_GAP, // displayBlanksAs
            null, // xAxisLabel
            null  // yAxisLabel
        );

        // Set position: Top Right of the data
        $chart->setTopLeftPosition('D2');
        $chart->setBottomRightPosition('L20');

        return $chart;
    }
}
