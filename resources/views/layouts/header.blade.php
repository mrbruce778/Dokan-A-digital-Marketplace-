
    <header>
        @yield('header')
        <div class="navbar">
            <div class="nav-logo border">
                <div class="logo"></div>
            </div>
            <div class="nav-address border">
                <p class="address_1">Deliver to</p>
                <div class="add-icon">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="address_2">Bangladesh</p>
                </div>
            </div>
            <form action="{{ route('product.search') }}" method="GET" class="nav-search">
                <select name="category" class="search-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat) <!-- use plural variable from controller -->
                        <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>

                <input type="text" name="q" placeholder="Search Dokan" class="search-input" required>

                <button type="submit" class="search-icon" style="border:none; background:none; cursor:pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <div class="language">
                <select class="select-lang border">
                    <option value="en">ENG</option>
                    <option value="bn">BNG</option>
                </select>
            </div>
            <div class="nav-signin border" style="text-decoration: none; display: inline-block; color: inherit; color : inherit;">
                <a href="{{ route('customer.accounts') }} " style="text-decoration: none; display: inline-block; color: inherit;">
                    <p><span>Hello, Sign in</span></p>
                    <p class="nav-second">Account & Lists</p>
                </a>
            </div>
            <div class="nav-return border">
                <a href="{{ route('customer.orders.index') }}" style="text-decoration: none; display: inline-block; color: inherit;">
                    <p><span>Return</span></p>
                    <p class="nav-second">& Orders</p>
                </a>
            </div>

            <div class="nav-cart border" style="cursor: pointer;">
                <a href="{{ route('cart.show') }}" style="text-decoration: none; color: inherit;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Cart
                </a>
            </div>
        </div>
        <div class="panel">
            <div class="panel-all" onclick="openSidebar()">
                <i class="fa-solid fa-bars"></i>
                All
            </div>
            <div class="panel-ops">
                <p><a href="{{ route('dashboard') }}" style="color: #ffff; text-decoration: none;" >Home</a></p>
                <p><a href="{{ route('customer.service.form') }}"  style="color: #ffff; text-decoration: none;" >
                     Customer Service
        </a>    </p>

                <p>Registry</p>
                <p>Gift Cards</p>
                <p>Sell</p>
            </div>
            <div class="panel-deals">Shop deals in Electronics</div>
        </div>
    </header>

