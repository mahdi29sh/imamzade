<?php

namespace App\Http\Controllers;

use App\City;
use App\image;
use App\Province;
use App\temp_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Symfony\Component\HttpFoundation\Session\Session;
use function MongoDB\BSON\toJSON;

class imamzadecontroller extends Controller
{
    public function create(){
        $province = Province::all();
        return view('create')->with('result',[$province,null]);
    }
    public function fileUpload(Request $request,$id) {

        $this->validate($request, [
            'input_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('input_img')) {
            $image = $request->file('input_img');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);

            $arr['TIID'] = $id;
            $arr['image'] = $name;
            $arr['is_first'] = true;
            $img = temp_image::create($arr);

            return back()->with('success','Image Upload successfully');
        }

    }
    public function store(Request $request)
    {

        $pid = DB::table('Provinces')->where('province_Name', '=', $request['select_province'])->get();

        $cid = DB::table('Cities')->where('Cid', '=', $request['select_city'])->get();

        $uid = Auth::user();
        $arr['imamzade_Name'] = $request['imamzade_Name'];
        $arr['Ancestor'] = $request['Ancestor'];
        $arr['Address'] = $request['Address'];
        $arr['latitude'] = $request['latitude'];
        $arr['longitude'] = $request['longitude'];
        $arr['PID'] = $pid[0]->Pid;
        $arr['CID'] = $cid[0]->Cid;
        if (Auth::user()) {

            $arr['UID'] = $uid->Uid;
            $imamzade_temp = \App\imamzade_temp::create($arr);
            $this->fileUpload($request ,$imamzade_temp->id);
            return redirect('map');
        }

        else {
            return redirect()->route('login');
        }

    }
    public function creates(){


                $pid = DB::table('provinces')->where('province_Name','=',$_GET['province'])->get();
                print $pid;
                
                $city = DB::table('cities')->where('Province','=',$pid[0]->Pid)->get();
                $u ="";
                foreach ($city as $ci) {
                    $u .= '<option value="'.$ci->Cid.'">' .$ci->city_Name.'</option>';
                }

                return $u;

    }
    public function detail($iid){

        $imamzade = DB::table('imamzades')->where('id' ,'=',$iid)->get();
        $image = DB::table('images')->where('IID','=',$iid)->get();
        $city = DB::table('cities')->where('CID','=',$imamzade[0]->CID)->get();
        $province = DB::table('provinces')->where('PID','=',$imamzade[0]->PID)->get();
        try {
            $ziaratname = DB::table('ziaratnames')->where('IID', '=', $iid)->get();
        } catch (\Exception $e){
            return $e;
        }
        return view('detail',['imamzade'=>$imamzade,'image'=>$image , 'city'=>$city , 'province'=>$province , 'ziaratname'=>$ziaratname]);
}
}

