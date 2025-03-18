@extends('dashboard.admin.layouts.master')
@push('admin_css')
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_body')
    <style>
        .welcome {
            font-size: 730%;
            font-weight: bold;
            color: #19b1ec;
            text-shadow: 0px 2px 3px #8a8a8a;
            margin-bottom: -19px;
        }

        .authorName {
            font-size: 150%;
            font-weight: bold;
            color: #3a3a3a;
            margin-bottom: -10px;
        }

        .authorDes {
            font-size: 100%;
            color: #3a3a3a;
        }

        .companyLogo {
            height: 15vh;
            margin-top: 1.5vh;
            margin-bottom: 2vh;
        }

        .companyName {
            font-size: 50px;
            color: #3a3a3a;
        }

        /* .companyInfo {
            margin-bottom: 2px;
        } */

        .company {
            margin: 0px;
            padding: 0px;
        }
    </style>
    @php
        $login_data = DB::table('admins as a')
            ->where('a.id', Auth::user()->id)
            ->leftJoin('admin_details as d', 'a.id', 'd.admin_id')
            ->select('a.name', 'd.image')
            ->first();
    @endphp

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

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="card" style="height: 90vh">
                <div>
                    <p class="welcome text-center">Welcome</p>
                    <p class="authorName text-center">{{ $login_data->name != '' ? $login_data->name : 'No Name' }}</p>
                </div>
                <div class="logo text-center">
                    @if ($logo_image == '' || $logo_image == null)
                        <img src="{{ asset('no_image.png') }}" alt="No Image"
                            class="companyLogo brand-image img-thumbnail bg-white elevation-3" style="opacity: .9">
                    @else
                        <img src="{{ URL::to('storage/logo_image', $logo_image) }}" alt="No Image"
                            class=" companyLogo brand-image img-thumbnail bg-white elevation-2" style="opacity: .9">
                    @endif
                </div>
                <h2 class="companyName text-center">
                    <b>{{ isset($admin_logos->website_name) ? $admin_logos->website_name : 'No Name' }}</b></h2>
                <div class="companyInfo text-center mb-4">
                    @if (isset($admin_logos->address))
                        <p class="company"><b>Address:</b> {{ $admin_logos->address }}</p>
                    @endif
                    @if (isset($admin_logos->web_url))
                        <p class="company"><b>Website:</b> {{ $admin_logos->web_url }}</p>
                    @endif
                    @if (isset($admin_logos->email))
                        <p class="company"><b>Email:</b> {{ $admin_logos->email }}</p>
                    @endif
                    @if (isset($admin_logos->contact_number))
                        <p class="company"><b>Mobile:</b> {{ $admin_logos->contact_number }}</p>
                    @endif
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
