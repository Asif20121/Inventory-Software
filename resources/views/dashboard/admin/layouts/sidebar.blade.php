@php
    $route = Route::current()->getName();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @php
        $admin_logos = '';
        $logo_image = '';
        if (
            count(
                DB::table('logo_titles')
                    ->where('status', '1')
                    ->get(),
            ) != 0
        ) {
            $admin_logos = DB::table('logo_titles')->first();
            $logo_image = $admin_logos->logo_image;
        }
    @endphp
    <a href="{{ route('admin.dashboard') }}" class="brand-link"
        style="background: linear-gradient(90deg, rgb(14, 18, 130) 0%, rgb(1, 3, 4) 100%);">
        @if ($logo_image == '' || $logo_image == null)
            <img src="{{ asset('no_image.png') }}" alt="No Image" class="brand-image img-thumbnail bg-white elevation-3"
                style="opacity: .9">
        @else
            <img src="{{ URL::to('storage/logo_image', $logo_image) }}" alt="No Image"
                class="brand-image img-thumbnail bg-white elevation-2" style="opacity: .9">
        @endif
        <span
            class="brand-text text-light"><b>{{ isset($admin_logos->website_name) ? $admin_logos->website_name : 'No Name' }}</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background: linear-gradient(90deg, rgb(14, 30, 59) 0%, rgb(4, 14, 19) 100%);">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">Dashboard</li>
                @include('dashboard.admin.layouts.sidebar.auth_sidebar')

                {{-- Invoice --}}
                @include('dashboard.admin.layouts.sidebar.invoice_sidebar')
                {{-- Settings --}}

                @if (Auth::guard('admin')->user()->can('admin_setting.menu') || Auth::guard('admin')->user()->can('invoice_setting.menu'))
                    <li class="nav-header">Settings</li>
                    @include('dashboard.admin.layouts.sidebar.setting_sidebar')
                @endif
                {{-- Settings End --}}

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
