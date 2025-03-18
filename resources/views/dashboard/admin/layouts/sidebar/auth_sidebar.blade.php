{{-- Manage Admin --}}

@if (Auth::guard('admin')->user()->can('admin.dashboard'))
    <li class="nav-item {{ $route === 'admin.admin_dashboard' ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="{{ route('admin.admin_dashboard') }}" class="nav-link">
            &nbsp; <i class="fas fa-chart-line"></i>&nbsp;
            <p>
                Admin Dashboard
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
    </li>
    @endif
    @if (Auth::guard('admin')->user()->can('store.wise.dashboard'))
    <li class="nav-item {{ $route === 'admin.sw_dashboard' ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="{{ route('admin.sw_dashboard') }}" class="nav-link">
            &nbsp;<i class="fas fa-chart-pie"></i>&nbsp;
            <p>
                Store Wise Dashboard
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
    </li>
    @endif
    @if (Auth::guard('admin')->user()->can('sales.dashboard'))
    <li class="nav-item {{ $route === 'admin.sales_dashboard' ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="{{ route('admin.sales_dashboard') }}" class="nav-link">
            &nbsp;<i class="fas fa-chart-area"></i>&nbsp;
            <p>
                Sales Dashboard
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
    </li>
    @endif



@if (Auth::guard('admin')->user()->can('admin.menu'))
    <li class="nav-item {{ Request::is('admin/manage-admin*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
            <p>
                Manage Employees
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview dark_red">
            @if (Auth::guard('admin')->user()->can('admin.list'))
                <li class="nav-item">
                    <a href="{{ route('admin.admin_list') }}" class="nav-link {{ $route === 'admin.admin_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Employees List</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('admin.create'))
                <li class="nav-item">
                    <a href="{{ route('admin.admin_create') }}"
                        class="nav-link {{ $route === 'admin.admin_create' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add New Employee</p>
                    </a>
                </li>
            @endif

        </ul>
    </li>
@endif



{{-- Store Wise Employee --}}
@if (Auth::guard('admin')->user()->can('admin.store_wise_list'))
<li class="nav-item {{ Request::is('admin/storewise-employe*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
    <a href="#" class="nav-link">
        &nbsp; <i class="fas fa-user-tie"></i>&nbsp;
        <p>
            Store Wise Employee
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item">
            <a href="{{ route('admin.employe_list') }}"
                class="nav-link {{ $route === 'admin.employe_list' ? 'text-light' : '' }} ">
                <i class="far fa-circle nav-icon"></i>
                <p>SWE List</p>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- Role And Permission --}}

@if (Auth::guard('admin')->user()->can('role.permission.menu'))
    <li class="nav-item  {{ Request::is('rpm*') ? 'menu-is-opening menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fas fa-user-lock"></i>&nbsp;
            <p>
                Menu Privilege
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        {{-- Permission --}}
        <ul class="nav nav-treeview dark_red">
            <li class="nav-item {{ Request::is('rpm/permission*') ? 'menu-is-opening menu-open   rounded' : '' }}">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Permission
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('rpm.permission.list') }}"
                            class="nav-link {{ $route === 'rpm.permission.list' ? 'text-light' : '' }} ">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>All Permission List</p>

                        </a>
                    </li>
                    {{-- <li class="nav-item">
                                        <a href="{{ route('rpm.permission.create') }}"
                                            class="nav-link {{ $route === 'rpm.permission.create' ? 'text-light' : '' }} ">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Permission Create</p>
                                        </a>
                                    </li> --}}
                </ul>
            </li>
        </ul>

        {{-- Role --}}

        <ul class="nav nav-treeview dark_red">
            <li class="nav-item {{ Request::is('rpm/role*') ? 'menu-is-opening menu-open   rounded' : '' }}">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Role
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('rpm.role.list') }}"
                            class="nav-link {{ $route === 'rpm.role.list' ? 'text-light' : '' }} ">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>All Role List</p>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rpm.role.create') }}"
                            class="nav-link {{ $route === 'rpm.role.create' ? 'text-light' : '' }} ">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Role Create</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        {{-- Role In Permission --}}

        <ul class="nav nav-treeview dark_red">
            <li
                class="nav-item {{ Request::is('rpm/in_role_permission*') ? 'menu-is-opening menu-open   rounded' : '' }}">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Role In Permission
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('rpm.in_role_permission.list') }}"
                            class="nav-link {{ $route === 'rpm.in_role_permission.list' ? 'text-light' : '' }} ">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>RP List</p>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rpm.in_role_permission.create') }}"
                            class="nav-link {{ $route === 'rpm.in_role_permission.create' ? 'text-light' : '' }} ">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>RP Create</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
@endif
