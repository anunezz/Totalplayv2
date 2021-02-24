<?php namespace App\Http\Controllers;

use DB;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Models\Contact;
use App\Http\Models\ImgPromotion;
use App\Http\Models\FilePromotionModal;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Cats\CatState;
use App\Http\Models\Cats\CatPromotion;
use App\Http\Models\Cats\CatNamePaks;
use App\Http\Models\Cats\CatCity;
use App\Http\Models\Cats\CatProfile;
use App\Http\Models\FirstSesion;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\exportContacts;
use App\Http\Traits\validFile;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TotalplayController extends Controller
{
    private $phone = 'regex:/^[0-9]{10}$/im';
    private $zip_code = 'regex:/^[0-9]{5}$/im';
    private $alphanumeric = 'regex:/^[A-Za-z0-9\.,\-\"\()ÑñäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s]+$/im';

    public function setContact(Request $request){
        try{
            if ($request->wantsJson()){
                $request->validate([
                    'name' => 'required|string|max:100|'.$this->alphanumeric,
                    //'zip_code' => 'required|max:5|'.$this->zip_code,
                    'city_id' => 'required|numeric',
                    'promotion_id' => 'nullable|numeric',
                    //'email' => 'nullable|string|max:100|sometimes|email',
                    'phone' => 'required|max:10|'.$this->phone,
                    'promotion_code' => 'nullable|string|max:100'.$this->alphanumeric,
                ]);

                $data = $request->all();

                    Contact::create([
                        'name' => $data['name'],
                        'city_id' => $data['city_id'],
                        'promotion_id' => $data['promotion_id'],
                        //'zip_code' => $data['zip_code'],
                        //'email' => $data['email'],
                        'phone' => $data['phone'],
                        'promotion_code' => $data['promotion_code']
                    ]);

                    return response()->json([
                        'success' => true,
                    ], 200);

                }else{
                    return response()->view('errors.404', [], 404);
                }
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al mostrar información ' . $e->getMessage()
                ], 300);
            }
    }

    public function getCats(){
        try{
            //dd('holllaaa');
            $results = CatCity::with('state')->where('isActive',1)->orderBy('name','asc')->get();

            $user = User::get();
            return response()->json([
                'success' => true,
                'lResults' =>  $results,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function setPacks(Request $request){
        try{
            if ($request->wantsJson()){
                $data = $request->all();

                $request->validate([
                    'city' => 'required|numeric',
                    'typePack' => 'required|boolean'
                ]);

                $data = $request->all();
                $data['city'] = ( $data['city'] === 2 | $data['city'] === 3 | $data['city'] === 4)? 1 : 0;
                $data['type'] = 1;
                $catHome = CatPromotion::Filter($data)->get();
                $data['typePack'] = null;
                $data['type'] = 2;
                $catAmazon = CatPromotion::Filter($data)->get();
                $data['type'] = 3;
                $catNetflix = CatPromotion::Filter($data)->get();

                return response()->json([
                    'success' => true,
                    'lResults' => [
                        "catHome" => $catHome,
                        "catAmazon" => $catAmazon,
                        "catNetflix" => $catNetflix,
                    ],
                ], 200);
            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function getContacts(){
        try{

        $results = Contact::with('city')->where('isActive',1)->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'lResults' =>  $results,
        ], 200);

        } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al mostrar información ' . $e->getMessage()
        ], 300);
        }
    }

    public function exportContacts(Request $request)
    {
        try {

            $data = $request->all();

            return Excel::download(new exportContacts($data), 'Contactos_Totalplay.xlsx');

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function getUsers(Request $request)
    {
        try {

            $users = User::orderBy('created_at','desc')->get();

            return response()->json([
                'success' => true,
                'lResults' =>  $users,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function getCatsUser()
    {
        try {
            $fields = ['id','name'];
            $CatProfile = CatProfile::where('id','!=',1)->where('isActive',1)->get($fields);

            return response()->json([
                'success' => true,
                'lResults' =>  [
                    "profiles" => $CatProfile
                ],
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function createUser(Request $request){
        try{
            if ($request->wantsJson()){
                $data = $request->all();
                $aux = true;
                $searchUser = User::Search($data)->count();

                // $request->validate([
                //     'city' => 'required|numeric',
                //     'typePack' => 'required|boolean'
                // ]);

                if( $searchUser === 0 ){
                    $user = User::create([
                        'username'=>$data['username'],
                        'cat_profile_id' => $data['profile'],
                        'email' => $data['email'],
                        'name' => $data['name'],
                        'firstName' => $data['firstName'],
                        'secondName' => $data['secondName'],
                        'password' => bcrypt($data['password'])
                    ]);

                    $FirstSesion = FirstSesion::create([
                        'user_id' => $user->id
                    ]);

                }else{
                    $aux =  false;
                }

                return response()->json([
                    'success' => true,
                    'lResults' => $aux,
                ], 200);
            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function updateUser(Request $request){
        try{
            if ($request->wantsJson()){

                // $request->validate([
                //     'city' => 'required|numeric',
                //     'typePack' => 'required|boolean'
                // ]);

                $data = $request->all();
                $user = User::find( decrypt($data['userid']) );

                if( $user ){

                    $user->cat_profile_id = $data['data']['profile'];
                    $user->name = $data['data']['name'];
                    $user->firstName = $data['data']['firstName'];
                    $user->secondName = $data['data']['secondName'];
                    if( $data['updatePassword'] ){
                        $user->password = bcrypt($data['data']['password']);
                    }
                    $user->save();

                    $FirstSesion = $user->firstSesion()->first();
                    $FirstSesion->isActive = 0;
                    $FirstSesion->save();

                }

                return response()->json([
                    'success' => true,
                ], 200);
            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function activeUser(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();

                $user = User::find( decrypt($data['userid']) );

                if( $user ){
                    $user->isActive = ( $data['active'] === true )? 1 : 0;
                    $user->save();
                }

                return response()->json([
                    'success' => true,
                ], 200);
            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function updatePassword(Request $request){
        try{
            if ($request->wantsJson()){

                $data = $request->all();
                $aux = true;
                $user = auth()->user();
                $user->password = bcrypt($data['password']);
                $user->save();
                $firstSesion = $user->firstSesion()->first();
                $firstSesion->isActive = 0;
                $firstSesion->save();

                return response()->json([
                    'success' => true,
                ], 200);

            }else{
                return response()->view('errors.404', [], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function getCatsPacks(){
        try{
                $packs = CatPromotion::get();

                return response()->json([
                    'success' => true,
                    'lResults' => ['packs' => $packs]
                ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function getCatsPacksForm(){
        try{
                $packNames = CatNamePaks::where('isActive',1)->get();
                $frontiers = collect([
                    ['id'=> 0, 'name' => 'Residencial'],
                    ['id'=> 1, 'name' => 'Fronterizo']
                ]);

                $actives = collect([
                    ['id'=> 0, 'name' => 'Desactivado'],
                    ['id'=> 1, 'name' => 'Activado']
                ]);

                $triple_double = collect([
                    ['id'=> 0, 'name' => 'Double play'],
                    ['id'=> 1, 'name' => 'Triple play']
                ]);

                return response()->json([
                    'success' => true,
                    'lResults' => ['packNames' => $packNames,
                                    'frontiers'=> $frontiers,
                                    'actives' => $actives,
                                    'triple_double' => $triple_double]
                ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
        }
    }

    public function filePromotion(Request $request){
        try {
            DB::beginTransaction();
            if (validFile::valid($request->document)) {
                $file = new ImgPromotion();
                $document = $request->document;
                $file->fileNameHash = Storage::url($document->store('public/imgPack'));
                $file->fileName = $document->getClientOriginalName();
                $file->save();

                $imgPack = [
                    'id' => $file->id,
                    'name' => $file->fileName,
                    'url' => $file->fileNameHash
                ];

                DB::commit();

                return response()->json([
                    'success' => true,
                    'documentId' => $imgPack
                ]);

            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function filePromotionModal(Request $request){
        try {
            DB::beginTransaction();
            if (validFile::valid($request->document)) {
                $file = new FilePromotionModal();
                $document = $request->document;
                $file->fileNameHash = Storage::url($document->store('public/imgPackModal'));
                $file->fileName = $document->getClientOriginalName();
                $file->save();

                $imgPack = [
                    'id' => $file->id,
                    'name' => $file->fileName,
                    'url' => $file->fileNameHash
                ];

                DB::commit();

                return response()->json([
                    'success' => true,
                    'documentId' => $imgPack
                ]);

            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

        public function createPromotion(Request $request){
            try{
                if ($request->wantsJson()){

                    $data = $request->all();

                    $promotion = CatPromotion::create([
                        'type' => $data['pack_id'],
                        'frontier' => $data['frontier'],
                        'triple_double' => $data['triple_double'],
                        'name' => $data['name'],
                        'color' => $data['color'],
                        'description' => $data['description'],
                        'isActive' => $data['isActive']
                    ]);

                    $ImgPromotion = ImgPromotion::find( $data['file'][0]['id'] );
                    $ImgPromotion->promotion_id = $promotion->id;
                    $ImgPromotion->isActive = 1;
                    $ImgPromotion->save();


                    $FilePromotionModal = FilePromotionModal::find( $data['filesModal'][0]['id'] );
                    $FilePromotionModal->promotion_id = $promotion->id;
                    $FilePromotionModal->isActive = 1;
                    $FilePromotionModal->save();

                    return response()->json([
                        'success' => true,
                    ], 200);
                }else{
                    return response()->view('errors.404', [], 404);
                }
            } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar información ' . $e->getMessage()
            ], 300);
            }
        }


}
