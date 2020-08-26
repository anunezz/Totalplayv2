<?php
namespace App\Http\Controllers;

use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;

use App\Http\Models\Cats\CatDescription;
use App\Http\Models\Cats\CatPrimaryValues;
use App\Http\Models\Cats\CatSampling;
use App\Http\Models\Cats\CatSection;
use App\Http\Models\Cats\CatSelectionTechniques;
use App\Http\Models\Cats\CatSeries;
use App\Http\Models\Cats\CatSubseries;
use App\Http\Models\Cats\CatTypeUnit;
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
                        ->select(['id', 'name', 'determinant', 'isActive'])
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
                    $elements = CatSeries::with('section', 'primarivalues', 'selection', 'administrative')
                        ->select(['id', 'name', 'code', 'codeSeries', 'cat_section_id', 'AT', 'AC', 'total', 'cat_selection_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 4) {
                    $elements = CatSubseries::with('serie')
                        ->select(['id', 'name', 'code', 'codeSubseries', 'cat_series_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 5) {
                    $elements = CatDescription::with('serie', 'administrative')
                        ->select(['id', 'description', 'cat_series_id', 'isActive'])
                        ->orderBy('id')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 6) {
                    $elements = CatSampling::with('serie')
                        ->select(['id', 'quality', 'cat_series_id', 'isActive'])
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
            if ($request->wantsJson()){

                $sections = CatSection::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name', 'code']);

                $selections = CatSelectionTechniques::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $values = CatPrimaryValues::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $series = CatSeries::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name', 'code']);

                $units = CatAdministrativeUnit::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $subseries = CatSubseries::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $types = CatTypeUnit::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                return response()->json([

                    'sections'    => $sections,
                    'selections'  => $selections,
                    'values'      => $values,
                    'series'      => $series,
                    'units'       => $units,
                    'subseries'   => $subseries,
                    'types'       => $types,
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
                $cat = new CatAdministrativeUnit();
                $duplicityCheck = self::duplicityCheck(CatAdministrativeUnit::class, null, $request->name, $request->specialName, $request->determinant);
            }
            elseif ($request->cat === 2) {
                $cat = new CatSection();
                $duplicityCheck = self::duplicityCheck(CatSection::class, null, $request->name, $request->code, $request->cat_type_id);
            }
            elseif ($request->cat === 3) {
                $cat = new CatSeries();
                $duplicityCheck = self::duplicityCheck(CatSeries::class, null, $request->name, $request->code, $request->codeSeries, $request->cat_section_id, $request->AT, $request->AC, $request->total, $request->cat_selection_id);
            }
            elseif ($request->cat === 4) {
                $cat = new CatSubseries();
                $duplicityCheck = self::duplicityCheck(CatSubseries::class, null, $request->name, $request->code, $request->codeSubseries, $request->cat_series_id);
            }


            if (! $duplicityCheck) {
                if ($request->cat!==3){
                    $cat->name = $request->name;

                    if ($request->cat === 1){
                        $cat->specialName = $request->specialName;
                        $cat->determinant = $request->determinant;
                    }

                    if ($request->cat === 2){
                        $cat->code = $request->code;
                        $cat->cat_type_id = $request->cat_type_id;
                    }

//                    if ($request->cat === 3){
//                        $cat->code = $request->code;
//                        $cat->codeSeries = $request->codeSeries;
//                        $cat->cat_section_id = $request->cat_section_id;
//                        $cat->AT = $request->AT;
//                        $cat->AC = $request->AC;
//                        $cat->total = $request->total;
//                        $cat->cat_selection_id = $request->cat_selection_id;
//                    }

                    if ($request->cat === 4){
                        $cat->code = $request->code;
                        $cat->codeSubseries = $request->codeSubseries;
                        $cat->cat_series_id = $request->cat_series_id;
                    }
//
//                    $request->cat === 11 ? $cat->rights_recommendations_id = $request->rights_recommendations_id : null;
//
//                    $request->cat === 12 ? $cat->sub_rights_id = $request->sub_rights_id : null;
//
//                    if ($request->cat === 13){
//                        $cat->ods_id = $request->ods_id;
//                        $cat->acronym = $request->acronym;
//                    }
                }else{
                    $cat->fill($request->all());
                    $cat->save();
                    $cat->primarivalues()->sync($request->cat_primary_value_id);
                    $cat->administrative()->sync($request->cat_administrative_unit_id);

                    GeneralController::saveTransactionLog(2, 'Se creo elemento en catalogo con id: ' . $cat->id);
                    DB::commit();

                    return response()->json([
                        'success' => true
                    ], 200);
                }

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
                $duplicityCheck = self::duplicityCheck(CatAdministrativeUnit::class, $cat->id, $request->name, $request->determinant);
            }

            elseif ($request->cat === 2) {
                $cat = CatSection::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSection::class, $cat->id, $request->name, $request->code, $request->cat_type_id);
            }

            elseif ($request->cat === 3) {
                $cat = CatSeries::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSeries::class, $cat->id, $request->name, $request->code, $request->codeSeries, $request->cat_section_id, $request->AT, $request->AC, $request->total, $request->cat_selection_id);
            }
            elseif ($request->cat === 4) {
                $cat = new CatSubseries();
                $duplicityCheck = self::duplicityCheck(CatSubseries::class, $cat->id, $request->name, $request->code, $request->codeSubseries, $request->cat_series_id);
            }

            if (! $duplicityCheck) {

                $cat->name = $request->name;

                if ($request->cat === 1){
                    $cat->determinant = $request->determinant;
                }

                if ($request->cat === 2){
                    $cat->code = $request->code;
                    $cat->cat_type_id = $request->cat_type_id;
                }

                if ($request->cat === 3){
                    $cat->code = $request->code;
                    $cat->codeSeries = $request->codeSeries;
                    $cat->cat_section_id = $request->cat_section_id;
                    $cat->AT = $request->AT;
                    $cat->AC = $request->AC;
                    $cat->total = $request->total;
                    $cat->cat_selection_id = $request->cat_selection_id;
                }

                if ($request->cat === 4){
                    $cat->code = $request->code;
                    $cat->codeSubseries = $request->codeSubseries;
                    $cat->cat_series_id = $request->cat_series_id;
                }

                 $cat->isActive = true;
//
                if ($request->cat === 1){
                    $cat->sectionAll()->sync($request->cat_section_id);
                }

                if ($request->cat === 3){
                    $cat->primarivalues()->sync($request->cat_primary_value_id);
                    $cat->administrative()->sync($request->cat_administrative_unit_id);
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
