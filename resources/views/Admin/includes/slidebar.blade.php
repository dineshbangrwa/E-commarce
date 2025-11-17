<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="{{route('dashboard')}}" class="logo">
        <img src="{{ asset('front/images/logo.png') }}?v={{ time() }}" loading="lazy" alt="navbar brand" class="navbar-brand"
          height="35" />
       {{-- <h1 class="side" height="20">Admin</h1> --}}

      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  <hr style="color: white">

  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">

      <ul class="nav nav-secondary">
        <li class="nav-item  {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
          <a href="{{route('dashboard')}}">
            <i class="fas fa-home"></i>

            <p>Dashboard</p>
          </a>

        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Components</h4>
        </li>
        <li class="nav-item {{ (request()->is('admin/users*')) ? 'active' : '' }}">
          @can('user_index')
          <a href="{{ route('users.index') }}">
            <i class="icon-user"></i>
            <p>USER</p>
          </a>
          @endcan
        </li>
        <li class="nav-item {{ (request()->is('admin/block*')) ? 'active' : '' }}">
          @can('block_index')
          <a href="{{ route('block.index') }}">
            <i class="fas fa-book-reader"></i>
            <p>Block</p>
            @endcan
          </a>

        </li>
        <li class="nav-item {{ (request()->is('admin/enquiry*')) ? 'active' : '' }}">
          @can('enquiry_index')
          <a href="{{ route('enquiry.index') }}">
            <i class="fas fa-book-reader"></i>
            <p>Enquiry</p>
            @endcan
          </a>

        </li>
        <li class="nav-item {{ (request()->is('admin/categorires*')) ? 'active' : '' }}">
          @can('category_index')
          <a href="{{ route('category.index') }}">
            <i class="fas fa-bug"></i>
            <p>Category</p>
            @endcan
          </a>

        </li>
        <li class="nav-item {{ (request()->is('admin/page*')) ? 'active' : '' }}">
          @can('page_index')
          <a href="{{route('page.index')}}">
            <i class="fas fa-chart-pie"></i>
            <p>Page</p>
            @endcan
          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/product*')) ? 'active' : '' }}">
          @can('product_index')
          <a href="{{route('product.index')}}">
            <i class="fas fa-church"></i>
            <p>Product</p>
            @endcan
          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/slider*')) ? 'active' : '' }}">
          @can('slider_index')
          <a href="{{route('slider.index')}}">
            <i class="fas fa-american-sign-language-interpreting"></i>
            <p>Slider</p>
            @endcan
          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/permission*')) ? 'active' : '' }}">
          @can('permission_index')
          <a href="{{ route('permission.index')}}">
            <i class="fas fa-th-list"></i>
            <p>permission</p>
            @endcan
          </a>

        </li>
        <li class="nav-item {{ (request()->is('admin/role*')) ? 'active' : '' }}">
          {{-- @can('role_index') --}}
          <a href="{{ route('role.index') }}">
            <i class="fas fa-pen-square"></i>
            <p>Role</p>
            {{-- @endcan --}}
          </a>

        </li>
        {{-- <li class="nav-item {{ (request()->is('admin/attribute*')) ? 'active' : '' }}">
          @can('attribute_index')
          <a href="">
            <i class="fas fa-award"></i>
            <p>Attribute</p>
            @endcan
          </a>

        </li> --}}
        {{-- <li class="nav-item {{ (request()->is('admin/attributevalue*')) ? 'active' : '' }}">
          @can('attributevalue_index')
          <a href="">
            <i class="fas fa-book-open"></i>
            <p>Attribute value</p>
            @endcan
          </a> --}}

        </li>
        <li class="nav-item {{ (request()->is('admin/currency*')) ? 'active' : '' }}">
          {{-- @can('attributevalue_index') --}}
          <a href="{{ route('currency.index') }}">
            <i class="fas fa-book-open"></i>
            <p>Currency</p>
            {{-- @endcan --}}
          </a>

        </li>
        <li class="nav-item {{ (request()->is('admin/exchange_rates*')) ? 'active' : '' }}">
          {{-- @can('attributevalue_index') --}}
          <a href="{{ route('exchange_rates.index') }}">
            <i class="fas fa-book-open"></i>
            <p>currency_exchange_rates</p>
            {{-- @endcan --}}
          </a>

        </li>
        <li class="nav-item {{ (request()->is('admin/coupon*')) ? 'active' : '' }}">

          <a href="{{route('coupon.index')}}">
            <i class="fas fa-american-sign-language-interpreting"></i>
            <p>Coupon</p>

          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/reviews*')) ? 'active' : '' }}">

          <a href="{{route('reviews.index')}}">
            <i class="fas fa-american-sign-language-interpreting"></i>
            <p>Review</p>

          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('admin.logout')}}">
            <i class="icon-logout"></i>
            <p>Logout</p>
          </a>

        </li>

      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->