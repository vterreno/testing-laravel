@if(isset($sales_details))
<script>
    var sales_details = @json($sales_details)

    var ventaCreada = true

    var sales_id_global = @json($sale_id)

    console.log(sales_details)
</script>
@else
<script>
    var sales_details = []
    var ventaCreada = false;
</script>
@endif

@if(isset($productos))
<script>
    var productos = @json($productos)

    console.log(productos)
</script>
@else
<script>
    var productos = []
</script>
@endif

<!-- Botón para abrir el modal -->
<div class="form-group col-sm-12" style="margin-top: 2em;">
    <button class="btn btn-primary px-4 float-right" onclick="validateAndOpenModal()">
        + Agregar producto
    </button>
</div>

<!-- Tabla de características de productos -->
<table class="table table-bordered table-striped">
    <thead>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio unitario de compra</th>
        <th>Precio unitario venta</th>
        <th class="col-sm-1">Acciones</th>
    </thead>

    <!-- Cuerpo de la tabla -->
    <tbody id="detailsTableBody">
        <tr>
            <td colspan="7" style="text-align: center;"> No hay productos para mostrar </td>
        </tr>
    </tbody>

    <tfooter>
        <tr id="costo_footer" >
            <td colspan="3" style="text-align: end; background: white;">
                <b>Total compra</b>
            </td>
            <td colspan="1" style="background: #fafafa;"><span id="totalCostoProduccion" style="font-weight: 600;"></span></td>
        </tr>
        <tr id="ganancia_footer">
            <td colspan="3" style="text-align: end; background: white;">
                <b>Ganancia</b>
            </td>
            <td colspan="1" style="background: #fafafa;"><span id="totalGanancia" style="font-weight: 600;"></span></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: end; background: white;" id="venta_footer" >
                <b>Total venta</b>
            </td>
            <td colspan="1" style="background: #fafafa;"><span id="totalVenta" style="font-weight: 600;"></span></td>
        </tr>
    </tfooter>

</table>

<!-- Modal para agregar producto -->
<div class="modal fade" id="agregarSalesDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1000px;">
        <div class="modal-content">
            <!-- Contenido del formulario modal -->
            <div class="modal-body">
                <div class="row">
                    @include('sales_details.fields')
                    <script>
                        $('.select-product').select2({
                            language: 'es',
                            width: '100%',
                            dropdownParent: $('#agregarSalesDetailModal')
                        }).on('select2:select', function(e) {
                            var datos = e.params.data;
                            obtenerProducto(datos.id);
                        });
                    </script>
                </div>
            </div>
            <!-- Fin del contenido del formulario modal -->

            <!-- Pie del formulario modal -->
            <div class="modal-footer">
                <button class="btn px-4 btn-default" data-dismiss="modal" onclick="cancelar()">Cancelar</button>
                <button type="button" class="btn btn-primary px-4" onclick="confirmarGuardarProducto()">Guardar producto</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin del modal -->

<script>
    var product_global
    var modalTitle = document.getElementById('modalTitle');
    var modoEdicion = false
    var indexObjeto

    $(".select-product").prop('required', false);

    calcularTotal()
    actualizarTablaProductos()

    // Función para validar y abrir el modal
    function validateAndOpenModal() {
        event.preventDefault();
        modalTitle.innerText = 'Agregar producto';
        $('#agregarSalesDetailModal').modal('show');
        $('#product_id, #detail_quantity').val('');

        // Limpiar select2
        $(".select-product").prop('required', true);
        $(".select-product").attr('title', 'Seleccione un producto');
        $(".select-product").val(null).trigger("change")
        $("#select2-product_id-container").text('Seleccione un producto');
    }

    function obtenerProducto(product_id) {
        // console.log( product_id)
        $.ajax({
            url: '/obtener-producto/' + product_id,
            method: 'GET',
            success: function(response) {
                product = response.product
                product_global = product
                $(".select-product").prop('required', true);
            },
            error: function(error) {
                console.error("Error en la petición AJAX:", error);
            }
        });
    }

    function cancelar() {
        event.preventDefault()
        $(".select-product").prop('required', false);
        $('#agregarSalesDetailModal').modal('hide');
    }

    function confirmarGuardarProducto() {
        // Verificar el valor de la variable ventaCreada
        if (ventaCreada) {
            Swal.fire({
                title: 'Guardar producto',
                text: '¿Está seguro que desea guardar o modificar este producto?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (modoEdicion != true) {
                        productos.push(product_global)
                    }

                    guardarProductoYDetalle()

                    var prod_detail = sales_details[indexObjeto]
                    //console.log(prod_detail)
                    //console.log(indexObjeto)
                    $.ajax({
                        url: '/actualizar-sales-detail',
                        type: 'POST',
                        data: {
                            id: prod_detail.id ? prod_detail.id : null,
                            product_id: prod_detail.product_id,
                            product_name: prod_detail.product_name,
                            detail_quantity: prod_detail.detail_quantity,
                            detail_unit_price_sell: prod_detail.detail_unit_price_sell,
                            detail_unit_price_buy: prod_detail.detail_unit_price_buy,
                            sales_id: sales_id_global,

                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //console.log('Se guardo correctamente el detalle')

                            $(".select-product").prop('required', false);

                            actualizarTablaProductos()
                        },
                        error: function(error) {
                            console.log('Error al cambiar el estado:', error);
                        }
                    });
                }
            });
        } else {
            if (modoEdicion != true) {
                productos.push(product_global)
            }
            $(".select-product").prop('required', false);
            guardarProductoYDetalle();
        }
    }

    function guardarProductoYDetalle() {
        if (modoEdicion == true) {
            //console.log(sales_details)

            // si se selecciona otro producto, se debe modificar el array de productos para que coincidan con los detalles de productos
            var product_id = document.getElementById('product_id').value;
            //console.log(product_id)
            if (sales_details[indexObjeto].product_id.toString() !== product_id.toString()) {
                obtenerProducto(product_id)
                console.log("Producto global: ", product_global)
                productos[indexObjeto] = product_global
                sales_details[indexObjeto].product_id = productos[indexObjeto].id
                sales_details[indexObjeto].product_name = productos[indexObjeto].name
                sales_details[indexObjeto].detail_unit_price_buy = productos[indexObjeto].detail_unit_price_buy
                sales_details[indexObjeto].detail_unit_price_sell = productos[indexObjeto].detail_unit_price_sell
            }

            console.log('Productos editado: ', productos)
            console.log('Detalles de ventas: ', sales_details)
            // console.log("INDEX OBJETO: " + indexObjeto)
            // console.log(productos[indexObjeto])

            sales_details[indexObjeto].detail_quantity = document.getElementById('detail_quantity').value;
            sales_details[indexObjeto].detail_unit_price_sell = productos[indexObjeto].unit_price_sell;
            sales_details[indexObjeto].detail_unit_price_buy = productos[indexObjeto].unit_price_buy
            sales_details[indexObjeto].detail_unit_price_sell = productos[indexObjeto].unit_price_sell
            // console.log("PRODUCTO ID: " + sales_details[indexObjeto].product_id)
            // console.log("productos ID: " + productos[indexObjeto].id)

            var product = productos.find(function(product) {
                return String(product.id) === String(sales_details[indexObjeto].product_id);
            });

            modoEdicion = false;
        } else {
            // Recolectar datos del formulario
            var index = sales_details.length

            var formData = {
                index: index,
                product_id: productos[index].id,
                product_name: productos[index].name,
                detail_unit_price_buy: productos[index].unit_price_buy,
                detail_unit_price_sell: productos[index].unit_price_sell,
                detail_quantity: document.getElementById('detail_quantity').value,
            };

            sales_details.push(formData);
            console.log(sales_details)
            indexObjeto = index
        }

        // Cerrar el modal después de enviar
        $('#agregarSalesDetailModal').modal('hide');

        // Borrar contenido para próxima carga
        $('#product_id, #detail_quantity').val('');

        // Limpiar select2
        $(".select-product").attr('title', 'Seleccione un producto');
        $(".select-product").val(null).trigger("change")
        $("#select2-product_id-container").text('Seleccione un producto');
        $(".select-product").prop('required', false);
        actualizarTablaProductos()
    }

    function actualizarTablaProductos() {
        var tableBody = document.getElementById('detailsTableBody');

        // Limpiar el contenido actual de la tabla
        tableBody.innerHTML = '';

        // Verificar si hay detalles en el array
        if (sales_details.length > 0) {
            // Iterar sobre los detalles y construir las filas de la tabla
            sales_details.forEach(function(detail, index) {
                var row = document.createElement('tr');

                var buttonsHtml = '';
                buttonsHtml += '<div style="display: flex;">'

                buttonsHtml += '<button onclick="editarDetalle(' + index + ')" class="btn btn-editar borders px-2 py-1 btn-xs" title="Editar"><i class="fa fa-edit"></i></button>';

                // Siempre añadir el botón de eliminar
                buttonsHtml += '<button onclick="borrarDetalle(' + index + ')" class="btn btn-danger px-2 borders py-1 btn-delete btn-xs"><i class="fa fa-trash" title="Eliminar"></i></button></div>';

                var unit_price_sell = parseFloat(detail.detail_unit_price_sell ? detail.detail_unit_price_sell : 0);

                // Formatear el precio
                var formattedUnitPriceSell = unit_price_sell.toLocaleString('es-ES', {
                    style: 'currency',
                    currency: 'ARS'
                });

                var unit_price_buy = parseFloat(detail.detail_unit_price_buy ? detail.detail_unit_price_buy : 0);

                var formattedCost = (unit_price_buy).toLocaleString('es-ES', {
                    style: 'currency',
                    currency: 'ARS'
                });

                console.log(detail.product_name)
               
                var properties = [
                    detail.product_name,
                    detail.detail_quantity ? detail.detail_quantity : '-',
                    formattedCost,
                    formattedUnitPriceSell,
                    buttonsHtml,
                ];

                properties.forEach(function(property) {
                    var cell = document.createElement('td');

                    if (typeof property === 'string') {
                        cell.innerHTML = property;
                    } else {
                        cell.textContent = property;
                    }
                    row.appendChild(cell);
                });

                tableBody.appendChild(row);

            });
        } else {
            // Si no hay detalles, mostrar un mensaje en una única fila
            var emptyRow = document.createElement('tr');
            var cell = document.createElement('td');
            cell.setAttribute('colspan', '7');
            cell.classList.add('text-center');
            cell.textContent = 'No hay productos agregados';
            emptyRow.appendChild(cell);
            tableBody.appendChild(emptyRow);
        }

        $(".select-product").prop('required', false);
        var detailsSalesJson = JSON.stringify(sales_details);
        $('#detailsSalesJson').val(detailsSalesJson);
        calcularTotal()
    }

    function editarDetalle(index) {
        event.preventDefault();
        // Obtener el detalle del array usando el índice
        var detalle = sales_details[index];
        var product = productos.find(function(product) {
            return String(product.id) === String(sales_details[index].product_id);
        });
        modoEdicion = true;
        indexObjeto = index

        $('.select-product').val(sales_details[index].product_id).trigger('change.select2');

        // Obtener el texto de la opción seleccionada
        var selectedTextItem = $('.select-product').find('option:selected').text();

        // Actualizar el texto mostrado en el Select2
        $('.select-product').next('.select2-container').find('.select2-selection__rendered').text(selectedTextItem);

        document.getElementById('detail_quantity').value = detalle.detail_quantity;

        modalTitle.innerText = 'Editar producto';

        //console.log(insumo)
        //console.log(productos)
        //console.log(sales_details[index].item_id)
        
        $('#agregarSalesDetailModal').modal('show');
    }

    function borrarDetalle(index) {
        event.preventDefault()
        // Verificar el valor de la variable ventaCreada
        if (ventaCreada) {
            Swal.fire({
                title: 'Eliminar producto',
                text: '¿Está seguro que desea eliminar este producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ajax request para borrar detalle de producto creado
                    $.ajax({
                        url: '/borrar-sales-detail',
                        type: 'POST',
                        data: {
                            id: parseInt(sales_details[index].id),
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //console.log('Se borro correctamente el detalle')

                            $(".select-product").prop('required', false);

                            productos.splice(index, 1)
                            sales_details.splice(index, 1)
                            actualizarTablaProductos()
                        },
                        error: function(error) {
                            console.log('Error al cambiar el estado:', error);
                        }
                    });
                }
            });
        } else {
            productos.splice(index, 1)
            sales_details.splice(index, 1)
            actualizarTablaProductos()
        }

    }

    function calcularTotal() {
        var totalCostProd = 0
        var totalVenta = 0
        var ganancia = 0

        var spanTotalCostProd = document.getElementById('totalCostoProduccion');
        var spanGanancia = document.getElementById('totalGanancia')
        var spanTotalVenta = document.getElementById('totalVenta')

        sales_details.forEach(element => {
            totalCostProd += parseFloat(element.detail_unit_price_buy) * parseFloat(element.detail_quantity)
            totalVenta += parseFloat(element.detail_unit_price_sell) * parseFloat(element.detail_quantity)
        });

        ganancia = totalVenta - totalCostProd

        var formattedPriceCosto = totalCostProd.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'ARS'
        });

        var formattedPriceVenta = totalVenta.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'ARS'
        });

        var formattedPriceGanancia = ganancia.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'ARS'
        });

        spanTotalCostProd.innerText = formattedPriceCosto
        spanGanancia.innerText = formattedPriceGanancia
        spanTotalVenta.innerText = formattedPriceVenta
    }
</script>