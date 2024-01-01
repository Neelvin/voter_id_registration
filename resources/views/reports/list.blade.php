@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Reports</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"><a href="{{ $export_url }}" class="btn btn-success">Export Excel</a></h4>
            <div class="page-title-right">
                <form action="{{Route('reports')}}" method="get">
                    <label for="district">District :</label>
                    <input type="text" name="district" value="{{ request('district') }}">
                    <label for="state">State :</label>
                    <input type="text" name="state" value="{{ request('state') }}">

                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-body">
            <table id="reports" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Age</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $profile)
                    <tr>
                        <th>{{$loop->index + 1}}</th>
                        <th>{{$profile->first_name. ' '.$profile->last_name}}</th>
                        <th>{{$profile->email}}</th>
                        <th>{{$profile->mobile}}</th>
                        <th>{{$profile->age}}</th>
                        <th>{{$profile->created_at}}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
