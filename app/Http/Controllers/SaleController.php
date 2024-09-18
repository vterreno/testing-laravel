<?php

namespace App\Http\Controllers;

use App\DataTables\SaleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Repositories\SaleRepository;
use Arr;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SaleController extends AppBaseController
{
    /** @var SaleRepository $saleRepository*/
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
        $this->middleware('custom.auth');
    }

    /**
     * Display a listing of the Sale.
     *
     * @param SaleDataTable $saleDataTable
     *
     * @return Response
     */
    public function index(SaleDataTable $saleDataTable)
    {
        return $saleDataTable->render('sales.index');
    }

    /**
     * Show the form for creating a new Sale.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param CreateSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleRequest $request)
    {
        $input = $request->all();

        // Crear la venta
        $sales_fields = ['payment_method_id'];

        // Obtener el valor del campo oculto
        $detailsSalesJson = $request->input('details_sales_json');

        // Convertir el JSON a un array de objetos
        $detailsSalesArray = json_decode($detailsSalesJson);

        // Verificar si el array de detalles está vacío
        if (empty($detailsSalesArray)) {
            Flash::error('Se debe agregar por lo menos un producto para guardar la venta');
            return redirect()->back()->withInput();
        }

        $sale = $this->saleRepository->create(Arr::only($input, $sales_fields));

        // Guardar los detalles de la venta
        $this->saveSalesDetails($sale, $detailsSalesArray);

        Flash::success('Venta registrada correctamente.');

        return redirect(route('sales.index'));
    }

    public function saveSalesDetails($sales, $detailsSalesArray)
    {
        // Iterar sobre los detalles y crearlos uno por uno
        foreach ($detailsSalesArray as $detailData) {
            $product = null;
            $product = Product::where('id', $detailData->product_id)->first();

            // Crear el detalle del pedido
            $salesDetail = new SaleDetail([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'sale_id' => $sales->id,
                'detail_quantity' => $detailData->detail_quantity ? $detailData->detail_quantity : null,
                'detail_unit_price_sell' => $detailData->detail_unit_price_sell ? $detailData->detail_unit_price_sell : null,
                'detail_unit_price_buy' => $detailData->detail_unit_price_buy,
            ]);
            // Guardar el detalle del pedido
            $salesDetail->save();
        }
    }


    /**
     * Display the specified Sale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }

        return view('sales.show')->with('sale', $sale);
    }

    /**
     * Show the form for editing the specified Sale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sale = $this->saleRepository->find($id);
        $sales_details = SaleDetail::where('sale_id', $sale->id)->get();
        $productos = [];
        $count = 0;

        foreach ($sales_details as $sale_detail) {
            // Obtén los datos del producto según el product_id
            $product = Product::where('id', $sale_detail->product_id)->first();

            $producto = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'unit_price_buy' => $product->unit_price_buy,
                'unit_price_sell' => $product->unit_price_sell,
            ];

            $productos[] = $producto;

            $count++;
        }

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }

        return view('sales.edit')
            ->with('sale', $sale)
            ->with('sales_details', $sales_details)
            ->with('productos', $productos)
            ->with('sale_id', $sale->id);
    }

    /**
     * Update the specified Sale in storage.
     *
     * @param int $id
     * @param UpdateSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleRequest $request)
    {
        $sales = $this->saleRepository->find($id);

        if (empty($sales)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }

        $sales = $this->saleRepository->update($request->all(), $id);

        Flash::success('Venta editada correctamente.');

        return redirect(route('sales.index'));
    }

    /**
     * Remove the specified Sale from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }

        $this->saleRepository->delete($id);

        Flash::success('Venta eliminada exitosamente.');

        return redirect(route('sales.index'));
    }
}
