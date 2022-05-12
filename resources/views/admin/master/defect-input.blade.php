@extends('admin.header')
@section('title', 'Input Defect - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">INPUT DEFECT DATA</h3>
                <form class="form-horizontal" action="{{ route('defect.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-5 control-label">Kode Defect</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="kode_defect" maxlength="10" placeholder="Kode Defect" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-5 control-label">Temuan Defect</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="defect" maxlength="20" placeholder="Temuan Defect" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-7">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/defect"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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