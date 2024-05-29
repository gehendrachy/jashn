<div class="col-sm-3">
    <ul class="dashboard-left-sidebar">
        <li>
            <a href="{{ route('customer.my-account') }}" class="{{ request()->routeIs('customer.my-account') ? 'active' : '' }}" >My Dashboard</a>
        </li>
        <li>
            <a href="{{ route('customer.information') }}" class="{{ request()->routeIs('customer.information') ? 'active' : '' }}">Account information</a>
        </li>
        <li>
            <a href="{{ route('customer.addresses') }}" class="{{ request()->routeIs('customer.addresses') ? 'active' : '' }}">Billing & Shipping</a>
        </li>
        <li>
            <a href="{{ route('customer.orders') }}" class="{{ request()->routeIs('customer.orders') ? 'active' : '' }}">My Orders</a>
        </li>
        <li>
            <a href="{{ route('customer.return-requests') }}" class="{{ request()->routeIs('customer.return-requests') ? 'active' : '' }}">Returns</a>
        </li>
        <li>
            <a href="{{ route('customer.wishlist') }}" class="{{ request()->routeIs('customer.wishlist') ? 'active' : '' }}">My Wishlist</a>
        </li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </li>
    </ul>
</div>