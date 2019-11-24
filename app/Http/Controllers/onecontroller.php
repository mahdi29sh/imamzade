<?php

namespace App\Http\Controllers;

//         API controller            //
use Auth;
use App\Http\Resources\City;

use App\image;
use App\imamzade;
use App\imamzade_temp;
use App\temp_image;
use App\ziaratname;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use App\User;
use App\Province;
use Illuminate\Http\Request;


class onecontroller extends Controller
{
    //******** show api start ****************************************//
    public function show_city ($id)
    {
        return \App\City::find($id);

    }
    public function show_province ($id)
    {
        return \App\Province::find($id);

    }
    public function show_ziaratname ($id)
    {
        return \App\ziaratname::find($id);

    }
    public function show_imamzade ($id)
    {
        $result = \App\imamzade::find($id);
        return $result;

    }
    //******** show api end ****************************************//
    //************** index api start******************************//
    public function index_city()
    {
        $result =  \App\City::all();
        $return = array('city' => $result);
        return $return;
    }
    public function index_province()
    {
        $result = Province::all();
        $return = array('province' => $result);
        return $return;

    }
    public function index_imamzade()
    {
        $result = \Illuminate\Support\Facades\DB::table('imamzades')
            ->join('cities', 'cities.Cid', '=', 'imamzades.CID')
            ->join('provinces', 'provinces.Pid', '=', 'imamzades.PID')->get();
        $return = array('imamzade' => $result);
        return $return;
    }
    public function index_ziaratname()
    {
        return \App\ziaratname::all();
    }
    //************** index api end******************************//
    //************** store api start **************************//
    public function store_imamzade(Request $request)
    {
        $imamzade= \App\imamzade::create($request->all());
        imamzade_temp::where('imamzade_Name' ,'=',$imamzade['imamzade_Name'])->delete();

        return response()->json($imamzade , 201);
    }
    public function store_ziaratname(Request $request)
    {
        $ziaratname = \App\ziaratname::create($request->all());
        return response()->json($ziaratname , 201);
    }
    //************** store api end **************************//
    //************** update api start ******************************//
    public function update_imamzade(Request $request, $id)
    {
        $imamzade = \App\imamzade::findOrFail($id);
        $imamzade->update($request->all());

        return response()->json($imamzade , 200);
    }
    public function update_ziaratname(Request $request, $id)
    {
        $ziaratname = \App\ziaratname::findOrFail($id);
        $ziaratname->update($request->all());

        return response()->json($ziaratname , 200);
    }
    //************** update api end ******************************//
    //************** delete api start ******************************//
    public function delete_imamzade(Request $request, $id)
    {
        $imamzade = \App\imamzade::findOrFail($id);
        $imamzade->delete();

        return 204;
    }
    public function delete_ziaratname(Request $request, $id)
    {
        $ziaratname = \App\ziaratname::findOrFail($id);
        $ziaratname->delete();

        return 204;
    }


    //************** delete api end ******************************//
    public function index(){

        $mapArrays = imamzade::all();
        $image = image::where('is_first','=',1)->get();

        return view('map' ,compact(['mapArrays','image']));

    }
    public function custommap(Request $request){
        $mapArrays = $request['mapArrays'];
        $image = image::where('is_first','=',1)->get();
        return view('map' ,compact(['mapArrays','image']));
    }
    public function search(){
        $province = Province::all();
        $result = [];
        $image = [];
        return view('searchtemp',compact(['province','result','image']));
    }
    public function managesearch(Request $request){
        $result = $this->searchpost($request);
        $province = Province::all();
        $image = image::where('is_first','=',1)->get();
        return view('searchtemp',compact(['province','result','image']));

    }
    public function manage(){
        $result = imamzade_temp::all();
        $province = Province::all();
        $image = temp_image::where('is_first','=',1)->get();
        return view('manage',compact(['province','result','image']));
    }
    public  function searchpost($request){
        if($request['action'] === 'search') {
            $result = imamzade::where('imamzade_Name' , 'LIKE' , '%'.$request['input'].'%')->orwhere('Ancestor' , 'LIKE' , '%'.$request['input'].'%')->get();
            return $result;
        }
        else {

            if($request['category']){
                switch ($request['category']) {
                    case(1):
                        if ($request['select_province']) {
                            $result = imamzade::where('imamzade_Name', 'LIKE', '%' . $request['input'] . '%')->where('PID', '=', $request['select_province'])->where('Cid', '=', $request['select_city'])->get();
                            return $result;
                        } else {
                            $result = imamzade::where('imamzade_Name', 'LIKE', '%' . $request['input'] . '%')->get();
                            return $result;
                        }
                        break;
//                    case(2):
//                        $result3 = [];
//                        if ($request['select_province']) {
//                            $result1 = ziaratname::where('Ziaratname', 'LIKE', '%' . $request['input'] . '%')->get();
//                            foreach ($result1 as $r) {
//                                $result2 = imamzade::find($r->IID);
//                                if ($result2->PID == $request['select_province'] and $result2->CID == $request['select_city']) {
//                                    array_push($result3, $result2);
//                                }
//
//                            }
//                            return $result3;
//                        } else {
//                            $result3 = [];
//                            $result1 = ziaratname::where('Ziaratname', 'LIKE', '%' . $request['input'] . '%')->get();
//                            foreach ($result1 as $r) {
//                                $result2 = imamzade::find($r->IID);
//                                array_push($result3, $result2);
//                            }
//                            return $result3;
//                        }
//                        break;
                    case(2):
                        if ($request['select_province']) {
                            $result = imamzade::where('Ancestor', 'LIKE', '%' . $request['input'] . '%')->where('PID', '=', $request['select_province'])->where('Cid', '=', $request['select_city'])->get();
                            return $result;
                        } else {

                            $result1 = imamzade::where('Ancestor', 'LIKE', '%' . $request['input'] . '%')->get();
                            return $result1;
                        }
                        break;
                }
            } else{
                if($request['select_province']){
                    $result = imamzade::where('imamzade_Name' , 'LIKE' , '%'.$request['input'].'%')->where('PID', '=', $request['select_province'])->where('Cid', '=', $request['select_city'])->get();
                    return $result;
                }
                else{
                    $result = imamzade::where('imamzade_Name' , 'LIKE' , '%'.$request['input'].'%')->orwhere('Ancestor' , 'LIKE' , '%'.$request['input'].'%')->get();
                    return $result;
                }
            }

        }
    }
    public function searchresult(Request $request){
        $result1 = $this->searchpost($request);
        $result3 = [];
        $result2 = \Illuminate\Support\Facades\DB::table('imamzades')
            ->join('cities', 'cities.Cid', '=', 'imamzades.CID')
            ->join('provinces', 'provinces.Pid', '=', 'imamzades.PID')->get();
        foreach ($result1 as $r1){
            foreach ($result2 as $r2){
                if($r1->id == $r2->id){
                    array_push($result3 , $r2);
                }
            }
        }
        $return = array('imamzade' => $result3);
        return $return;
       
    }
    public function map($id){
        $mapArrays=[imamzade::find($id)];
        $image = image::where('is_first','=',1)->get();
        return view('map' ,compact(['mapArrays','image']));
    }
    public function tmap($id){
        $mapArrays=[imamzade_temp::find($id)];

        $image = temp_image::where('is_first','=',1)->get();
        return view('map' ,compact(['mapArrays','image']));
    }
    public function edit($id){
        $imamzade = imamzade::find($id);
        $result = Province::all();
        $province = Province::where('Pid','=',$imamzade->PID)->get();
        $city = \App\City::where('Cid','=',$imamzade->CID)->get();
        $image = image::where('IID','=',$imamzade->id)->get();
    //    return json_encode($province[0]->province_Name);
        return view('edit',compact(['result','imamzade','province','city','image']));
    }
    public function tdetail($id){
        $imamzade = imamzade_temp::where('id' ,'=',$id)->get();
        $image =temp_image::where('TIID','=',$id)->get();
        $city = \App\City::where('CID','=',$imamzade[0]->CID)->get();
        $province = Province::where('PID','=',$imamzade[0]->PID)->get();
        try {
            $ziaratname = ziaratname::where('IID', '=', $id)->get();
        } catch (\Exception $e){
            return $e;
        }
        return view('tdetail',['imamzade'=>$imamzade,'image'=>$image , 'city'=>$city , 'province'=>$province , 'ziaratname'=>$ziaratname]);
    }
    public function verify($id){
        $i = imamzade_temp::where('id','=',$id)->get();
        $arr['imamzade_Name'] = $i[0]['imamzade_Name'];
        $arr['Ancestor'] = $i[0]['Ancestor'];
        $arr['Address'] = $i[0]['Address'];
        $arr['latitude'] = $i[0]['latitude'];
        $arr['longitude'] = $i[0]['longitude'];
        $arr['PID'] = $i[0]['PID'];
        $arr['CID'] = $i[0]['CID'];
        $arr['UID'] = $i[0]['UID'];
        $imamzade = imamzade::create($arr);

        $image = temp_image::where('TIID','=',$id)->get();
        $imagearr = [];
        $imagearr['IID'] = $imamzade->id;
        $imagearr['image'] = $image[0]['image'];
        $imagearr['is_first'] = $image[0]['is_first'];
        $newimage = image::create($imagearr);

        imamzade_temp::find($id)->delete();
        temp_image::where('TIID','=',$id)->delete();
         return redirect('manage');
    }
    public function profile($id){
        $user = User::find($id);
        return view('profile',compact(['user']));
    }
    public function change(\Illuminate\Http\Request $request){
        print $request;
        if($request['password'] == $request['password_confirmation']){

            $user = Auth::user();
            $user['password']= bcrypt($request['password']);
            $user->save();
            return $user;
        }
        else{
            return view('auth/changepass');
        }

//        $user = Auth::user();
//        $user['password']= $request['password'];
//        return $user;
    }
     public function prtocity(Request $request){
        $province = $request['id'];
        $result = \App\City::where('Province','=',$province)->get();
        $return = array('city' => $result);
        return $return;
    }
}
