<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{ route('admin.index') }}">
            <div class="logo-img">
                <img height="30" src="{{ asset('frontend/images/123.png') }}" class="header-brand-img"
                     title="byabasayi">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">

                <div class="nav-item @if(request()->routeIs('admin.index'))active @endif">
                    <a href="{{ route('admin.index') }}">
                        <i class="ik ik-home"></i><span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-item has-sub {{ request()->routeIs('admin.contents.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);"><i class="ik ik-info"></i><span>Info Pages</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.contents.edit', base64_encode(1)) }}" class="menu-item {{ request()->routeIs('admin.contents.edit') && $content->id == 1 ? 'active' : '' }}">About Us</a>
                        <a href="{{ route('admin.contents.edit', base64_encode(2)) }}" class="menu-item {{ request()->routeIs('admin.contents.edit') && $content->id == 2 ? 'active' : '' }}">Terms & Conditions</a>
                        <a href="{{ route('admin.contents.edit', base64_encode(3)) }}" class="menu-item {{ request()->routeIs('admin.contents.edit') && $content->id == 3 ? 'active' : '' }}" style="font-size: 10px;">Order, Return & Exchange Policy</a>
                        <a href="{{ route('admin.contents.edit', base64_encode(4)) }}" class="menu-item {{ request()->routeIs('admin.contents.edit') && $content->id == 4 ? 'active' : '' }}">Payment Policy</a>
                        <a href="{{ route('admin.contents.edit', base64_encode(5)) }}" class="menu-item {{ request()->routeIs('admin.contents.edit') && $content->id == 5 ? 'active' : '' }}">FAQ</a>
                    </div>
                </div>

                @can('site-setting-list')
                    <div class="nav-item {{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                        <a href="{{ route('admin.setting') }}">
                            <i class="ik ik-settings"></i><span>Site Settings</span>
                        </a>
                    </div>
                @endcan

                <div class="nav-item has-sub {{ request()->routeIs('admin.banners.*') || request()->routeIs('admin.sliders.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);"><i class="ik ik-image"></i><span>Content</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.banners.index') }}" class="menu-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">Home Page Banners</a>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.sliders.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-anchor"></i><span>Sliders</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.sliders.index') }}" class="menu-item {{ request()->routeIs('admin.sliders.index') ? 'active' : '' }}">List Sliders</a>
                                <a href="{{ route('admin.sliders.create') }}" class="menu-item {{ request()->routeIs('admin.sliders.create') ? 'active' : '' }}">Create New Slider</a>
                            </div>
                        </div>
                        {{-- <div class="nav-item has-sub {{ request()->routeIs('admin.contents.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-file"></i><span>Pages</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.contents.index') }}" class="menu-item {{ request()->routeIs('admin.contents.index') ? 'active' : '' }}">List Content Pages</a>
                                <a href="{{ route('admin.contents.create') }}" class="menu-item {{ request()->routeIs('admin.contents.create') ? 'active' : '' }}">Create New Content Page</a>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="nav-item has-sub {{  request()->segment(2) == 'logistics' ? 'active open' : '' }}">
                    <a href="javascript:void(0);"><i class="ik ik-truck"></i><span>Logistics</span></a>
                    <div class="submenu-content">
                        
                        <div class="nav-item has-sub {{ request()->routeIs('admin.countries.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-map-pin"></i><span>Countries</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.countries.index') }}" class="menu-item {{ request()->routeIs('admin.countries.index') ? 'active' : '' }}">List Countries</a>
                                <a href="{{ route('admin.countries.create') }}" class="menu-item {{ request()->routeIs('admin.countries.create') ? 'active' : '' }}">Create New Country</a>
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.states.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);"><i class="ik ik-map-pin"></i><span>States</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.states.index') }}" class="menu-item {{ request()->routeIs('admin.states.index') ? 'active' : '' }}">List States</a>
                                <a href="{{ route('admin.states.create') }}" class="menu-item {{ request()->routeIs('admin.states.create') ? 'active' : '' }}">Create New State</a>
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.districts.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-map-pin"></i><span>Districts</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.districts.index') }}" class="menu-item {{ request()->routeIs('admin.districts.index') ? 'active' : '' }}">List Districts</a>
                                <a href="{{ route('admin.districts.create') }}" class="menu-item {{ request()->routeIs('admin.districts.create') ? 'active' : '' }}">Create New District</a>
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.cities.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-map-pin"></i><span>Cities</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.cities.index') }}" class="menu-item {{ request()->routeIs('admin.cities.index') ? 'active' : '' }}">List Cities</a>
                                <a href="{{ route('admin.cities.create') }}" class="menu-item {{ request()->routeIs('admin.cities.create') ? 'active' : '' }}">Create New City</a>
                            </div>
                        </div>
                        
                        <div class="nav-item has-sub {{ request()->routeIs('admin.couriers.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);"><i class="ik ik-map-pin"></i><span>Couriers</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.couriers.index') }}" class="menu-item {{ request()->routeIs('admin.couriers.index') ? 'active' : '' }}">List Couriers</a>
                                <a href="{{ route('admin.couriers.create') }}" class="menu-item {{ request()->routeIs('admin.couriers.create') ? 'active' : '' }}">Create New Courier</a>

                            </div>
                        </div>
                        
                        <div class="nav-item has-sub {{ request()->routeIs('admin.courier-rates.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);"><i class="ik ik-map-pin"></i><span>Courier Rates</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.courier-rates.index') }}" class="menu-item {{ request()->routeIs('admin.courier-rates.index') ? 'active' : '' }}">List Courier Rates</a>
                                <a href="{{ route('admin.courier-rates.create') }}" class="menu-item {{ request()->routeIs('admin.courier-rates.create') ? 'active' : '' }}">Create New Courier Rate</a>

                            </div>
                        </div>

                        <div class="nav-item {{ request()->routeIs('admin.cods.*') ? 'open' : '' }} ">
                            <a href="{{ route('admin.cods.index') }}"><i class="fa fa-map-pin"></i> COD Availablilty</a>
                            {{-- <a href="javascript:void(0);"><i class="fa fa-map-pin"></i><span>CODs</span></a> --}}
                        </div>
                        
                        
                    </div>
                </div>

                <div class="nav-item has-sub {{  request()->segment(2) == 'product-groups' ? 'active open' : '' }}">
                    <a href="javascript:void(0);"><i class="ik ik-cpu"></i><span>Product Groups</span></a>
                    <div class="submenu-content">
                        
                        <div class="nav-item has-sub {{ request()->routeIs('admin.categories.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-anchor"></i><span>Categories</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">List Categories</a>
                                <a href="{{ route('admin.categories.create') }}" class="menu-item {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">Create New Category</a>
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.occassions.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);"><i class="ik ik-calendar"></i><span>Occassions</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.occassions.index') }}" class="menu-item {{ request()->routeIs('admin.occassions.index') ? 'active' : '' }}">List Occassions</a>
                                <a href="{{ route('admin.occassions.create') }}" class="menu-item {{ request()->routeIs('admin.occassions.create') ? 'active' : '' }}">Create New Occassion</a>
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.colors.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="fa fa-fill-drip"></i><span>Colors</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.colors.index') }}" class="menu-item {{ request()->routeIs('admin.colors.index') ? 'active' : '' }}">List Colors</a>
                                <a href="{{ route('admin.colors.create') }}" class="menu-item {{ request()->routeIs('admin.colors.create') ? 'active' : '' }}">Create New Color</a>
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ request()->routeIs('admin.product-cares.*') ? 'active open' : '' }} ">
                            <a href="javascript:void(0);"><i class="ik ik-sun"></i><span>Product Cares</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.product-cares.index') }}" class="menu-item {{ request()->routeIs('admin.product-cares.index') ? 'active' : '' }}">List Product Cares</a>
                                <a href="{{ route('admin.product-cares.create') }}" class="menu-item {{ request()->routeIs('admin.product-cares.create') ? 'active' : '' }}">Create New Product Care</a>
                            </div>
                        </div>
                        
                        <div class="nav-item has-sub {{ request()->routeIs('admin.size-groups.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);"><i class="ik ik-bar-chart-2"></i><span>Size Group</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.size-groups.index') }}" class="menu-item {{ request()->routeIs('admin.size-groups.index') ? 'active' : '' }}">List Size Groups</a>
                                <a href="{{ route('admin.size-groups.create') }}" class="menu-item {{ request()->routeIs('admin.size-groups.create') ? 'active' : '' }}">Create New Size Group</a>

                            </div>
                        </div>
                        
                        <div class="nav-item has-sub {{ request()->routeIs('admin.size-guides.*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);"><i class="ik ik-bar-chart-2"></i><span>Size Guide</span></a>
                            <div class="submenu-content">
                                <a href="{{ route('admin.size-guides.index') }}" class="menu-item {{ request()->routeIs('admin.size-guides.index') ? 'active' : '' }}">List Size Guides</a>
                                <a href="{{ route('admin.size-guides.create') }}" class="menu-item {{ request()->routeIs('admin.size-guides.create') ? 'active' : '' }}">Create New Size Guide</a>

                            </div>
                        </div>
                        
                        
                    </div>
                </div>

                <div class="nav-item  has-sub {{ request()->routeIs('admin.products.*') ? 'active open' : '' }} ">
                    <a href="javascript:void(0);"><i class="ik ik-shopping-cart"></i><span>Products</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">List Products</a>
                        <a href="{{ route('admin.products.create') }}" class="menu-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">Create New Product</a>
                    </div>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.customers.index') }}">
                        <i class="ik ik-user"></i><span>Customers</span>
                    </a>
                </div>
                
                <div class="nav-item  has-sub {{ request()->routeIs('admin.orders.*') ? 'active open' : '' }} ">
                    <a href="javascript:void(0);"><i class="ik ik-shopping-bag"></i><span>Orders</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.orders.add-new-order') }}" class="menu-item {{ request()->routeIs('admin.orders.add-new-order') ? 'active' : '' }}">Add New Order</span></a>
                        <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">Orders</span></a>
                        <a href="{{ route('admin.orders.on-route') }}" class="menu-item {{ request()->routeIs('admin.orders.on-route') ? 'active' : '' }}">On Route</span></a>
                        <a href="{{ route('admin.orders.arrived') }}" class="menu-item {{ request()->routeIs('admin.orders.arrived') ? 'active' : '' }}">Arrived</span></a>
                        <a href="{{ route('admin.orders.rts') }}" class="menu-item {{ request()->routeIs('admin.orders.rts') ? 'active' : '' }}">RTS</span></a>
                        <a href="{{ route('admin.orders.shipment') }}" class="menu-item {{ request()->routeIs('admin.orders.shipment') ? 'active' : '' }}">Shipment</span></a>
                        <a href="{{ route('admin.return-requests.index') }}" class="menu-item {{ request()->routeIs('admin.return-requests.index') ? 'active' : '' }}">Return Requests</span></a>
                        {{-- <a href="{{ route('admin.orders.canceled') }}" class="menu-item {{ request()->routeIs('admin.orders.canceled') ? 'active' : '' }}">Canceled</span></a> --}}
                    </div>
                </div>

                {{-- <div class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}">
                        <i class="ik ik-shopping-bag"></i><span>Orders</span>
                    </a>
                </div> --}}

                <div class="nav-item {{ request()->routeIs('admin.return-requests.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.return-requests.index') }}">
                        <i class="ik ik-rotate-ccw"></i><span>Returns</span>
                    </a>
                </div>

                <div class="nav-item  has-sub {{ request()->routeIs('admin.offers.*') ? 'active open' : '' }} ">
                    <a href="javascript:void(0);"><i class="ik ik-shopping-cart"></i><span>Offers</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.offers.index') }}" class="menu-item {{ request()->routeIs('admin.offers.index') ? 'active' : '' }}">List Offers</a>
                        <a href="{{ route('admin.offers.create') }}" class="menu-item {{ request()->routeIs('admin.offers.create') ? 'active' : '' }}">Create New Offer</a>
                    </div>
                </div>

                <div class="nav-item  has-sub {{ request()->routeIs('admin.discount-coupons.*') ? 'active open' : '' }} ">
                    <a href="javascript:void(0);"><i class="ik ik-shopping-cart"></i><span>Discount Coupons</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.discount-coupons.index') }}" class="menu-item {{ request()->routeIs('admin.discount-coupons.index') ? 'active' : '' }}">List Discount Coupons</a>
                        <a href="{{ route('admin.discount-coupons.create') }}" class="menu-item {{ request()->routeIs('admin.discount-coupons.create') ? 'active' : '' }}">Create New Coupon</a>
                    </div>
                </div>

                <div class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.sales') }}">
                        <i class="fa fa-bars"></i><span>Sales Reports</span>
                    </a>
                </div>
                
                <div class="nav-item has-sub">
                    <a href="javascript:void(0);"><i class="ik ik-user"></i><span>Users & Roles</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.users.index') }}" class="menu-item  @if(request()->routeIs('admin.users.*'))active @endif">Users Management</a>
                        <a href="{{ route('admin.roles.index') }}" class="menu-item  @if(request()->routeIs('admin.roles.*'))active @endif">Roles & Permission Management</a>
                    </div>
                </div>

            </nav>

        </div>
    </div>
</div>
