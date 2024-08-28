<li class="nav-item">
    <a href="{{ route('products.index') }}"
       class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
       <i class="fa fa-tag" aria-hidden="true"></i>

        <p>Products</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('io_generator_builder') }}"
       class="nav-link {{ Request::is('scaffold*') ? 'active' : '' }}">
        <p>Scaffold builder</p>
    </a>
</li>


