<?php

namespace App\Http\Controllers;

use App\Asassment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsassmentController extends Controller
{

    //GET ALL RAW
    public function index(){

        return Asassment::all();
    
    }

    //GET ALL COUNT
    public function allcount(){
        $data = Asassment::count();
          return [
            'countall' => $data,
        ];
    }

    public function select($id){

        if (is_numeric($id))
        {
            // $authorModel = Asassment::find($id);

            $column = 'id'; // This is the name of the column you wish to search
     
            $authorModel = Asassment::where($column , '=', $id)->get();

            // $authorModel = Asassment::where($column,'LIKE',"%{$id}%")
            //                 ->get();
        }
        else
        {
            $column = 'kab'; // This is the name of the column you wish to search
     
            $authorModel = Asassment::where($column,'LIKE',"%{$id}%")
                            ->orWhere('kec', 'LIKE',"%{$id}%")
                            ->orWhere('alamat', 'LIKE',"%{$id}%")
                            ->orWhere('nama', 'LIKE',"%{$id}%")
                            ->orWhere('sektor', 'LIKE',"%{$id}%")
                            ->orWhere('kewenangan', 'LIKE',"%{$id}%")
                            ->orWhere('tingkat', 'LIKE',"%{$id}%")
                            ->get();

            // $authorModel = Asassment::where($column , '=', $id)->get();
            // $dataku = array('nama' => $authorModel[0]->nama, 'alamat' => $authorModel[0]->alamat);


        }

        return $authorModel;

        // return [
        //     'status' => "success",
        //     'data' => [
        //         'posts' => $authorModel
        //     ]
        // ];

    }

    public function countkerusakanbykab(){

        $collection = Asassment::groupBy('kab')
                                 ->selectRaw('count(*) as total, kab')
                                ->get();

        return response()->json($collection);

    }

    public function countkerusakanbykec(){

        $collection = Asassment::groupBy('kec')
                                 ->selectRaw('count(*) as total, kec')
                                ->get();

        return response()->json($collection);

    }

    public function tingkatdikab(){

        $sedang = Asassment::groupBy('kab')
        ->where('tingkat','LIKE',"Sedang")
        ->orderBy('kab', 'desc')
        ->selectRaw('count(*) as total, kab')
       ->get();

       $ringan = Asassment::groupBy('kab')
        ->where('tingkat','LIKE',"Ringan")
        ->orderBy('kab', 'desc')
        ->selectRaw('count(*) as total, kab')
       ->get();

       $berat = Asassment::groupBy('kab')
        ->where('tingkat','LIKE',"Berat")
        ->orderBy('kab', 'desc')
        ->selectRaw('count(*) as total, kab')
       ->get();

       return [
        'ringan' => $ringan,
        'sedang' => $sedang,
        'berat' => $berat
    ];

    }

    public function countstatus(){

           // COUNT ALL status
           $statusall = Asassment::groupBy('status')
           ->selectRaw('count(*) as total, status')
          ->get();
   
   //COUNT ALL status per kec
   $statuskec = Asassment::groupBy('status', 'kec')
   ->where('status','LIKE',"Diterima")
   ->orderBy('kec', 'desc')
   ->selectRaw('count(*) as total, status, kec')
   ->get();

   $statuskecpen = Asassment::groupBy('status', 'kec')
   ->where('status','LIKE',"Pending")
   ->orderBy('kec', 'desc')
   ->selectRaw('count(*) as total, status, kec')
   ->get();
   
   //COUNT ALL status per kab
   $statuskab = Asassment::groupBy('status', 'kab')
   ->where('status','LIKE',"Diterima")
   ->orderBy('kab', 'desc')
   ->selectRaw('count(*) as total, status, kab')
   ->get();

   $statuskabpen = Asassment::groupBy('status', 'kab')
   ->where('status','LIKE',"Pending")
   ->orderBy('kab', 'desc')
   ->selectRaw('count(*) as total, status, kab')
   ->get();
   

   return [
    'statusall' => $statusall,
    'statuskec' => $statuskec,
    'statuskecpen' => $statuskecpen,
    'statuskab' => $statuskab,
    'statuskabpen' => $statuskabpen,
];


//    return response()->json($collection);


    }

    public function countharga(){
        // COUNT ALL 
        $statussemua = Asassment::selectRaw('SUM(harga) as total')
       ->get();

// return [
//  'statusall' => $statussemua,
//  'statuskab' => $statuskab,
//  'statuskec' => $statuskec,
// ];

return response()->json($statussemua);

 }

 public function counthargakec(){
    // COUNT ALL kec
    $statuskec = Asassment::groupBy('kec')
    ->selectRaw('SUM(harga) as total, kec')
   ->get();


return response()->json($statuskec);

}

public function counthargakab(){

    // COUNT ALL kab
    $statuskab = Asassment::groupBy('kab')
    ->selectRaw('SUM(harga) as total, kab')
   ->get();

return $statuskab;

}

     
    public function counttingkatkerusakanbyperkec(){

        $collection = Asassment::groupBy('tingkat', 'kec')
        ->selectRaw('count(*) as total, tingkat, kec')
        ->get();

        return response()->json($collection);

    }

    public function counttingkatkerusakanbyperkab(){
        $collection = Asassment::selectRaw('count(*) as total, tingkat, kab')
        ->groupBy('tingkat', 'kab')
        ->get();
    //    $collection = Asassment::groupBy('tingkat')
    //     ->where('kab','=',"Lombok Timur")
    //     ->selectRaw('count(*) as total, tingkat')
    //    ->get();
        return response()->json($collection);
    }

    public function countstatusperkab(){

        $pending = Asassment::selectRaw('count(*) as total, status, kab')
        ->orderBy('kab', 'desc')
        ->where('status','LIKE',"Pending")
        ->groupBy('status', 'kab')
        ->get();

        $diterima = Asassment::selectRaw('count(*) as total, status, kab')
        ->orderBy('kab', 'desc')
        ->where('status','LIKE',"Diterima")
        ->groupBy('status', 'kab')
        ->get();
        
        return [
            'pending' => $pending,
            'diterima' => $diterima
        ];
    }

  

    public function countkerusakanbybagian(){
        
                            $column = 'tingkat'; // This is the name of the column you wish to search

                            $pondasi_l = Asassment::Where('pondasi_t', '>','0')
                            ->count();

                            $kolom_l = Asassment::Where('kolom_t', '>','0')
                            ->count();

                            $atap_t = Asassment::Where('atap_t', '>','0')
                            ->count();

                            $langit_l = Asassment::Where('langit_m', '>','0')
                            ->count();

                            $dinding_m = Asassment::Where('dinding_t', '>','0')
                            ->count();

                            $lantai_l = Asassment::Where('lantai_t', '>','0')
                            ->count();

        return [
            'pondasi' => $pondasi_l,
            'kolom' => $kolom_l,
            'atap' => $atap_t,
            'langit' => $langit_l,
            'dinding' => $dinding_m,
            'lantai' => $lantai_l,
        ];

    }

    public function kerugian(){
        
                            $column = 'tingkat'; // This is the name of the column you wish to search

                            $pondasi_l = Asassment::whereNotNull('pondasi_l')
                            ->orwhereNotNull('pondasi_m')
                            ->orwhereNotNull('pondasi_h')
                            ->orwhereNotNull('pondasi_t')
                            ->count();

                            $kolom_l = Asassment::whereNotNull('kolom_l')
                            ->orwhereNotNull('kolom_m')
                            ->orwhereNotNull('kolom_h')
                            ->orwhereNotNull('kolom_t')
                            ->count();

                            $atap_t = Asassment::whereNotNull('atap_t')
                            ->count();

                            $langit_l = Asassment::whereNotNull('langit_l')
                            ->orwhereNotNull('langit_m')
                            ->count();

                            $dinding_m = Asassment::whereNotNull('dinding_m')
                            ->orwhereNotNull('dinding_h')
                            ->orwhereNotNull('dinding_t')
                            ->count();

                            $lantai_l = Asassment::whereNotNull('lantai_l')
                            ->orwhereNotNull('lantai_t')
                            ->count();

        return [
            'pondasi' => $pondasi_l,
            'kolom' => $kolom_l,
            'atap' => $atap_t,
            'langit' => $langit_l,
            'dinding' => $dinding_m,
            'lantai' => $lantai_l,
        ];

    }


    public function countkerusakanbytingkat(){
        
//         $collection = Asassment::groupBy('tingkat')
//         ->selectRaw('count(*) as total, tingkat')
//        ->get();

// return response()->json($collection);

        $column = 'tingkat'; // This is the name of the column you wish to search
     
                            $ringan = Asassment::where($column,'LIKE',"Ringan")
                            // ->groupBy('kec')
                            ->count();
                            $sedang = Asassment::where($column,'LIKE',"Sedang")
                            // ->groupBy('kec')
                            ->count();
                            $berat = Asassment::where($column,'LIKE',"Berat")
                            // ->groupBy('kec')
                            ->count();
        return [
            'ringan' => $ringan,
            'sedang' => $sedang,
            'berat' => $berat,
        ];

    }
    
    public function create(request $request){

        $fpondasi = $request->get('fpondasi');
        $fkolom = $request->get('fkolom');
        $fatap = $request->get('fatap');
        $flangit = $request->get('flangit');
        $fdinding = $request->get('fdinding');
        $flantai = $request->get('flantai');

    //     $filelocfpondasi = null;
    //     $filelocfkolom= null;
    //     $filelocfatap= null;
    //     $filelocflangit= null;
    //    $filelocfdinding= null;
    //     $filelocflantai= null;
        
        
        //   $fpondasi = $request->file('fpondasi');
        //   $fkolom = $request->file('fkolom');
        //   $fatap = $request->file('fatap');
        //   $flangit = $request->file('flangit');
        //   $fdinding = $request->file('fdinding');
        //   $flantai = $request->file('flantai');

 
        //   $pathpondasi = public_path() . '\upload\fpondasi\\';
        //   $pathkolom = public_path() . '\upload\fkolom\\';
        //   $pathatap = public_path() . '\upload\fatap\\';
        //   $pathlangit = public_path() . '\upload\flangit\\';
        //   $pathdinding = public_path() . '\upload\fdinding\\';
        //   $pathlantai = public_path() . '\upload\flantai\\';

        //   $filemd5fpondasi = substr( md5( $fpondasi. '-' . time() ), 0, 15) . '.jpg';
        //   $filemd5fkolom = substr( md5( $fkolom. '-' . time() ), 0, 15) . '.jpg';
        //   $filemd5fatap = substr( md5( $fatap. '-' . time() ), 0, 15) . '.jpg';
        //   $filemd5flangit = substr( md5( $flangit. '-' . time() ), 0, 15) . '.jpg';
        //   $filemd5fdinding = substr( md5( $fdinding. '-' . time() ), 0, 15) . '.jpg';
        //   $filemd5flantai = substr( md5( $flantai. '-' . time() ), 0, 15) . '.jpg';


        
        //   if ($request->hasFile('fpondasi')) {
        //        $filelocfpondasi = $pathpondasi . $filemd5fpondasi;
        //     $fpondasi->move($pathpondasi, $filemd5fpondasi);
        //   }

        //   if ($request->hasFile('fkolom')) {
        //     $filelocfkolom = $pathkolom . $filemd5fkolom;
        //     $fkolom->move($pathkolom, $filemd5fkolom);
        //   }

        //   if ($request->hasFile('fatap')) {
        //     $filelocfatap = $pathatap . $filemd5fatap;
        //     $fatap->move($pathatap, $filemd5fatap);
        //   }

        //   if ($request->hasFile('flangit')) {
        //     $filelocflangit = $pathlangit . $filemd5flangit;
        //     $flangit->move($pathlangit, $filemd5flangit);
        //   }

        //   if ($request->hasFile('fdinding')) {
        //     $filelocfdinding = $pathdinding . $filemd5fdinding;
        //     $fdinding->move($pathdinding, $filemd5fdinding);
        //   }

        //   if ($request->hasFile('flantai')) {
        //     $filelocflantai = $pathlantai . $filemd5flantai;
        //     $flantai->move($pathlantai, $filemd5flantai);
        //   }

        //   $pathcompact =compact('path');

        $kab = $request->get('kab');
        $kec = $request->get('kec');
        $alamat = $request->get('alamat');
        $long = $request->get('long');
        $lot = $request->get('lot');
        $nama = $request->get('nama');
        $sektor = $request->get('sektor');
        $kewenangan = $request->get('kewenangan');
        $luas = $request->get('luas');
        $harga = $request->get('harga');
        $pondasi_l = $request->get('pondasi_l');
        $pondasi_m = $request->get('pondasi_m');
        $pondasi_h = $request->get('pondasi_h');
        $pondasi_t = $request->get('pondasi_t');
        $kolom_l = $request->get('kolom_l');
        $kolom_m = $request->get('kolom_m');
        $kolom_h = $request->get('kolom_h');
        $kolom_t = $request->get('kolom_t');
        $atap_t = $request->get('atap_t');
        $langit_l = $request->get('langit_l');
        $langit_m = $request->get('langit_m');
        $dinding_m = $request->get('dinding_m');
        $dinding_h = $request->get('dinding_h');
        $dinding_t = $request->get('dinding_t');
        $lantai_l = $request->get('lantai_l');
        $lantai_t = $request->get('lantai_t');
        // $tingkat = $request->get('tingkat');

        $b_pondasil = 0;
        $b_pondasim= 0;
        $b_pondasih= 0;
        $b_pondasit= 0;

        $b_koloml= 0;
        $b_kolomm= 0;
        $b_kolomh= 0;
        $b_kolomt= 0;

        $b_atapt= 0;

        $b_langitl= 0;
        $b_langitm= 0;

        $b_dindingm= 0;
        $b_dindingh= 0;
        $b_dindingt= 0;

        $b_lantail= 0;
        $b_lantait= 0;

        $totalkerusakan ='';

        //PONDASI
        if ($pondasi_l >= 3){
            $b_pondasil = 5;
        }else if ($pondasi_l == 0){
            $b_pondasil = 0;
        }
        else{
            $b_pondasil = 3;
        }

        if ($pondasi_m >= 3){
            $b_pondasim = 5;
        }else if ($pondasi_m == 0){
            $b_pondasim = 0;
        }else{
            $b_pondasim = 4;
        }

        if ($pondasi_h >= 3){
            $b_pondasih = 11;
        }else if ($pondasi_h == 0){
            $b_pondasih = 0;
        }else{
            $b_pondasih = 8;
        }

        if ($pondasi_t >= 3){
            $b_pondasit = 15;
        }else if ($pondasi_t == 0){
            $b_pondasit = 0;
        }else{
            $b_pondasit = 8;
        }

        //KOLOM
        if ($kolom_l >= 3){
             $b_koloml = 11;
        }else if ($kolom_l == 0){
            $b_koloml = 0;
        }else{
             $b_koloml = 7;
        }

        if ($kolom_m >= 3){
             $b_kolomm = 11;
        }else if ($kolom_m == 0){
            $b_kolomm = 0;
        }else{
             $b_kolomm = 7;
        }

        if ($kolom_h >= 3){
             $b_kolomh = 25;
        }else if ($kolom_h == 0){
            $b_kolomh = 0;
        }else{
             $b_kolomh = 19;
        }

        if ($kolom_t >= 3){
             $b_kolomt = 35;
        }else if ($kolom_t == 0){
            $b_kolomt = 0;
        }else{
             $b_kolomt = 32;
        }

        //ATAP
        if ($atap_t >= 3){
            $b_atapt = 11;
       }else if ($atap_t == 0){
        $b_atapt = 0;
    }else{
            $b_atapt = 5;
       }

       //LANGIT
       if ($langit_l >= 3){
        $b_langitl = 2;
   }else if ($langit_l == 0){
    $b_langitl = 0;
}else{
        $b_langitl = 1;
   }

   if ($langit_m >= 2){
        $b_langitm = 5;
   }else if ($langit_m == 0){
    $b_langitm = 0;
}else{
        $b_langitm = 4;
   }

   //DINDING
   if ($dinding_m >= 3){
    $b_dindingm = 5;
}else if ($dinding_m == 0){
    $b_dindingm = 0;
}else{
    $b_dindingm = 3;
}

if ($dinding_h >= 3){
    $b_dindingh = 11;
}else if ($dinding_h == 0){
    $b_dindingh = 0;
}else{
    $b_dindingh = 8;
}

if ($dinding_t >= 3){
    $b_dindingt = 15;
}else if ($dinding_t == 0){
    $b_dindingt = 0;
}else{
    $b_dindingt = 14;
}

//LANTAI
if ($lantai_l >= 3){
    $b_lantail = 3;
}else if ($lantai_l == 0){
    $b_lantail = 0;
}else{
    $b_lantail = 2;
}

if ($lantai_t >= 3){
    $b_lantait = 10;
}else if ($lantai_t == 0){
    $b_lantait = 0;
}else{
    $b_lantait = 8;
}
        
$kerusakan =   ($b_pondasil + $b_pondasim + $b_pondasih + 
                $b_pondasit + $b_koloml + $b_kolomm + $b_kolomh + 
                $b_kolomt + $b_atapt + $b_langitl + $b_langitm + 
                $b_dindingm + $b_dindingh + $b_dindingt + 
                $b_lantail + $b_lantait);
                
        if ($kerusakan < 30){
            $totalkerusakan = 'Ringan';
        }else if ($kerusakan >= 31 && $kerusakan <= 70){
            $totalkerusakan = 'Sedang';
        }else if ($kerusakan >= 71){
            $totalkerusakan = 'Berat';
        }       

        $Asassment = new Asassment;
        $Asassment->kab = $kab;
        $Asassment->kec =$kec;
        $Asassment->alamat =$alamat;
        $Asassment->long =$long ;
        $Asassment->lot = $lot ;
        $Asassment->nama =$nama ;
        $Asassment->sektor =$sektor;
        $Asassment->kewenangan =$kewenangan ;
        $Asassment->luas =$luas ;
        $Asassment->harga =$harga ;
        $Asassment->pondasi_l =$pondasi_l;
        $Asassment->pondasi_m =$pondasi_m ;
        $Asassment->pondasi_h =$pondasi_h ;
        $Asassment->pondasi_t =$pondasi_t ;
        $Asassment->kolom_l =$kolom_l ;
        $Asassment->kolom_m = $kolom_m ;
        $Asassment->kolom_h =$kolom_h ;
        $Asassment->kolom_t =$kolom_t ;
        $Asassment->atap_t =$atap_t ;
        $Asassment->langit_l =$langit_l;
        $Asassment->langit_m =$langit_m ;
        $Asassment->dinding_m =$dinding_m ;
        $Asassment->dinding_h =$dinding_h;
        $Asassment->dinding_t =$dinding_t ;
        $Asassment->lantai_l =$lantai_l;
        $Asassment->lantai_t =$lantai_t;
        $Asassment->tingkat =$totalkerusakan;
        $Asassment->fpondasi =$fpondasi;
        $Asassment->fkolom =$fkolom;
        $Asassment->fatap =$fatap;
        $Asassment->flangit =$flangit;
        $Asassment->fdinding =$fdinding;
        $Asassment->flantai =$flantai;
        $Asassment->status ='Pending';
        $Asassment->save();

        $data = array('id' => $Asassment->id,'kab' => $kab, 'kec' => $kec
        , 'alamat' => $alamat, 'long' => $long, 'lot' => $lot, 'nama' => $nama
        , 'sektor' => $sektor, 'kewenangan' => $kewenangan, 'luas' => $luas, 'harga' => $harga
        , 'pondasi_l' => $pondasi_l, 'pondasi_m' => $pondasi_m, 'pondasi_h' => $pondasi_h ,'pondasi_t' => $pondasi_t, 'kolom_l' => $kolom_l
        , 'kolom_m' => $kolom_m, 'kolom_h' => $kolom_h, 'kolom_t' => $kolom_t, 'atap_t' => $atap_t
        , 'langit_l' => $langit_l, 'langit_m' => $langit_m, 'dinding_m' => $dinding_m, 'dinding_h' => $dinding_h
        , 'dinding_t' => $dinding_t, 'lantai_l' => $lantai_l, 'lantai_t' => $lantai_t , 
        'fpondasi' => $Asassment->fpondasi,
        'fkolom' => $Asassment->fkolom,
        'fatap' => $Asassment->fatap,
        'flangit' => $Asassment->flangit,
        'fdinding' => $Asassment->fdinding,
        'flantai' => $Asassment->flantai,'status' => 'Pending', 'tingkat' => $totalkerusakan
     );
        // return "Data Berhasil di Buat";
        return response()->json($data);
        // return response()->json($filelocfpondasi);
    }

    public function update(request $request,$id){

        $fpondasi = $request->get('fpondasi');
        $fkolom = $request->get('fkolom');
        $fatap = $request->get('fatap');
        $flangit = $request->get('flangit');
        $fdinding = $request->get('fdinding');
        $flantai = $request->get('flantai');
        
      $kab = $request->get('kab');
      $kec = $request->get('kec');
      $alamat = $request->get('alamat');
      $long = $request->get('long');
      $lot = $request->get('lot');
      $nama = $request->get('nama');
      $sektor = $request->get('sektor');
      $kewenangan = $request->get('kewenangan');
      $luas = $request->get('luas');
      $harga = $request->get('harga');
      $pondasi_l = $request->get('pondasi_l');
      $pondasi_m = $request->get('pondasi_m');
      $pondasi_h = $request->get('pondasi_h');
      $pondasi_t = $request->get('pondasi_t');
      $kolom_l = $request->get('kolom_l');
      $kolom_m = $request->get('kolom_m');
      $kolom_h = $request->get('kolom_h');
      $kolom_t = $request->get('kolom_t');
      $atap_t = $request->get('atap_t');
      $langit_l = $request->get('langit_l');
      $langit_m = $request->get('langit_m');
      $dinding_m = $request->get('dinding_m');
      $dinding_h = $request->get('dinding_h');
      $dinding_t = $request->get('dinding_t');
      $lantai_l = $request->get('lantai_l');
      $lantai_t = $request->get('lantai_t');
      $tingkat = $request->get('tingkat');
      $status = $request->get('status');
       
        $Asassment = Asassment::find($id);
        $Asassment->kab = $kab;
        $Asassment->kec =$kec;
        $Asassment->alamat =$alamat;
        $Asassment->long =$long ;
        $Asassment->lot = $lot ;
        $Asassment->nama =$nama ;
        $Asassment->sektor =$sektor;
        $Asassment->kewenangan =$kewenangan ;
        $Asassment->luas =$luas ;
        $Asassment->harga =$harga ;
        $Asassment->pondasi_l =$pondasi_l;
        $Asassment->pondasi_m =$pondasi_m ;
        $Asassment->pondasi_h =$pondasi_h ;
        $Asassment->pondasi_t =$pondasi_t ;
        $Asassment->kolom_l =$kolom_l ;
        $Asassment->kolom_m = $kolom_m ;
        $Asassment->kolom_h =$kolom_h ;
        $Asassment->kolom_t =$kolom_t ;
        $Asassment->atap_t =$atap_t ;
        $Asassment->langit_l =$langit_l;
        $Asassment->langit_m =$langit_m ;
        $Asassment->dinding_m =$dinding_m ;
        $Asassment->dinding_h =$dinding_h;
        $Asassment->dinding_t =$dinding_t ;
        $Asassment->lantai_l =$lantai_l;
        $Asassment->lantai_t =$lantai_t;
        $Asassment->tingkat =$tingkat;
        $Asassment->fpondasi =$fpondasi;
        $Asassment->fkolom =$fkolom;
        $Asassment->fatap =$fatap;
        $Asassment->flangit =$flangit;
        $Asassment->fdinding =$fdinding;
        $Asassment->flantai =$flantai;
        $Asassment->status = $status;
        $Asassment->save();
        
        $data = array('id' => $Asassment->id,'kab' => $kab, 'kec' => $kec
        , 'alamat' => $alamat, 'long' => $long, 'lot' => $lot, 'nama' => $nama
        , 'sektor' => $sektor, 'kewenangan' => $kewenangan, 'luas' => $luas, 'harga' => $harga
        , 'pondasi_l' => $pondasi_l, 'pondasi_m' => $pondasi_m, 'pondasi_h' => $pondasi_h ,'pondasi_t' => $pondasi_t, 'kolom_l' => $kolom_l
        , 'kolom_m' => $kolom_m, 'kolom_h' => $kolom_h, 'kolom_t' => $kolom_t, 'atap_t' => $atap_t
        , 'langit_l' => $langit_l, 'langit_m' => $langit_m, 'dinding_m' => $dinding_m, 'dinding_h' => $dinding_h
        , 'dinding_t' => $dinding_t, 'lantai_l' => $lantai_l, 'lantai_t' => $lantai_t , 'tingkat' => $tingkat,'status' => $status
     );
        return response()->json($data);

        // return "Data Berhasil di Update";

    }

    public function delete($id){

        $idnya = $id;

        $Asassment = Asassment::find($id);
        $Asassment -> delete();

        $data = array('id' => $idnya);

        return response()->json($data);
    }

    public function tesgcp(Request $request)
    {

        // $foto = $request->file('avatar');

        // $disk = Storage::disk('gcs');

        // $disk->put('avatars/1', $foto);

        // return $foto;

        $path = $request->file('avatar')->store('avatars');

        return $path;
    }


    public function tesaws(Request $request)
    {
        if($request->hasFile('profile_image')) {
 
            //get filename with extension
            $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
     
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
     
            //get file extension
            $extension = $request->file('profile_image')->getClientOriginalExtension();
     
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
     
            //Upload File to s3
            Storage::disk('s3')->put($filenametostore, fopen($request->file('profile_image'), 'r+'), 'public');
     
            //Store $filenametostore in the database
            	
$url = Storage::disk('s3')->url($filenametostore);

return $url;
        }
       
    }




}
