<?php
namespace App\Http\Controllers;

use App\CatInventory;
use App\Http\Controllers\GeneralController;
use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Controllers\Controller;

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
                    $elements = CatAdministrativeUnit::with('sectionAll', 'formalities')
                        ->search($data['search'])
                        ->select(['id', 'name', 'determinant', 'specialName', 'cat_type_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 2) {
                    if (isset($data['allSections'])){
                        return CatSection::orderBy('name')->get(['id','name']);
                    }else{
                        $elements = CatSection::with('formalities')
                            ->select(['id', 'name', 'code', 'cat_type_id', 'isActive'])
                            ->search($data['search'])
                            ->orderBy('name')
                            ->paginate($data['perPage']);
                    }
                }
                if ($data['cat'] == 3) {
                    $elements = CatSeries::with('section', 'primarivalues', 'selection', 'administrative', 'formalities')
                        ->search($data['search'])
                        ->select(['id', 'name', 'code', 'codeSeries', 'cat_section_id', 'AT', 'AC', 'total', 'cat_selection_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 4) {
                    $elements = CatSubseries::with('serie', 'formalities')
                        ->search($data['search'])
                        ->select(['id', 'name', 'code', 'codeSubseries', 'cat_series_id', 'isActive'])
                        ->orderBy('name')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 5) {
                    $elements = CatDescription::with('serie', 'administrative', 'subserie')
                        ->search($data['search'])
                        ->select(['id', 'description', 'cat_series_id', 'isActive'])
                        ->orderBy('description')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 6) {
                    $elements = CatSampling::with('serie')
                        ->select(['id', 'quality', 'cat_series_id', 'isActive'])
                        ->orderBy('quality')
                        ->paginate($data['perPage']);
                }
                if ($data['cat'] == 7) {
                    $elements = CatInventory::select(['id', 'name', 'elaborated', 'revised', 'authorized', 'received', 'viewed', 'isActive'])
                        ->orderBy('name')
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

                $results = CatSeries::doesntHave('sampling')
                    ->where('isActive', 1)
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
                    'results'     => $results,
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
                $duplicityCheck = self::duplicityCheck(CatAdministrativeUnit::class, null, $request->name, $request->specialName, $request->null, $request->null);
            }
            elseif ($request->cat === 2) {
                $cat = new CatSection();
                $duplicityCheck = self::duplicityCheck(CatSection::class, null, $request->name, $request->code, $request->null, $request->null, $request->cat_type_id);
            }
            elseif ($request->cat === 3) {
                $cat = new CatSeries();
                $duplicityCheck = self::duplicityCheck(CatSeries::class, null, $request->name, $request->code, $request->cat_section_id, $request->null);
            }
            elseif ($request->cat === 4) {
                $cat = new CatSubseries();
                $duplicityCheck = self::duplicityCheck(CatSubseries::class, null, $request->name, $request->code, $request->cat_series_id, $request->null);
            }
            elseif ($request->cat === 5) {
                $cat = new CatDescription();
                $duplicityCheck = self::duplicityCheck(CatDescription::class, null, $request->description, $request->cat_series_id, $request->cat_subserie_id, $request->cat_unit_id);
            }
            elseif ($request->cat === 6) {
                $cat = new CatSampling();
                $duplicityCheck = self::duplicityCheck(CatSampling::class, null, $request->quality, $request->cat_series_id, $request->null, $request->null);
            }

            if (! $duplicityCheck) {
                if ($request->cat!==3 && $request->cat!==5){

                    if ($request->cat === 1){
                        $cat->name = $request->name;
                        $cat->specialName = $request->specialName;
                        $cat->determinant = $request->determinant;
                        $cat->cat_type_id = $request->cat_type_id;
                    }

                    if ($request->cat === 2){
                        $cat->name = $request->name;
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
                        $cat->name = $request->name;
                        $cat->code = $request->code;
                        $cat->codeSubseries = $request->codeSubseries;
                        $cat->cat_series_id = $request->cat_series_id;
                    }

                    if ($request->cat === 6){
                        $cat->quality = $request->quality;
                        $cat->cat_series_id = $request->cat_series_id;
                    }

//                    if ($request->cat === 5){
//                        $cat->cat_series_id = $request->cat_series_id;
//                        $cat->cat_subserie_id = $request->cat_subserie_id;
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
                }else if ($request->cat===3){
                    $cat->fill($request->all());
                    $cat->save();
                    $cat->primarivalues()->sync($request->cat_primary_value_id);
                    $cat->administrative()->sync($request->cat_administrative_unit_id);

                    GeneralController::saveTransactionLog(2, 'Se creo elemento en catalogo con id: ' . $cat->id);
                    DB::commit();

                    return response()->json([
                        'success' => true
                    ], 200);

                }else if ($request->cat===5){
              //      dd('entro al cincoooooo', $cat);
                    $cat->fill($request->all());
                    $cat->save();
                    $cat->administrative()->sync($request->cat_unit_id);
                    $cat->subserie()->sync($request->cat_subserie_id);

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
                    'message' => 'Ya existe un registro similar, favor de verificar'
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
                $duplicityCheck = self::duplicityCheck(CatAdministrativeUnit::class, $cat->id, $request->name, $request->specialName, $request->null, $request->null);
            }

            elseif ($request->cat === 2) {
                $cat = CatSection::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSection::class, $cat->id, $request->name, $request->code, $request->null, $request->null, $request->cat_type_id);
            }

            elseif ($request->cat === 3) {
                $cat = CatSeries::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSeries::class, $cat->id, $request->name, $request->code, $request->cat_section_id, $request->null);
            }
            elseif ($request->cat === 4) {
                $cat = CatSubseries::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSubseries::class, $cat->id, $request->name, $request->code, $request->cat_series_id, $request->null);
            }
            elseif ($request->cat === 5) {
                $cat = CatDescription::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatDescription::class, $cat->id, $request->description, $request->cat_series_id, $request->cat_subserie_id, $request->cat_unit_id);
            }

            if (! $duplicityCheck) {
                if ($request->cat !== 5) {
                    $cat->name = $request->name;

                    if ($request->cat === 1) {
                        $cat->specialName = $request->specialName;
                        $cat->determinant = $request->determinant;
                        $cat->cat_type_id = $request->cat_type_id;
                    }

                    if ($request->cat === 2) {
                        $cat->code = $request->code;
                        $cat->cat_type_id = $request->cat_type_id;
                    }

                    if ($request->cat === 3) {
                        $cat->code = $request->code;
                        $cat->codeSeries = $request->codeSeries;
                        $cat->cat_section_id = $request->cat_section_id;
                        $cat->AT = $request->AT;
                        $cat->AC = $request->AC;
                        $cat->total = $request->total;
                        $cat->cat_selection_id = $request->cat_selection_id;
                    }

                    if ($request->cat === 4) {
                        $cat->code = $request->code;
                        $cat->codeSubseries = $request->codeSubseries;
                        $cat->cat_series_id = $request->cat_series_id;
                    }

                    $cat->isActive = true;
//
                    if ($request->cat === 1) {
                        $cat->sectionAll()->sync($request->cat_section_id);
                    }

                    if ($request->cat === 3) {
                        $cat->primarivalues()->sync($request->cat_primary_value_id);
                        $cat->administrative()->sync($request->cat_administrative_unit_id);
                    }

//                if ($request->cat === 5){
//                    $cat->administrative()->sync($request->cat_unit_id);
//                    $cat->subserie()->sync($request->cat_subserie_id);
//                }


                } else if ($request->cat === 5) {
                    //      dd('entro al cincoooooo', $cat);
                    $cat->fill($request->all());
                    $cat->save();
                    $cat->administrative()->sync($request->cat_unit_id);
                    $cat->subserie()->sync($request->cat_subserie_id);

                    GeneralController::saveTransactionLog(2, 'Se creo elemento en catalogo con id: ' . $cat->id);
                    DB::commit();

                    return response()->json([
                        'success' => true
                    ], 200);
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
                    'message' => 'Ya existe un registro similar, favor de verificar'
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

    private static function duplicityCheck($cat, $id, $name, $cat_series_id, $cat_subserie_id, $cat_unit_id, $aux = null, $code = null)
    {
        try {

        //    dd($id, $name, $cat_series_id, $cat_subserie_id, $cat_unit_id, $aux, $code);

            if ($name !=null && $cat_series_id !=null && $cat_unit_id ==null) {
         //       dd('entro a name y code', $name);
                //dd($name,$aux);
                $nam = $cat::where('id', '!=', $id)->where('name', $name)->whereIsactive(true)->first();
                $cod = $cat::where('id', '!=', $id)->where('code', $cat_series_id)->whereIsactive(true)->first();
           //     dd(is_null($nam) && is_null($cod));
                if (is_null($nam) && is_null($cod)) return false;
                else return true;
            }

            if ($name != null && $cat_series_id == null && $cat_subserie_id ==null) {
          //      dd('entro solo a name', $name);
                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
            }

            if ($cat_series_id !=null && $cat_unit_id !=null) {
        //        dd('entro a series');
                $nam = $cat::where('id', '!=', $id)->where('description', $name)->whereIsactive(true)->first();
                $ser = $cat::where('id', '!=', $id)->where('cat_series_id', $cat_series_id)->where(function ($q) use ($cat_unit_id) {
                    $q->whereHas('administrative', function ($q) use ($cat_unit_id){
                        $q->whereIn('id', $cat_unit_id);
                    });
                })->whereIsactive(true)->first();
             //   dd('nam', $ser);
                if (is_null($nam) && is_null($ser)) return false;
                else return true;
            }

            if ($cat_subserie_id !=null && $cat_unit_id !=null) {
         //       dd('entro desc subserie');
                $nam = $cat::where('id', '!=', $id)->where('description', $name)->whereIsactive(true)->first();
                $ser = $cat::where('id', '!=', $id)->where(function ($q) use ($cat_subserie_id) {
                    $q->whereHas('subserie', function ($q) use ($cat_subserie_id){
                        $q->whereIn('id', $cat_subserie_id);
                    });
                })->where(function ($q) use ($cat_unit_id) {
                    $q->whereHas('administrative', function ($q) use ($cat_unit_id){
                        $q->whereIn('id', $cat_unit_id);
                    });
                })->whereIsactive(true)->first();
                //   dd('nam', $ser);
                if (is_null($nam) && is_null($ser)) return false;
                else return true;
            }

      //      dd('salioooooooooooo');
//            if ( is_null($topicId)) {
//                return $cat::where('id', '!=', $id)->where('name', $name)->whereIsactive(true)->first() ? true : false;
//            }
//
//            if ( is_null($rightId)) {
//                return $cat::where('id', '!=', $id)->where('name', $name)->whereIsactive(true)->first() ? true : false;
//            }
//
//            if ( is_null($subrightId)) {
//                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
//            }
//
//            if ( is_null($odsId)) {
//                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
//            }
//
//            if (is_null($acronym)) {
//                return $cat::where('id', '!=', $id)->where('name', $name)->first() ? true : false;
//            }

            else {
          //      dd('entro al else');
                if ($code) {
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
                $cat = CatAdministrativeUnit::find(decrypt($request->id));
            }
            elseif ($request->cat === 2) {
                $cat = CatSection::find(decrypt($request->id));
            }
            elseif ($request->cat === 3) {
                $cat = CatSeries::find(decrypt($request->id));
            }
            elseif ($request->cat === 4) {
                $cat = CatSubseries::find(decrypt($request->id));
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
                $cat = CatAdministrativeUnit::find(decrypt($request->id));
            }
            elseif ($request->cat === 2) {
                $cat = CatSection::find(decrypt($request->id));
            }
            elseif ($request->cat === 3) {
                $cat = CatSeries::find(decrypt($request->id));
            }
            elseif ($request->cat === 4) {
                $cat = CatSubseries::find(decrypt($request->id));
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
