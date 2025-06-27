@php
$permission = new \App\Model\Permissions();
@endphp
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{Session::get('admin_profile')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Session::get ('admin_name')}}</p>
          <a href=""><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @if($permission::checkActionPermission('view_dashboard'))
        <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
        </li>
        @endif
        
        @if($permission::checkActionPermission('view_users'))    
        <li class=" {{ (request()->is('admin/users') || request()->is('admin/users/*/edit') || request()->is('admin/users/create')) ? 'active' : '' }} ">
            <a href="{{ route('users.index') }}">
                <i class="fa fa-user"></i> <span>Users</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_chef_list'))
        <li class=" {{ (request()->is('admin/chef-list')|| request()->is('admin/roles/*/edit') || request()->is('admin/roles/create')) ? 'active' : '' }}">
            <a href="{{ route('chef-list') }}">
                <i class="fa fa-registered"></i> <span>Chef List</span>
            </a>
        </li>
        @endif
        
        @if($permission::checkActionPermission('view_roles'))
        <li class=" {{ (request()->is('admin/roles') || request()->is('admin/roles/*/edit') || request()->is('admin/roles/create')) ? 'active' : '' }} ">
            <a href="{{ route('roles.index') }}">
                <i class="fa fa-object-ungroup"></i> <span>Roles</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_countries'))
        <li class=" {{ (request()->is('admin/country') || request()->is('admin/country/*/edit') || request()->is('admin/country/create')) ? 'active' : '' }} ">
            <a href="{{ route('country.index') }}">
                <i class="fa fa-flag"></i> <span>Country</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_states'))
        <li class=" {{ (request()->is('admin/state') || request()->is('admin/state/*/edit') || request()->is('admin/state/create')) ? 'active' : '' }} ">
            <a href="{{ route('state.index') }}">
                <i class="fa fa-map-marker"></i> <span>States</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_cities'))
        <li class=" {{ (request()->is('admin/city') || request()->is('admin/city/*/edit') || request()->is('admin/city/create')) ? 'active' : '' }} ">
            <a href="{{ route('city.index') }}">
                <i class="fa fa-building"></i> <span>City</span>
            </a>
        </li>
        @endif
        
        @if($permission::checkActionPermission('view_cuisine'))
        <li class=" {{ (request()->is('admin/cuisine') || request()->is('admin/cuisine/*/edit') || request()->is('admin/cuisine/create')) ? 'active' : '' }} ">
            <a href="{{ route('cuisine.index') }}">
                <i class="fa fa-cutlery"></i> <span>Cuisine</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_taxes'))
        <li class=" {{ (request()->is('admin/taxes') || request()->is('admin/taxes/*/edit') || request()->is('admin/taxes/create')) ? 'active' : '' }} ">
            <a href="{{ route('taxes.index') }}">
                <i class="fa fa-calculator"></i> <span>Taxes</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_category'))
        <li class=" {{ (request()->is('admin/category') || request()->is('admin/category/*/edit') || request()->is('admin/category/create')) ? 'active' : '' }} ">
            <a href="{{ route('category.index') }}">
                <i class="fa fa-server "></i> <span>Categories</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_country_location'))
        <li class=" {{ (request()->is('admin/country-location') || request()->is('admin/country-location/*/edit') || request()->is('admin/country-location/create')) ? 'active' : '' }} ">
            <a href="{{ route('country-location.index') }}">
               <i class="fa fa-map-marker"></i> <span>Country Location</span>
            </a>
        </li>
        @endif
        
        @if($permission::checkActionPermission('view_chef_reg_info'))
        <li class=" {{ (request()->is('admin/chef-registration-info') || request()->is('admin/chef-registration-info/*/edit') || request()->is('admin/chef-registration-info/create')) ? 'active' : '' }} ">
            <a href="{{ route('chef-registration-info.index') }}">
                <i class="fa fa-registered"></i> <span>Chef Registration</span>
            </a>
        </li>
        @endif
        
        @if($permission::checkActionPermission('view_discount'))
        <li class=" {{ (request()->is('admin/discount') || request()->is('admin/discount/*/edit') || request()->is('admin/discount/create')) ? 'active' : '' }} ">
            <a href="{{ route('discount.index') }}">
               <i class="fa fa-percent"></i> <span>Discount</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_vendor_discount'))
        <li class=" {{ (request()->is('admin/vendor-discount') || request()->is('admin/vendor-discount/*/edit') || request()->is('admin/vendor-discount/create')) ? 'active' : '' }} ">
            <a href="{{ route('vendor-discount.index') }}">
               <i class="fa fa-percent"></i> <span>Vendor Discount</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_invoice'))
        <li class=" {{ (request()->is('admin/mexico-invoice') || request()->is('admin/mexico-invoice/*/edit') || request()->is('admin/mexico-invoice/create')) ? 'active' : '' }} ">
            <a href="{{ route('mexico-invoice.index') }}">
               <i class="fa fa-list-ul"></i><span>Invoice</span>
            </a>
        </li>
        @endif

        @if($permission::checkActionPermission('view_ticket_category') || $permission::checkActionPermission('view_ticket'))
        <li class="treeview {{ (request()->is('admin/ticket-category') || request()->is('admin/ticket-category/*/edit') || request()->is('admin/ticket-category/create') || request()->is('admin/ticket')) ? 'active menu-open' : '' }}">
            <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Support</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @if($permission::checkActionPermission('view_ticket_category'))
                <li class="{{ (request()->is('admin/ticket-category') || request()->is('admin/ticket-category/*/edit') || request()->is('admin/ticket-category/create')) ? 'active' : '' }}" ><a href="{{ route('ticket-category.index') }}"><i class="fa fa-circle-o"></i> Ticket Category</a></li>
                @endif
                @if($permission::checkActionPermission('view_ticket'))
                <li class="{{ request()->is('admin/ticket') ? 'active' : '' }}"><a href="{{ route('ticket') }}"><i class="fa fa-circle-o"></i> Ticket</a></li>
                @endif
            </ul>
        </li>
        @endif
        @if($permission::checkActionPermission('view_contactus'))
        <li class=" {{ (request()->is('admin/contact-us') || request()->is('admin/contact-us/*/edit') || request()->is('admin/contact-us/create')) ? 'active' : '' }} ">
            <a href="{{ route('contact-us.index') }}">
               <i class="fa fa-address-book-o"></i><span>Contact Us</span>
            </a>
        </li>
        @endif

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>