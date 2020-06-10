<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <a class="navbar-brand" href="/">
        <img src="{{ URL::to('src/img/index-logo.png') }}" width="150" height="auto" class="d-inline-block align-top" alt="">
        <!-- Inexpensive Streaming -->
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="{{ route('product.shoppingCart') }}" class="text-decoration-none p-2 bg-dark text-white rounded">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Shopping Cart
                    <span class="badge">{{Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="nav-item dropdown" id="nav_item_myaccount">
        <a class="nav-link dropdown-toggle p-2 bg-dark text-white rounded" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            My Account
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

            @if(Auth::check())
                <a class="dropdown-item" href="{{ route('user.profile') }}">User Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
            @else
                <a class="dropdown-item" href="{{ route('user.signin') }}">Login</a>
                <a class="dropdown-item" href="{{ route('user.signup') }}">Signup</a>
            @endif
        </div>
    </div>
</nav>
