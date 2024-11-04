@extends('admin.layouts.app')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-6">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.dashboard')}}">Dashboard</a>
                </li>
                @isset($page_title)
                    <li class="breadcrumb-item active">
                        <strong>{{$page_title}}</strong>
                    </li>
                @endisset
                <li class="breadcrumb-item active">
                    <strong>{{$user->name}} ({{$user->referral_code}})</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Referral Code </th>
                                    <th class="text-center">Referrer Code </th>
                                    <th class="text-center">Date</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                    @forelse ($teams as $key=>$team)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{$team->name}}</td>
                                            <td class="text-center">{{$team->phone_number}}</td>
                                            <td class="text-center">{{$team->address}}</td>
                                            <td class="text-center">{{$team->referral_code }}</td>
                                            <td class="text-center">{{$team->referrer_code }} ({{$team->referrer?->name}})</td>
                                            <td class="text-center">{{$team->created_at->format('d-m-Y h:i A')}}</td>
                                        </tr>
                                    @empty
                                        <x-admin.empty-table />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
