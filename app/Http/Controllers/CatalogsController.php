<?php
namespace App\Http\Controllers;

use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;

use App\Http\Models\Cats\CatDescription;
use App\Http\Models\Cats\CatSection;
use App\Http\Models\Cats\CatSelectionTechniques;
use App\Http\Models\Cats\CatSeries;
use App\Http\Models\Cats\CatSubseries;
use App\User;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;


class CatalogsController extends Controller
{
    public function getCatalogByType(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $data     = $request->all();
                $elements = null;

                if ($data['cat'] == 1) {
                    $elements = CatAdministrativeUnit::with('sectionAll')
                        ->select(['id', 'name', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 2) {
                    if (isset($data['allSections'])){
                        return CatSection::orderBy('name')->get(['id','name']);
                    }else{
                        $elements = CatSection::select(['id', 'name', 'code', 'cat_type_id', 'isActive'])
                            ->orderBy('name')
                            ->paginate($data['perPage']);
                    }
                }
                if ($data['cat'] == 3) {
                    $elements = CatSeries::with('section')
                        ->select(['id', 'name', 'code', 'cat_section_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 4) {
                    $elements = CatSubseries::with('serie')
                        ->select(['id', 'name', 'code', 'cat_series_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 5) {
                    $elements = CatDescription::with('serie')
                        ->select(['id', 'description', 'cat_series_id', 'isActive'])
                        ->orderBy('id')
                        ->paginate($data['perPage']);
                }

                return response()->json([
                    'success' => true,
                    'elements' =>$elements,

                ], 200);

            }else{
                return response()->view('errors.404', [], 404);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function create(Request $request)
    {
        try {
            //    return 'hola';
            if ($request->wantsJson()){

                $sections = CatSection::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name', 'code']);

                $selections = CatSelectionTechniques::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                return response()->json([

                    'sections'    => $sections,
                    'selections'  => $selections,
                    'success'     => true
                ]);

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function newRegister(Request $request)
    {
        try {

            DB::beginTransaction();

            $duplicityCheck = false;

            if ($request->cat === 1) {
                $cat = new CatConsulate();
                $duplicityCheck = self::duplicityCheck(CatConsulate::class, null, $request->name, $request->frontier_id, $request->isMirror, $request->latitude, $request->longitude);
            }
            elseif ($request->cat === 2) {
                $cat = new CatCountry();
                $duplicityCheck = self::duplicityCheck(CatCountry::class, null, $request->name);
            }


            if (! $duplicityCheck) {
                $cat->name = $request->name;

//                    if ($request->cat === 6){
//                        $cat->state_id = $request->state_id;
//                        $cat->latitude = $request->latitude;
//                        $cat->longitude = $request->longitude;
//                    }
//
//                    $request->cat === 11 ? $cat->rights_recommendations_id = $request->rights_recommendations_id : null;
//
//                    $request->cat === 12 ? $cat->sub_rights_id = $request->sub_rights_id : null;
//
//                    if ($request->cat === 13){
//                        $cat->ods_id = $request->ods_id;
//                        $cat->acronym = $request->acronym;
//                    }

                $cat->save();
                GeneralController::saveTransactionLog(2, 'Se creo elemento en catalogo con id: ' . $cat->id);
                DB::commit();


                return response()->json([
                    'success' => true
                ], 200);
            }
            else {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un registro con ese nombre o acrónimo, favor de verificar'
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateRegister(Request $request)
    {
        try {
            DB::beginTransaction();

            $duplicityCheck = false;

            if ($request->cat === 1) {
                $cat = CatAdministrativeUnit::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatAdministrativeUnit::class, $cat->id, $request->name);
            }

            elseif ($request->cat === 2) {

                $cat = CatCountry::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatCountry::class, $cat->id, $request->name);
            }

            if (! $duplicityCheck) {
                $cat->name = $request->name;

//                if ($request->cat === 6){
//                    $cat->state_id = $request->state_id;
//                    $cat->latitude = $request->latitude;
//                    $cat->longitude = $request->longitude;
//                }
//                $request->cat === 11 ? $cat->rights_recommendations_id = $request->rights_recommendations_id : null;
//                $request->cat === 12 ? $cat->sub_rights_id = $request->sub_rights_id : null;
//                if ($request->cat === 13){
//                    $cat->ods_id = $request->ods_id;
//                    $cat->acronym = $request->acronym;
//                }

                 $cat->isActive = true;
//
                if ($request->cat === 1){
                    $cat->sectionAll()->sync($request->cat_section_id);
                }

                $cat->save();

                GeneralController::saveTransactionLog(3, 'Se actualizo elemento en catalogo con id: ' . $cat->id);
                DB::commit();

                return response()->json([
                    'success' => true
                ], 200);
            }
            else {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un registro con ese nombre o acrónimo, favor de verificar'
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . $e->getLine()
            ], 400);
        }
    }

    private static function duplicityCheck($cat, $id, $name, $acronym = null, $topicId = null, $rightId = null, $subrightId = null, $odsId = null, $aux=null)
    {
        try {
            if ($aux !=null) {
                //dd($name,$aux);
                $nam = $cat::where('name', $name)->whereIsactive(true)->first();
                $acro = $cat::where('acronym', $aux)->whereIsactive(true)->first();
                if (is_null($nam) && is_null($acro)) return false;
                else return true;
            }

            if ( is_null($topicId)) {
                return $cat::where('id', '!=', $id)->where('name', $name)->whereIsactive(true)->first() ? true : false;
            }

            if ( is_null($rightId)) {
                return $cat::where('id', '!=', $id)->where('name', $name)->whereIsactive(true)->first() ? true : false;
            }

            if ( is_null($subrightId)) {
                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
            }

            if ( is_null($odsId)) {
                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
            }

            if (is_null($acronym)) {
                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
            }

            else {
                if ($acronym) {
                    return $cat::where('id', '!=', $id)->where('name', $name)->where('acronym', $acronym)->first() ? true : false;
                }

            }




        } catch (Exception $e) {
            return false;
        }
    }


    public function disableRegister(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->cat === 1) {
                $cat = CatConsulate::find(decrypt($request->id));
            }
            elseif ($request->cat === 2) {
                $cat = CatGobOrder::find(decrypt($request->id));
            }

            $cat->isActive = false;
            $cat->save();

            GeneralController::saveTransactionLog(3, 'Se deshabilito elemento en catalogo con id: ' . $cat->id);
            DB::commit();

            return response()->json([
                'success' => true
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function enableRegister(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->cat === 1) {
                $cat = CatConsulate::find(decrypt($request->id));
            }
            elseif ($request->cat === 2) {
                $cat = CatGobOrder::find(decrypt($request->id));
            }

            $cat->isActive = true;
            $cat->save();

            GeneralController::saveTransactionLog(3, 'Se habilito elemento en catalogo con id: ' . $cat->id);
            DB::commit();

            return response()->json([
                'success' => true
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getDetailsUser(){

        $fields = ['unit','profile', 'admin', 'determinant'];

        $user = User::with($fields)
            ->where('isActive',1)
            ->findOrfail( auth()->user()->getAuthIdentifier() );

//        $units = User::with('unit')
//            ->where('isActive', 1)
//            ->where('id', $user)
//            ->first(['id', 'name']);

   //     return $user;

//        $units = [];
//        $unit = $user->unit()->get();
//        foreach ($unit as $uni) {
//            array_push($units,$uni->id);
//        }

        return response()->json([
            'success' => true,
            'lResults' => ["user"=> $user,
           //     'units' => $units

            ]
        ]);

    }

    public function saveRegister(Request $request)
    {
        try {
            DB::beginTransaction();

            $data   = $request->all();

            $reports = User::find($request->id);
           // return $reports;
            $reports->update($data);

            $nameUnit = null;
            if (!is_null($reports->admin)) {
                $nameUnit = $reports->admin->name;
            }
            $reports->name_unit = $nameUnit;

            DB::commit();

            return response()->json([
                'success' => true,
                'user' => $reports
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function allunits(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $allunits = CatAdministrativeUnit::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                return response()->json([
                    'allunits'    => $allunits,
                    'success'       => true
                ]);

            } else {
                return response()->view('errors.404', [], 404);
            }

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

}
