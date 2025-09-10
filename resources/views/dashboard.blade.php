<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dokan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite('resources/css/dashboard.css')
    <style>
        .nav-cart {
            position: relative;
        }
        
        .cart-count-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
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

    <main>
        @yield('content')
        <div class="hero-sec">
            <div class="hero-msg">
                <p>
                    You are on Dokan. Enjoy your shopping in dokan for millions of products with fast local delivery.
                
                </p>
            </div>
        </div>

        <div class="shop-sec">

        @isset($showCategories)
            @if($showCategories)
                @foreach($categories as $category)
                    <div class="box">
                        <div class="box-content">
                            <h2>{{ $category->category_name }}</h2>
                            <div class="box-img" style="background-image: url('{{ asset($category->image_url) }}')"></div>
                            <p>
                                <a href="{{ route('category.products', $category->category_id) }}">See more</a>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        @endisset

        
        </div>
    </main>

    <footer>
        @yield('footer')
        <div class="foot-panel1">Back to top</div>
        <div class="foot-panel2">
            <ul>
                <p>Get to Know Us</p>
                <a href="#">Careers</a>
                <a href="#">Blog</a>
                <a href="#">About Dokan</a>
                <a href="#">Investor Relations</a>
                <a href="#">Dokan Devices</a>
                <a href="#">Dokan Science</a>
            </ul>
            <ul>
                <p>Make Money with Us</p>
                <a href="#">Sell products on Dokan</a>
                <a href="#">Sell on Dokan Business</a>
                <a href="#">Sell apps on Dokan</a>
                <a href="#">Become an Affiliate</a>
                <a href="#">Advertise Your Products</a>
                <a href="#">Self-Publish with Us</a>
            </ul>
            <ul>
                <p>Dokan Payment Products</p>
                <a href="#">Dokan Business Card</a>
                <a href="#">Shop with Points</a>
                <a href="#">Reload Your Balance</a>
                <a href="#">Dokan Currency Converter</a>
            </ul>
            <ul>
                <p>Let Us Help You</p>
                <a href="#">Dokan and COVID-19</a>
                <a href="#">Your Account</a>
                <a href="#">Your Orders</a>
                <a href="#">Shipping Rates & Policies</a>
                <a href="#">Returns & Replacements</a>
                <a href="#">Manage Your Content and Devices</a>
                <a href="#">Dokan Assistant</a>
                <a href="#">Help</a>
            </ul>
        </div>
        <div class="foot-panel3">
            <div class="logo"></div>
        </div>
        <div class="foot-panel4">
            <div class="pages">
                <a href="#">Conditions of Use</a>
                <a href="#">Privacy Notice</a>
                <a href="#">Your Ads Privacy Choices</a>
            </div>
            <div class="copyright">© 1996-2025, Dokan.com, Inc. or its affiliates</div>
        </div>
    </footer>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeSidebar()">&times;</a>
        <a href="#">Today's Deals</a>
        <a href="#">Customer Service</a>
        <a href="#">Registry</a>
        <a href="#">Gift Cards</a>
        <a href="#">Sell</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="closeSidebar()"></div>

    <script>
        function openSidebar() {
            document.getElementById("sidebar").style.width = "250px";
            document.getElementById("overlay").style.display = "block";
        }

        function closeSidebar() {
            document.getElementById("sidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
    @yield('scripts')
</body>
</html>