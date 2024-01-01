@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Voters</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Voters</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
                <div class="row">
                    <a href="{{Route('voter.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate method="post" action="{{Route('voter.update',[$voter_profile->id])}}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="first_name">First name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="enter your first name" value="{{old('first_name', $voter_profile->first_name)}}" required>
                                @error('first_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="last_name">Last name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="enter your last name" value="{{old('last_name', $voter_profile->last_name)}}" required>
                                @error('last_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $voter_profile->email)}}" required placeholder="Enter your email">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date</label>
                                <input class="form-control @error('dob') is-invalid @enderror" type="date" value="{{old('dob', $voter_profile->dob)}}" id="dob" name="dob" required>
                                @error('dob')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input class="form-control @error('mobile') is-invalid @enderror" type="number" value="{{old('mobile', $voter_profile->mobile)}}" id="mobile" name="mobile" placeholder="please enter your mobile number" required>
                                @error('mobile')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="1" placeholder="please enter your address number" required>{{old('address', $voter_profile->address)}}</textarea>
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="taluk">Taluk</label>
                                <input type="text" class="form-control @error('taluk') is-invalid @enderror" id="taluk" name="taluk" placeholder="enter your taluk" value="{{old('taluk', $voter_profile->taluk)}}" required>
                                @error('taluk')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="district">District</label>
                                <input type="text" class="form-control @error('district') is-invalid @enderror" id="district" name="district" placeholder="enter your district" value="{{old('district', $voter_profile->district)}}" required>
                                @error('district')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="state">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="enter your state" value="{{old('state', $voter_profile->state)}}" required>
                                @error('state')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="state">Created At</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="enter your state" value="{{$voter_profile->created_at}}" readonly>
                                @error('state')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection