<ul class="navbar-nav sidebar sidebar-light bg-white accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">

            <img src="backend/img/logo-inem.png" alt="">

        <div class="sidebar-brand-text mx-3">{{ __('INEM') }}</div>
    </a>

    <!-- Divider -->

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->

    @if (auth()->user()->level == 1)
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                aria-controls="collapseTwo">
                <span>{{ __('Kelola User') }}</span>
            </a>
            <a class="nav-link" href="{{ route('users.index') }}"> <i class="fa fa-user mr-2"></i>
                {{ __('Users') }}</a>
            {{-- <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item " href="{{ route('permissions.index') }}"> <i
                            class="fa fa-briefcase mr-2"></i> {{ __('Permissions') }}</a>
                    <a class="collapse-item" href="{{ route('roles.index') }}"><i class="fa fa-briefcase mr-2"></i>
                        {{ __('Roles') }}</a>

                </div>
            </div> --}}
        </li>
    @else
    <div class="nav-item">
        <li class="nav-link">
                <span>{{ __('Kelola Produk') }}</span>
            </li>
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>{{ __('Produk') }}</span></a>
    </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="fas fa-fw fa-sitemap"></i>
                <span>{{ __('Kategori') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('varieties.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>{{ __('Pilihan') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('prices.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>{{ __('Harga') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('stocks.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>{{ __('Stok') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('histories.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>{{ __('Histori Stok') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('statuses.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>{{ __('Status') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('gabungan.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>{{ __('Semua') }}</span></a>
        </li>
        <div class="nav-item">
            <li class="nav-link">
            <span>{{ __('Kelola Keuangan') }}</span>
        </li>
        </div>

    <li class="nav-item">

        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fa fa-shopping-bag mr-2"></i>
            <span>{{ __('Transaksi') }}</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item " href="{{ route('transaksi.ringkasan') }}"> <i
                        class="fa fa-briefcase mr-2"></i> {{ __('ringkasan transaksi') }}</a>
                <a class="collapse-item" href="{{ route('transaksi.index') }}"><i class="fa fa-shopping-bag mr-2"></i>
                    {{ __('semua transaksi') }}</a>

            </div>
        </div>
    </li>

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="fas fa-fw fa-shopping-bag"></i>
                <span>{{ __('transaksi') }}</span></a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('transaksis.penghasilan') }}">
                <i class="fas fa-fw fa-calculator"></i>
                <span>{{ __('Penghasilan') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('transaksis.laporan') }}">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>{{ __('Laporan') }}</span></a>
        </li>
    @endif

</ul>
