<li class="nav-item">
    <a href="{{ route('products.index') }}"
       class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
       <i class="nav-icon fa fa-tag" aria-hidden="true"></i>
        <p>Productos</p>
    </a>
</li>

<!-- <li class="nav-item">
    <a href="{{ route('io_generator_builder') }}"
       class="nav-link {{ Request::is('scaffold*') ? 'active' : '' }}">
        <p>Scaffold builder</p>
    </a>
</li> -->


<li class="nav-item">
    <a href="{{ route('product-categories.index') }}"
       class="nav-link {{ Request::is('product-categories*') ? 'active' : '' }}">
       <i class="nav-icon fa fa-clipboard" aria-hidden="true"></i>
        <p>Categorías productos</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('payment_methods.index') }}"
       class="nav-link {{ Request::is('payment_methods*') ? 'active' : '' }}">
       <i class="nav-icon fa fa-clipboard" aria-hidden="true"></i>
        <p>Métodos de pago</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('sales.index') }}"
       class="nav-link {{ Request::is('sales*') ? 'active' : '' }}">
       <i class="nav-icon fa fa-clipboard" aria-hidden="true"></i>
        <p>Ventas</p>
    </a>
</li>


