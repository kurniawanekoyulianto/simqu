@extends('admin.header')
@section('title', 'Edit Defect - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">UBAH DATA DEFECT</h3>
                <form class="form-horizontal" action="{{ route('defect.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Kode Defect</label>
                        <div class="col-sm-7">
                            <input type="hidden" class="form-control" name="id_defect" value="{{ $defect->id_defect }}" readonly autocomplete="false">
                            <input type="text" class="form-control" name="kode_defect" maxlength="3" placeholder="Kode Defect" value="{{ $defect->kode_defect }}" readonly>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Departemen</label>
                        <div class="col-sm-7">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value='0'>Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $defect->id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Temuan Defect</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="defect" maxlength="50" placeholder="Temuan Defect" value="{{ $defect->defect }}" required>
                            <input type="hidden" class="form-control" name="original_defect" maxlength="50" placeholder="Temuan Defect" value="{{ $defect->defect }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Kriteria</label>
                        <div class="col-sm-7">
                            <input type="checkbox" name="critical" value="1" id="kriteria"> Critical
                            <input type="checkbox" name="major" value="1" id="kriteria"> Major
                            <input type="checkbox" name="minor" value="1" id="kriteria"> Minor
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px">
                        <div class="col-sm-3"></div>
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

<script type="text/javascript">
    $(document).ready(function() {

        $('select[name="id_departemen"]').on('change', function() {
            var departemenID = $(this).val();
            if(departemenID) {
                $.ajax({
                    url: '/defect-sub/'+departemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_sub_departemen"]').empty();
                            $('select[name="id_sub_departemen"]').append('<option value="0" selected>Pilih Sub Departemen</option>');
                            // Remove options
                            $('#id_sub_departemen').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_sub_departemen"]').append('<option value="'+ data[i].id_sub_departemen +'">'+ data[i].nama_sub_departemen +'</option>');
                            };
                        } else {
                            $('select[name="id_sub_departemen"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_sub_departemen"]').empty();
            }
        });
    });
</script>

@endsection
