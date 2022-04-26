@extends('admin.header')
@section('title', 'Change Password - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">CHANGE PASSWORD</h3>
                <form class="form-horizontal" action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">Current Password</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="user_id" value="{{ $users->user_id }}" required> 
                            <input type="password" class="form-control" name="password" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">New Password</label>
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="new_password" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Confirm New Password</label>
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="confirm_password" required> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/users"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
    </div>
<!-- end container-fluid -->

@include('admin.footer')

@endsection