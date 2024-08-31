<?php

namespace App\DataTables;

use App\Models\Sale;
use App\Models\SaleDetail;
use DB;
use NumberFormatter;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SaleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'sales.datatables_actions')
            ->editColumn('created_at', function ($sale) {
                return $sale->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('total_sales', function ($sales) {
                $formatter = new NumberFormatter('es_AR', NumberFormatter::CURRENCY);
                return $formatter->formatCurrency($sales->total_sales, 'ARS');
            })
            ->editColumn('earnings', function ($sales) {
                $formatter = new NumberFormatter('es_AR', NumberFormatter::CURRENCY);
                return $formatter->formatCurrency($sales->total_sales - $sales->total_cost, 'ARS');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Sale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sale $model)
    {
        return $model->newQuery()
            ->with('payment_method')
            ->addSelect([
                'total_sales' => SaleDetail::select(DB::raw('SUM(detail_unit_price_sell * detail_quantity)'))
                    ->whereColumn('sale_id', 'sales.id')
            ])
            ->addSelect([
                'total_cost' => SaleDetail::select(DB::raw('SUM(detail_unit_price_buy * detail_quantity)'))
                    ->whereColumn('sale_id', 'sales.id')
            ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title'=>'Acciones'])
            ->parameters([
                'dom'       => "<'row'<'col-sm-12 mb-4'B>> <'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>> <'row'<'col-sm-12'tr>> <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'excel', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'pdf', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
                'language' => [
                    'url' => asset('assets/js/dataTables/language/es-ES.json')
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('created_at')->title('Fecha'),
            Column::computed('total_sales')->title('Total venta')->defaultContent('-'),
            Column::computed('earnings')->title('Ganancia')->defaultContent('-'),
            Column::make('payment_method.name')->title('Método de pago')->defaultContent('-'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sales_datatable_' . time();
    }
}
