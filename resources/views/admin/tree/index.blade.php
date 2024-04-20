@extends('admin.layouts.app')
@section('content')
    @push('css')
        <style>
            .tree ul {
                padding-top: 20px;
                position: relative;

                transition: all 0.5s;
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
            }

            .tree li {
                float: left;
                text-align: center;
                list-style-type: none;
                position: relative;
                padding: 20px 5px 0 5px;

                transition: all 0.5s;
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
            }

            /*We will use ::before and ::after to draw the connectors*/

            .tree li::before,
            .tree li::after {
                content: '';
                position: absolute;
                top: 0;
                right: 50%;
                border-top: 1px solid #ccc;
                width: 50%;
                height: 20px;
            }

            .tree li::after {
                right: auto;
                left: 50%;
                border-left: 1px solid #ccc;
            }

            /*We need to remove left-right connectors from elements without
                any siblings*/
            .tree li:only-child::after,
            .tree li:only-child::before {
                display: none;
            }

            /*Remove space from the top of single children*/
            .tree li:only-child {
                padding-top: 0;
            }

            /*Remove left connector from first child and
                right connector from last child*/
            .tree li:first-child::before,
            .tree li:last-child::after {
                border: 0 none;
            }

            /*Adding back the vertical connector to the last nodes*/
            .tree li:last-child::before {
                border-right: 1px solid #ccc;
                border-radius: 0 5px 0 0;
                -webkit-border-radius: 0 5px 0 0;
                -moz-border-radius: 0 5px 0 0;
            }

            .tree li:first-child::after {
                border-radius: 5px 0 0 0;
                -webkit-border-radius: 5px 0 0 0;
                -moz-border-radius: 5px 0 0 0;
            }

            /*Time to add downward connectors from parents*/
            .tree ul ul::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                border-left: 1px solid #ccc;
                width: 0;
                height: 20px;
            }

            .tree li a {
                border: 1px solid #ccc;
                padding: 5px 10px;
                text-decoration: none;
                color: #666;
                font-family: arial, verdana, tahoma;
                font-size: 11px;
                display: inline-block;

                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;

                transition: all 0.5s;
                -webkit-transition: all 0.5s;
                -moz-transition: all 0.5s;
            }

            .tree li a img {
                width: 38px;
                aspect-ratio: 1 / 1;
                border-radius: 30px;
                margin-top: -28px;
                margin-bottom: 5px;
            }

            .data p {
                font-size: 12px;
                line-height: 20px;
                letter-spacing: 0.5px;
                text-align: left;
            }

            /*Time for some hover effects*/
            /*We will apply the hover effect the the lineage of the element also*/
            .tree li a:hover,
            .tree li a:hover+ul li a {
                background: #c8e4f8;
                color: #000;
                border: 1px solid #94a0b4;
            }

            /*Connector styles on hover*/
            .tree li a:hover+ul li::after,
            .tree li a:hover+ul li::before,
            .tree li a:hover+ul::before,
            .tree li a:hover+ul ul::before {
                border-color: #94a0b4;
            }
        </style>
    @endpush
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-6">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                @isset($page_title)
                    <li class="breadcrumb-item active">
                        <strong>{{ $page_title }}</strong>
                    </li>
                @endisset
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                @foreach ($users as $user)
                    <ul>{{$user->name}}</ul>
                    @foreach (App\Models\User::where('parent_id',$user->id)->get() as $child)
                        <li>{{$child->name}}</li>
                    @endforeach
                    @php
                        break;
                    @endphp
                @endforeach
            </div>
        </div>
    </div>
@endsection
