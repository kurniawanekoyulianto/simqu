<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\MesinModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\SatuanController;

class MesinController extends Controller
{
    public static function GetOraMesin(){
        //Get data from REST API
		$host = DB::table("tb_master_host")->orderBy('id_host', 'desc')->first();
        $request = Http::get($host->host.'/api/mchn');// Url of your choosing
        $x = count(json_decode($request, true));

        DB::select("DELETE from tb_tmp_mesin");

        // insert data to database postgres
        for ($i = 0; $i < $x; $i++) {
            $id_mesin           = $request[$i]['id_mesin'];
            $id_departemen      = $request[$i]['id_departemen'];
            $id_subdepartemen   = $request[$i]['id_subdepartemen'];
            $kode_mesin         = $request[$i]['kode_mesin'];
            $nama_mesin         = $request[$i]['nama_mesin'];

            //insert into database master
            DB::select("INSERT INTO tb_master_mesin (id_mesin, id_departemen, id_sub_departemen, kode_mesin, nama_mesin)
            VALUES (".$id_mesin.", '".$id_departemen."', '".$id_subdepartemen."', '".$kode_mesin."', '".$nama_mesin."') ON CONFLICT (id_mesin) DO UPDATE SET id_departemen = excluded.id_departemen, id_sub_departemen = excluded.id_sub_departemen, kode_mesin = excluded.kode_mesin, nama_mesin = excluded.nama_mesin");

            // insert into temp
            DB::select("INSERT INTO tb_tmp_mesin (id_mesin, id_departemen, id_sub_departemen, kode_mesin, nama_mesin)
            VALUES (".$id_mesin.", '".$id_departemen."', '".$id_subdepartemen."', '".$kode_mesin."', '".$nama_mesin."') ON CONFLICT (id_mesin) DO UPDATE SET id_departemen = excluded.id_departemen, id_sub_departemen = excluded.id_sub_departemen, kode_mesin = excluded.kode_mesin, nama_mesin = excluded.nama_mesin");
        }
    }

    // Menampilkan list mesin
    public function MesinList(){
        // Call function Ora Database
        $this->GetOraMesin();
        (new DepartmentController)->GetOraDepartemen();
        (new SubDepartmentController)->GetOraSubdepartemen();
        (new SatuanController)->GetOraSatuan();

        // Get all data from database
        $mesin = DB::select('SELECT * FROM vg_list_mesin');
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        return view('admin.master.mesin-list',[
            'menu'          => 'master',
            'sub'           => '/mesin',
            'mesin'         => $mesin,
            'jenis_user'    => $jenis_user
        ]);
    }

    public function getSubDepartemen($id){
        $sub_departemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM tb_master_sub_departemen WHERE id_departemen = ".$id);
        return json_encode($sub_departemen);
    }

    public function getSubMesin($id){
        $mesin = DB::select("SELECT id_mesin, nama_mesin FROM tb_master_mesin WHERE id_sub_departemen = ".$id);
        return json_encode($mesin);
    }

    // // Redirect ke window input mesin
    // public function MesinInput(){
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     if($jenis_user <> "Administrator"){
    //         alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
    //         return Redirect('/');
    //     }

    //     return view('admin.master.mesin-input',[
    //         'departemen'    => $departemen,
    //         'subdepartemen' => $subdepartemen,
    //         'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //         'sub'           => '/mesin',
    //         'jenis_user'    => $jenis_user
    //     ]);
    // }

    // //Simpan data mesin
    // public function SaveMesinData(Request $request){
    //     $mesin = new MesinModel();
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     // Parameters
    //     $mesin->id_departemen = $request->id_departemen;
    //     $mesin->id_sub_departemen = $request->id_sub_departemen;
    //     $mesin->kode_mesin = strtoupper($request->kode_mesin);
    //     $mesin->nama_mesin = strtoupper($request->nama_mesin);

    //     $sub_dept = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen WHERE id_departemen = '.$mesin->id_departemen);

    //     // Validation data input
    //     if ($request->id_departemen == "0" || $request->id_sub_departemen =="0"){
    //         alert()->error('Gagal Input Data!', 'Maaf, Ada Kesalahan Penginputan Data!');
    //         return view('admin.master.mesin-input',[
    //             'departemen'    => $departemen,
    //             'subdepartemen' => $subdepartemen,
    //             'sub_dept'      => $sub_dept,
    //             'select'        => $mesin,
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'sub'           => '/mesin',
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //     // Check duplicate kode
    //     $kode_check = DB::select("SELECT kode_mesin FROM vg_list_mesin WHERE kode_mesin = '".$mesin->kode_mesin."'");
    //     if (isset($kode_check['0'])) {
    //         alert()->error('Gagal Menyimpan!', 'Maaf, Kode Mesin Ini Sudah Didaftarkan Dalam Sistem!');
    //         return view('admin.master.mesin-input',[
    //             'departemen'    => $departemen,
    //             'subdepartemen' => $subdepartemen,
    //             'sub_dept'      => $sub_dept,
    //             'select'        => $mesin,
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'sub'           => '/mesin',
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //     // Check duplicate nama
    //     $nama_check = DB::select("SELECT nama_mesin FROM vg_list_mesin WHERE nama_mesin = '".$mesin->nama_mesin."'");
    //     if (isset($nama_check['0'])) {
    //         alert()->error('Gagal Menyimpan!', 'Maaf, Nama Mesin Ini Sudah Didaftarkan Dalam Sistem!');
    //         return view('admin.master.mesin-input',[
    //             'departemen'    => $departemen,
    //             'subdepartemen' => $subdepartemen,
    //             'sub_dept'      => $sub_dept,
    //             'select'        => $mesin,
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'sub'           => '/mesin',
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }


    //    // Insert data into database
    //     $mesin->save();
    //         alert()->success('Berhasil!', 'Data Sukses Disimpan!');
    //         return redirect('/mesin');
    // }


    // // fungsi untuk redirect ke halaman edit
    // public function EditMesinData($id){
    //     $id = Crypt::decrypt($id);
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     if($jenis_user <> "Administrator"){
    //         alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
    //         return Redirect('/');
    //     }

    //     // Select data based on ID
    //     $machine = MesinModel::find($id);

    //     return view('admin.master.mesin-edit', [
    //         'menu'          => 'master',
    //         'sub'           => '/mesin',
    //         'mesin'         => $machine,
    //         'departemen'    => $departemen,
    //         'subdepartemen' => $subdepartemen,
    //         'jenis_user'    => $jenis_user
    //     ]);
    // }

    // // simpan perubahan dari data yang sudah di edit
    // public function SaveEditMesinData(Request $request){
    //     $id_mesin = $request->id_mesin;
    //     $id_departemen = $request->id_departemen;
    //     $id_sub_departemen = $request->id_sub_departemen;
    //     $kode_mesin = strtoupper($request->kode_mesin);
    //     $nama_mesin = strtoupper($request->nama_mesin);
    //     $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     // Select data based on ID
    //     $machine = MesinModel::find($id_mesin);

    //     // is there a change in nama mesin data?
    //     if ($request->nama_mesin <> $request->original_nama_mesin){
    //      // Check duplicate nama
    //      $nama_check = DB::select("SELECT nama_mesin FROM vg_list_mesin WHERE nama_mesin = '".$nama_mesin."'");
    //      if (isset($nama_check['0'])) {
    //          alert()->error('Gagal Menyimpan!', 'Maaf, Nama Mesin Ini Sudah Didaftarkan Dalam Sistem!');

    //          return view('admin.master.mesin-edit', [
    //             'menu'          => 'master',
    //             'sub'           => '/mesin',
    //             'mesin'         => $machine,
    //             'departemen'    => $departemen,
    //             'subdepartemen' => $subdepartemen,
    //             'jenis_user'    => $jenis_user
    //         ]);

    //         } else {
    //             //update data into database
    //             MesinModel::where('id_mesin', $id_mesin)->update([
    //                'kode_mesin'              => $kode_mesin,
    //                'nama_mesin'              => $nama_mesin,
    //                'id_departemen'           => $id_departemen,
    //                'id_sub_departemen'       => $id_sub_departemen,
    //                'updated_at'              => $updated_at,
    //             ]);
    //             alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
    //             return redirect('/mesin');
    //         }

    //     } else {
    //         // Update data into database
    //         MesinModel::where('id_mesin', $id_mesin)->update([
    //             'kode_mesin'              => $kode_mesin,
    //             'nama_mesin'              => $nama_mesin,
    //             'id_departemen'           => $id_departemen,
    //             'id_sub_departemen'       => $id_sub_departemen,
    //             'updated_at'              => $updated_at,
    //         ]);

    //         alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
    //         return redirect('/mesin');
    //     }
    // }


    //  // Fungsi hapus data
    //  public function DeleteMesinData($id){
    //     $id = Crypt::decryptString($id);
    //     $jenis_user = session()->get('jenis_user');

    //     // Select table user to get user default value
    //     $machine = MesinModel::find($id, ['kode_mesin']);

    //     $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
    //     // Check user already used in other table or not yet
    //     if (isset($creator_check[0])) {
    //         Alert::error("Gagal!", 'Data Ini Tidak Dapat Dihapus Karena Sudah Dipakai Tabel Lain!');
    //         return Redirect::back();
    //     } else {
    //         // Delete process
    //         $machine = MesinModel::find($id);
    //         $machine->delete();

    //         // Move to users list page
    //         alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
    //         return redirect('/mesin');
    //     }
    //  }
}
