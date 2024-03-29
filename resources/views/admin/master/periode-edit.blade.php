@extends('admin.header')
@section('title', 'Edit Periode - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-7">
            <div class="white-box">
                <h3 class="box-title">EDIT DATA PERIODE</h3>
                <form class="form-horizontal" action="{{ route('periode.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tahun</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_periode" value="{{ $periode->id_periode }}" readonly autocomplete="false">
                            <input type="text" class="form-control" name="tahun" maxlength="20" placeholder="Tahun" value="{{ $periode->tahun }}" required>
                            <input type="hidden" class="form-control" name="original_tahun" maxlength="20" placeholder="Tahun" value="{{ $periode->tahun }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Bulan</label>
                        <div class="col-sm-8">
                            <select id="bulan" class="form-control select2" name="bulan" required>
                                <option value="JANUARI"{{ old('bulan', $periode->bulan)== "JANUARI" ? 'selected':'' }}>Januari</option>
                                <option value="FEBRUARI"{{ old('bulan', $periode->bulan)== "FEBRUARI" ? 'selected':'' }}>Februari</option>
                                <option value="MARET"{{ old('bulan', $periode->bulan)== "MARET" ? 'selected':'' }}>Maret</option>
                                <option value="APRIL"{{ old('bulan', $periode->bulan)== "APRIL" ? 'selected':'' }}>April</option>
                                <option value="MEI"{{ old('bulan', $periode->bulan)== "MEI" ? 'selected':'' }}>Mei</option>
                                <option value="JUNI"{{ old('bulan', $periode->bulan)== "JUNI" ? 'selected':'' }}>Juni</option>
                                <option value="JULI"{{ old('bulan', $periode->bulan)== "JULI" ? 'selected':'' }}>Juli</option>
                                <option value="AGUSTUS"{{ old('bulan', $periode->bulan)== "AGUSTUS" ? 'selected':'' }}>Agustus</option>
                                <option value="SEPTEMBER"{{ old('bulan', $periode->bulan)== "SEPTEMBER" ? 'selected':'' }}>September</option>
                                <option value="OKTOBER"{{ old('bulan', $periode->bulan)== "OKTOBER" ? 'selected':'' }}>Oktober</option>
                                <option value="NOVEMBER"{{ old('bulan', $periode->bulan)== "NOVEMBER" ? 'selected':'' }}>November</option>
                                <option value="DESEMBER"{{ old('bulan', $periode->bulan)== "DESEMBER" ? 'selected':'' }}>Desember</option>
                            </select>
                            <input type="hidden" class="form-control" name="original_bulan" maxlength="20" placeholder="Bulan" value="{{ $periode->bulan }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;";>
                        <label class="col-sm-4 control-label">Minggu Ke</label>
                        <div class="col-sm-8">
                            <select id="minggu_ke" class="form-control select2" name="minggu_ke" required>
                                <option value="1"{{ old('minggu_ke', $periode->minggu_ke)== "1" ? 'selected':'' }}>1</option>
                                <option value="2"{{ old('minggu_ke', $periode->minggu_ke)== "2" ? 'selected':'' }}>2</option>
                                <option value="3"{{ old('minggu_ke', $periode->minggu_ke)== "3" ? 'selected':'' }}>3</option>
                                <option value="4"{{ old('minggu_ke', $periode->minggu_ke)== "4" ? 'selected':'' }}>4</option>
                                <option value="5"{{ old('minggu_ke', $periode->minggu_ke)== "5" ? 'selected':'' }}>5</option>
                            </select>
                            <input type="hidden" class="form-control" name="original_minggu_ke" maxlength="20" placeholder="Minggu Ke" value="{{ $periode->minggu_ke }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tanggal Mulai Periode</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tgl_mulai_periode" maxlength="20" placeholder="Tanggal Mulai Periode" value="{{ $periode->tgl_mulai_periode }}" required>
                            <input type="hidden" class="form-control" name="original_tgl_mulai_periode" maxlength="20" placeholder="Tanggal Mulai Periode" value="{{ $periode->tgl_mulai_periode }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tanggal Akhir Periode</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tgl_akhir_periode" maxlength="20" placeholder="Tanggal Akhir Periode" value="{{ $periode->tgl_akhir_periode }}" required>
                            <input type="hidden" class="form-control" name="original_tgl_akhir_periode" maxlength="20" placeholder="Tanggal Akhir Periode" value=" {{ $periode->tgl_akhir_periode }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/periode"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
