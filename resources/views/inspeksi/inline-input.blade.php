@extends('admin.header')
@section('title', 'Input Inspeksi Inline - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-7">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA INSPEKSI INLINE</h3>
                <form id="inline_data" class="form-horizontal" action="{{ route('inline.save') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Tanggal</label></div>
                        <div class="col-sm-4">
                            @if(isset($id_header))
                                <input id="id_header" type="hidden" class="form-control" name="id_inspeksi_header" value="{{ $id_header }}">
                                @if(isset($id_departemen))
                                    <input type="hidden" class="form-control" name="id_departemen_ori" value="{{ $id_departemen }}">
                                @endif

                                @if(isset($shift))
                                    <input type="hidden" class="form-control" name="shift_ori" value="{{ $shift }}">
                                @endif

                                @if(isset($id_sub_departemen))
                                    <input type="hidden" class="form-control" name="id_sub_departemen_ori" value="{{ $id_sub_departemen }}">
                                @endif
                            @endif

                            @if(isset($tgl_inspeksi))
                                <input type="date" class="form-control" name="tgl_inspeksi" value="{{ $tgl_inspeksi }}" style="background-color: #f4f4f4;" readonly>
                            @else
                                <input type="date" class="form-control" name="tgl_inspeksi" value="{{ date('Y-m-d') }}" autofocus required>
                            @endif
                        </div>
                        <div class="col-sm-2 control-label"><label>Shift</label></div>
                        <div class="col-sm-4">
                            @if (isset($shift))
                                <select type="text" class="form-control select2" name="shift" id="shift" style="background-color: #f4f4f4;" disabled>
                                    <option value="">Pilih Shift</option>
                                    <option value="A" {{ old('shift', $shift) == "A" ? 'selected':''}}>A</option>
                                    <option value="B" {{ old('shift', $shift) == "B" ? 'selected':''}}>B</option>
                                    <option value="C" {{ old('shift', $shift) == "C" ? 'selected':''}}>C</option>
                                </select>
                            @else
                                <select type="text" class="form-control select2" name="shift" id="shift" required>
                                    <option value="" selected>Pilih Shift</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Dept.</label></div>
                        <div class="col-sm-4">
                            @if(isset($id_departemen))
                            <select class="form-control select2" name="id_departemen" id="id_departemen" style="background-color: #f4f4f4;" disabled>
                            @else
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @endif
                                <option value="">Pilih Area Inspeksi</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($id_departemen))
                                        <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2 control-label"><label>Sub</label></div>
                        <div class="col-sm-4">
                            @if(isset($id_sub_departemen))
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" style="background-color: #f4f4f4;" disabled>
                            @else
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen">
                            @endif
                                <option value="0">Pilih Bagian Inspeksi</option>
                                @if(isset($id_sub_departemen))
                                    @foreach ($subdepartemen as $subdept)
                                        <option value="{{ $subdept->id_sub_departemen }}" {{ old('id_sub_departemen', $id_sub_departemen) == $subdept->id_sub_departemen ? 'selected':''}}>{{ $subdept->nama_sub_departemen }}</option>
                                    @endforeach
                                @else
                                    {{-- <option value="{{ $subdept->id_sub_departemen }}">{{ $subdept->nama_sub_departemen }}</option> --}}
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Mesin</label></div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="id_mesin" id="id_mesin" required>
                                <option value="0">Pilih Mesin</option>
                                @if(isset($mesin))
                                    @foreach ($mesin as $machine)
                                        <option value="{{ $machine->id_mesin }}">{{ $machine->nama_mesin }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2 control-label"><label>Qty/Mnt</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_1" maxlength="3" min="0" placeholder="Qty/Mnt">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Mulai</label></div>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" onblur="checkHours(event)" required>
                        </div>
                        <div class="col-sm-2 control-label"><label>Selesai</label></div>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" onblur="checkHours(event)" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>PIC</label></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="pic" maxlength="120" placeholder="PIC (Operator)">
                        </div>
                    </div>

                    <br>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>JOP</label></div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="jop" id="jop" maxlength="8" onblur="GetJOPData()" placeholder="JOP" required>
                        </div>

                        <div class="col-sm-2">
                            <button type="button" onclick="clearJOPData()" id="clearjop" class="btn btn-danger pull-left waves-effect waves-light m-r-10" style="visibility: hidden">Clear</button>
                        </div>

                        <div class="col-sm-2 control-label"><label>Item</label></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="item" id="item" maxlength="200" placeholder="Nama Item" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Defect</label></div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="id_defect" id="id_defect">
                                <option value="0">Pilih Defect</option>
                                @if(isset($defect))
                                    @foreach ($defect as $def)
                                        <option value="{{ $def->id_defect }}">{{ $def->defect }}</option>
                                    @endforeach
                                @else
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2 control-label"><label>Kriteria</label></div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="kriteria" id="kriteria">
                                <option value="0">Pilih Kriteria</option>
                                @if(isset($kriteria))
                                    @foreach ($kriteria as $krit)
                                        <option value="{{ $krit->kriteria }}" {{ old('kriteria', $kriteria) == $krit->kriteria ? 'selected':''}}>{{ $krit->kriteria }}</option>
                                    @endforeach
                                @else

                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Qty Temuan</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_defect" maxlength="6" min="0" placeholder="Qty Temuan">
                        </div>

                        <div class="col-sm-2 control-label"><label>Brg Siap</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_ready_pcs" maxlength="6" min="0" placeholder="Qty Siap">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Qty Sample</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_sampling" maxlength="6" min="0" placeholder="Qty Sample" required>
                        </div>



                        <div class="col-sm-2 control-label"><label>UofM</label></div>
                        <div class="col-sm-4">
                            @if(isset($id_satuan))
                            <select class="form-control select2" name="satuan_qty_temuan" id="satuan_qty_temuan" style="background-color: #f4f4f4;" disabled>
                            @else
                            <select class="form-control select2" name="satuan_qty_temuan" id="satuan_qty_temuan" required>
                            @endif
                                <option>Satuan</option>
                                @foreach ($satuan as $sat)
                                    @if(isset($id_satuan))
                                        <option value="{{ $sat->kode_satuan }}" {{ old('kode_satuan', $sat->kode_satuan) == $sat->kode_satuan ? 'selected':''}}>{{ $sat->kode_satuan }}</option>
                                    @else
                                        <option value="{{ $sat->kode_satuan }}" {{ old('kode_satuan', $sat->kode_satuan) == 'PCS'  ? 'selected':''}}>{{ $sat->kode_satuan }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Penyebab</label></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="penyebab" maxlength="200" placeholder="Penyebab">
                        </div>

                        <div class="col-sm-2 control-label"><label>Status</label></div>
                        <div class="col-sm-4">
                            <select id="status" class="form-control select2" name="status" id="status" maxlength="50" required>
                                <option value="">Pilih Status</option>
                                <option value="OK">OK</option>
                                <option value="Hold">Hold</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:5px;">
                        <div class="col-sm-2 control-label"><label>Ket.</label></div>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="2" name="keterangan" placeholder="Keterangan" autocomplete="false"></textarea>
                        </div>

                        <div class="col-sm-2 control-label"><label></label></div>
                        <div class="col-sm-4">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:5px;">
                        <label class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" id="input-file-now-custom-2" name="picture_1" style="margin-bottom:5px;" />
                            <input type="file" id="input-file-now-custom-2" name="picture_2" style="margin-bottom:5px;" />
                            <input type="file" id="input-file-now-custom-2" name="picture_3" style="margin-bottom:5px;" />
                            <input type="file" id="input-file-now-custom-2" name="picture_4" style="margin-bottom:5px;" />
                            <input type="file" id="input-file-now-custom-2" name="picture_5" style="margin-bottom:5px;" />
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:5px;">
                        <label class="col-sm-2 control-label">Video</label>
                        <div class="col-sm-10">
                            <input type="file" id="input-file-now-custom-2" name="video_1" style="margin-bottom:5px;" />
                            <input type="file" id="input-file-now-custom-2" name="video_2" style="margin-bottom:5px;" />
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label></label></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" onclick="CheckingValue()">Submit</button>
                            <button type="button" onclick="resetdata()" value="reset" class="btn btn-warning waves-effect waves-light m-r-10">Reset</button>
                            {{-- <a href="/inline-input"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">DRAFT INSPEKSI</h3>
                <label class="form-inline">Show
                    <select id="demo-show-entries" class="form-control input-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select> entries
                </label>

                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="5">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Tgl</th>
                            <th data-hide="phone">Shift</th>
                            <th data-hide="phone">Area</th>
                            <th>JOP</th>
                            <th data-hide="phone">Status</th>
                            <th data-hide="all">Item</th>
                            <th data-hide="all">Mesin</th>
                            <th data-hide="all">Output/1 mnt</th>
                            <th data-hide="all">PIC</th>
                            <th data-hide="all">Jam Mulai</th>
                            <th data-hide="all">Jam Selesai</th>
                            <th data-hide="all">Lama Inspeksi</th>
                            <th data-hide="all">Kendala</th>
                            <th data-hide="all">Kriteria</th>
                            <th data-hide="all">Jml Temuan</th>
                            <th data-hide="all">Brg Siap</th>
                            <th data-hide="all">Jml Sampling</th>
                            <th data-hide="all">Penyebab</th>
                            <th data-hide="all">Keterangan</th>
                            <th data-hide="all">Foto</th>
                            <th data-hide="all">Video</th>
                            <th data-hide="phone">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($draft))
                            @foreach($draft as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td id="tgl_inspeksi">{{ $d->tgl_inspeksi }}</td>
                                    <td>{{ $d->shift }}</td>
                                    <td>{{ $d->nama_departemen }} - {{ $d->nama_sub_departemen }}</td>
                                    <td>{{ $d->jop }}</td>
                                    <td>{{ $d->status }}</td>
                                    <td>{{ $d->item }}</td>
                                    <td>{{ $d->nama_mesin }}</td>
                                    <td>{{ $d->qty_1 }}</td>
                                    <td>{{ $d->pic }}</td>
                                    <td>{{ $d->jam_mulai }}</td>
                                    <td>{{ $d->jam_selesai }}</td>
                                    <td>{{ $d->lama_inspeksi }} Menit</td>
                                    <td>{{ $d->defect }}</td>
                                    <td>{{ $d->kriteria }}</td>
                                    <td>{{ $d->qty_defect }} {{ $d->satuan_qty_temuan }}</td>
                                    <td>{{ $d->qty_ready_pcs }} {{ $d->satuan_qty_temuan }}</td>
                                    <td>{{ $d->qty_sampling }} {{ $d->satuan_qty_temuan }}</td>
                                    <td>{{ $d->penyebab }}</td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td>
                                        @if(isset($d->picture_1))
                                            <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_1 }}" width="200">Picture 1</a>
                                        @endif

                                        @if(isset($d->picture_2))
                                            / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_2 }}" width="200">Picture 2</a>
                                        @endif

                                        @if(isset($d->picture_3))
                                            / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_3 }}" width="200">Picture 3</a>
                                        @endif

                                        @if(isset($d->picture_4))
                                            / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_4 }}" width="200">Picture 4</a>
                                        @endif

                                        @if(isset($d->picture_5))
                                            / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_5 }}" width="200">Picture 5</a>
                                        @endif

                                        @if((isset($d->picture_1)) || (isset($d->picture_2)) || (isset($d->picture_3)) || (isset($d->picture_4)) || (isset($d->picture_5)))
                                            | <button alt="default" data-toggle="modal" data-target="#myModal" onclick="checkPic('{{ $d->picture_1 }}','{{ $d->picture_2 }}', '{{ $d->picture_3 }}', '{{ $d->picture_4 }}', '{{ $d->picture_5 }}')">Lihat</button>
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($d->video_1))
                                            <a target="_blank" href="{{ url('/') }}/videos/defect/{{ $d->video_1 }}" width="200">Video 1</a>
                                        @endif

                                        @if(isset($d->video_2))
                                            / <a target="_blank" href="{{ url('/') }}/videos/defect/{{ $d->video_2 }}" width="200">Video 2</a>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($d->id_inspeksi_detail) }}')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <button type="button" class="btn btn-info waves-effect pull-right waves-light" onclick="postConfirmation()">POST</i></button>
                </table>

                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Preview Gambar Temuan</h4> </div>
                            <div class="modal-body">
                                <div class="panel-wrapper p-b-10 collapse in">
                                    <div id="owl-demo" class="owl-carousel owl-theme">
                                        <div class="item"><img src="" id="img_1" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_2" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_3" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_4" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_5" style="max-width: 100%;" alt="Owl Image"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- end container-fluid -->

<!-- sample modal content -->
<div id="JOPModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">JOP Edar List</h4>
            </div>

            <div class="modal-body">
                <div class="table-responsive" style="height: 50%">
                    <table class="table table-hover" id="joplist">
                        <thead>
                            <tr>
                                <th>JOP</th>
                                <th>Item</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('admin.footer')

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="id_departemen"]').on('change', function() {
            var departemenID = $(this).val();
            if(departemenID) {
                $.ajax({
                    url: '/users-sub/'+departemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_sub_departemen"]').empty();
                            $('select[name="id_sub_departemen"]').append('<option value="0" selected>Pilih Bagian Inspeksi</option>');
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

        $('select[name="id_sub_departemen"]').on('change', function() {
            var subDepartemenID = $(this).val();
            if(subDepartemenID) {
                $.ajax({
                    url: '/mesin-dropdown/'+subDepartemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_mesin"]').empty();
                            $('select[name="id_mesin"]').append('<option value="0" selected>Pilih Mesin</option>');
                            // Remove options
                            $('#id_mesin').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_mesin"]').append('<option value="'+ data[i].id_mesin +'">'+ data[i].nama_mesin +'</option>');
                            };
                        } else {
                            $('select[name="id_mesin"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_mesin"]').empty();
            }
        });

        $('select[name="id_departemen"]').on('change', function() {
            var departemenID = $(this).val();
            if(departemenID) {
                $.ajax({
                    url: '/defect-dropdown/'+departemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_defect"]').empty();
                            $('select[name="id_defect"]').append('<option value="0" selected>Pilih Defect</option>');
                            // Remove options
                            $('#id_defect').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_defect"]').append('<option value="'+ data[i].id_defect +'">'+ data[i].defect +'</option>');
                            };
                        } else {
                            $('select[name="id_defect"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_defect"]').empty();
            }
        });

        $('select[name="id_defect"]').on('change', function() {
            var defectID = $(this).val();
            if(defectID) {
                $.ajax({
                    url: '/kriteria-dropdown/'+defectID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="kriteria"]').empty();
                            $('select[name="kriteria"]').append('<option value="0" selected>Pilih Kriteria</option>');
                            // Remove options
                            $('#kriteria').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="kriteria"]').append('<option value="'+ data[i].kriteria +'">'+ data[i].kriteria +'</option>');
                            };
                        } else {
                            $('select[name="kriteria"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="kriteria"]').empty();
            }
        });
});

    function deleteConfirmation(id) {
        var urlsite = "http://"+window.location.hostname+':8000/inline-delete/'+id;
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                if (result.isConfirmed) {
                    location.replace(urlsite);
                }
            }
        })
    };


    function postConfirmation() {
        var urlsite = "http://"+window.location.hostname+':8000/inline-post/';
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menginput data ini?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Input Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                if (result.isConfirmed) {
                    location.replace(urlsite);
                }
            }
        })
    };

    function checkHours(e){
        var sh = $("#jam_mulai").val();
        var eh = $("#jam_selesai").val();
        t1 = parseInt(sh.slice(0,2));
        t2 = parseInt(sh.slice(3,5));
        cek_jam = parseInt(sh.slice(0,2));
        cek_menit = parseInt(sh.slice(3,5));

        cek_menit2 = parseInt(sh.slice(3,4));
        cek_jam2 = parseInt(eh.slice(0,2));
        t3 = parseInt(eh.slice(0,2));
        t4 = parseInt(eh.slice(3,5));

        // if (cek_jam == "23" && cek_menit2 == "5" && cek_jam2 == "00") {
        //     t3 = "24";
        // }

        if (cek_menit == 59){
            t1 = t1+1;
            t2 = "00";
        } else {
            t2 = t2+1;
        }

        if (cek_jam < 10 ){
            t1 = "0"+t1;
        }

        if (cek_menit < 10 ){
            t2 = "0"+t2;
        }

        var stt = new Date("November 13, 2013 " + sh);
        stt = stt.getTime();

        var endt = new Date("November 13, 2013 " + eh);
        endt = endt.getTime();

        if (t1 == 23 && t2 > 30 ) {

        } else if (stt >= endt) {
            alert('Jam Selesai harus lebih besar dari Jam Mulai');
            document.getElementById("jam_selesai").value = t1+":"+t2;
            document.getElementById("jam_selesai").focus();
        }
    }

    function loadHours() {
        const event = new Date();
        var h = event.getHours();
        var m = event.getMinutes();
        var m2 = event.getMinutes();

        m2 = m2+2;

        if (h < 10) {
            h = "0"+h;
        }

        if (m < 10) {
            m = "0"+m;
        }

        if (m2 < 10) {
            m2 = "0"+m2;
        }


        document.getElementById("jam_mulai").value = h+":"+m;
        document.getElementById("jam_selesai").value = h+":"+m2;
    }

    function resetdata() {
        document.getElementById("inline_data").reset();
        $("select.select2").select2({ allowClear: true });
    }

    function checkPic(pic_1, pic_2, pic_3, pic_4, pic_5){
        var p1 = pic_1;
        var p2 = pic_2;
        var p3 = pic_3;
        var p4 = pic_4;
        var p5 = pic_5;

        if (p1 == '') {
            p1 = 'Blank.jpg';
        }

        if (p2 == '') {
            p2 = 'Blank.jpg';
        }

        if (p3 == '') {
            p3 = 'Blank.jpg';
        }

        if (p4 == '') {
            p4 = 'Blank.jpg';
        }

        if (p5 == '') {
            p5 = 'Blank.jpg';
        }

        $("#img_1").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p1);
        $("#img_2").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p2);
        $("#img_3").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p3);
        $("#img_4").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p4);
        $("#img_5").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p5);
    }
</script>

<script>
    if ( window.history.replaceState ) {
       window.history.replaceState( null, null, window.location.href );
    }

    function CheckingValue() {
        var shift   = $('#shift').select2('val');
        var dept    = $('#id_departemen').select2('val');
        var sub     = $('#id_sub_departemen').select2('val');
        var msn     = $('#id_mesin').select2('val');
        var def     = $('#id_defect').select2('val');
        var krt     = $('#kriteria').select2('val');
        var sat     = $('#satuan_qty_ready_pcs').select2('val');
        var sts     = $('#status').select2('val');

        if(shift == ''){
            alert('Data shift tidak boleh kosong!')
            return $('#shift').select2('open');
        }

        if(dept == ''){
            alert('Data departemen tidak boleh kosong!')
            return $('#id_departemen').select2('open');
        }

        if(sub == ''){
            alert('Data sub departemen tidak boleh kosong!')
            return $('#id_sub_departemen').select2('open');
        }

        if(msn == ''){
            alert('Data mesin tidak boleh kosong!')
            return $('#id_mesin').select2('open');
        }

        // if(def == ''){
        //     alert('Data defect tidak boleh kosong!')
        //     return $('#id_defect').select2('open');
        // }

        // if(krt == '' || krt == '0'){
        //     alert('Data kriteria tidak boleh kosong!')
        //     return $('#kriteria').select2('open');
        // }

        if(sat == ''){
            alert('Data satuan tidak boleh kosong!')
            return $('#satuan_qty_ready_pcs').select2('open');
        }

        if(sts == ''){
            alert('Data status tidak boleh kosong!')
            return $('#status').select2('open');
        }
    }
</script>

<script>
    $(document).ready(function(){
        var dept    = $('#id_departemen').select2('val');

        if(dept == '' && $('#tgl_inspeksi').length){
            $("#inline_data :input").prop("disabled", true);

            $('.select2').css('background-color', '#f1f1f1');
        }
    });

    function GetJOPData() {
        var text = document.getElementById('jop').value;

        $.ajax({
            url: "http://"+window.location.hostname+":8000/jop-search/"+text, //please always check the suitable of url that will be use
            type: 'get',
            dataType: 'json',
            success: function(response){
                var len = 0;
                    $('#joplist tbody').empty(); // Empty <tbody>
                    if(response['data'] != null){
                    len = response['data'].length;
                }

                if(len > 0){
                    for(var i=0; i<len; i++){
                    var jop = response['data'][i].jop;
                    var nama_barang = response['data'][i].nama_barang;
                    var pname = nama_barang .split(' ').join('_');

                    var tr_str = "<tr onclick=setJOPField('" + jop.trim() + "','"+pname.trim()+"')>" +
                        "<td align='left' id='code_value'>" + jop + "</td>" +
                        "<td align='left' id='name_value'>" + nama_barang + "</td>" +
                    "</tr>";
                    $("#joplist tbody").append(tr_str);
                    }
                } else{
                    var tr_str = "<tr>" +
                    "<td align='center' colspan='3'>Tidak ada data.</td>" +
                    "</tr>";

                    $("#joplist tbody").append(tr_str);
                    document.getElementById('item').focus();
                }
                $('#JOPModal').modal('show');
            }
        });
    }

    function setJOPField(code,name){
        pname = name.split('_').join(' ');
        document.getElementById('jop').value = code; // Set value for product code field
        document.getElementById('item').value = pname; // Set value for product name field
        $('#JOPModal').modal('hide');
        document.getElementById('clearjop').style.visibility = 'visible';

        // Set Readonly field - on
        $("#jop").prop('readonly', true);
        $("#item").prop('readonly', true);

        //Set Autocomplete field - off
        $("#jop").prop('autocomplete', false);
        $("#item").prop('autocomplete', false);
    }

    function clearJOPData(){
        document.getElementById('jop').value = '';
        document.getElementById('item').value = '';
        document.getElementById('clearjop').style.visibility = 'hidden';

        // Set Readonly field - on
        $("#jop").prop('readonly', false);
        $("#item").prop('readonly', false);

        document.getElementById('jop').focus();
    }
</script>

@endsection
