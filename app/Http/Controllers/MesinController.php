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

class MesinController extends Controller
{


    // Menampilkan list mesin
    public function MesinList(){
        // Get all data from database
        $mesin = MesinModel::all();

        return view('admin.master.mesin-list',[
            'menu'  => 'master',
            'sub'   => '/mesin',
            'mesin' => $mesin
        ]);
    }

    // Redirect ke window input mesin
    public function MesinInput(){
        return view('admin.master.mesin-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/mesin'
        ]);
    }

    //Simpan data mesin
    public function SaveMesinData(Request $request){
        $mesin = new MesinModel();

        // Parameters
        $mesin->kode_mesin = strtolower($request->kode_mesin);
        $mesin->nama_mesin = strtoupper($request->nama_mesin);
        $mesin->id_departemen = 0; // nanti diganti
        $mesin->id_sub_departemen = 0; // nanti diganti

        // Check duplicate kode
        $kode_check = DB::select("SELECT kode_mesin FROM vg_list_mesin WHERE kode_mesin = '".$request->kode_mesin."'");
        if (isset($kode_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, kode mesin ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate nama
        $nama_check = DB::select("SELECT nama_mesin FROM vg_list_mesin WHERE nama_mesin = '".$request->nama_mesin."'");
        if (isset($nama_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, nama mesin ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }        


       // Insert data into database
        $mesin->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/mesin');
    }


    // fungsi untuk redirect ke halaman edit
    public function EditMesinData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $machine = MesinModel::find($id);
        
        return view('admin.master.mesin-edit', [
            'menu'  => 'master',
            'sub'   => '/mesin',
            'mesin' => $machine,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditMesinData(Request $request){
        $id_mesin = $request->id_mesin;
        $kode_mesin = strtolower($request->kode_mesin);
        $nama_mesin = strtoupper($request->nama_mesin);
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
 


        // return $request;


        {
            // Update data into database
            MesinModel::where('id_mesin', $id_mesin)->update([
                'kode_mesin'              => $kode_mesin,
                'nama_mesin'              => $nama_mesin,
                'id_departemen'           => 0,
                'id_sub_departemen'        => 0,  
                'updated_at'              => $updated_at,
            ]);
            
            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/mesin');
        }
    } 
    

    // Fungsi hapus data
    public function DeleteMesinData($id){
        $id = Crypt::decryptString($id);
        
        // Select table user to get user default value
        $machine = MesinModel::find($id, ['kode_mesin']);
        
        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back(); 
        }
        {
            // Delete process
            $machine = MesinModel::find($id);
            $machine->delete();

            // Move to department list page
            alert()->success('Berhasil!', 'Berhasil menghapus data!');
            return redirect('/mesin');
        }
    }
}

