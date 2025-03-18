<nav class="main-header navbar navbar-expand navbar-white navbar-light dark_blue_gradient">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-light" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
            </a>

        </li>
    </ul>
    <strong class="text-light"><i>{{ date('d F Y h:i a') }}</i></strong>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">

            <a class="nav-link" data-toggle="dropdown" href="" style="position: relative;">
                @php
                    $login_data = DB::table('admins as a')
                        ->where('a.id', Auth::user()->id)
                        ->leftJoin('admin_details as d', 'a.id', 'd.admin_id')
                        ->select('a.name', 'd.image')
                        ->first();
                @endphp

                @if ($login_data->image != '')
                    <img src="{{ URL::to('storage/employee', $login_data->image) }}" style="width: 30px;height:30px"
                        class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('no_image.png') }}" style="width: 30px;height:30px"
                        class="img-circle elevation-2" alt="User Image">
                @endif



                &nbsp; <span class="text-light">&nbsp;
                    {{ $login_data->name != '' ? $login_data->name : 'No Name' }}</span>
            </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
            <div class="media">
                <div class="media-body">
                  <h1 class="text-center"><a href="{{route('admin.profile.view')}}" style="width:95%;" class="btn btn-secondary py-1">Profile</a></h1>
                  <h1 class="text-center"><a href="{{route('admin.profile.change_password')}}" style="width:95%;" class="btn btn-secondary py-1">Change Password</a></h1>
                  <h1 class="text-center"><a href="{{route('admin.logout')}}" style="width: 100%;" class="btn btn-danger py-1" onclick="event.preventDefault(),document.getElementById('logout-form').submit()">Logout</a></h1>
                  <form action="{{route('admin.logout')}}" method="POST" id="logout-form" class="d-none">@csrf</form>

                </div>
            </div>
        </li>
    </ul>
</nav>
