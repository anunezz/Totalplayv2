<?php
namespace App\Http\Controllers\Administrador\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Models\Cats\CatGoalsOds;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatSubRights;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Cats\CatTopic;
use App\Http\Models\DocumentRecommendation;
use DB;
use Exception;
use Illuminate\Http\Request;
use Cache;

class CatalogsController extends Controller
{
    public function getCatalogos(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $data = $request->all();
                $elements = null;

                if ($data['cat'] == 1) {
                    $elements = CatEntity::search($data['search'])
                        ->select(['name', 'id', 'acronym', 'isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 2) {
                    $elements = CatGobOrder::search($data['search'])
                        ->select(['name','id', 'isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 3) {
                    $elements = CatGobPower::search($data['search'])
                        ->select(['name','id', 'isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 4) {
                    $elements = CatAttending::search($data['search'])
                        ->select(['name','id', 'acronym','isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 5) {
                    $elements = CatPopulation::search($data['search'])
                        ->select(['name','id', 'isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 6) {
                    $elements = CatSolidarityAction::search($data['search'])
                        ->select(['name','id','isActive', 'acronym'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 7) {
                    $elements = CatOds::search($data['search'])
                        ->select(['name','id','isActive', 'acronym'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 8) {
                    $elements = CatTopic::search($data['search'])
                        ->select(['name','id', 'isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 9) {
                    $elements = CatRightsRecommendation::search($data['search'])
                        ->select(['name','id','isActive'])
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 10) {
                    $elements = CatSubtopic::search($data['search'])
                        ->select(['name','id','cat_topic_id','isActive'])
                        ->with('topics:id,name')
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 11) {
                    $elements = CatSubRights::search($data['search'])
                        ->select(['name','id', 'rights_recommendations_id','isActive'])
                        ->with('rigthRecommendation:id,name')
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 12) {
                    $elements = CatSubcategorySubrights::search($data['search'])
                        ->select(['name','id', 'sub_rights_id','isActive'])
                        ->with('subRight:id,name')
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }
                elseif ($data['cat'] == 13) {
                    $elements = CatGoalsOds::search($data['search'])
                        ->select(['name','id','ods_id','acronym','isActive'])
                        ->with('ods:id,name')
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }

                return response()->json([

                    'elements'    => $elements,
                    'success'     => true
                ]);

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ){

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
                $cat = new CatEntity();
                $duplicityCheck = self::duplicityCheck(CatEntity::class, null, $request->name, $request->acronym);
            }
            elseif ($request->cat === 2) {
                $cat = new CatGobOrder();
                $duplicityCheck = self::duplicityCheck(CatGobOrder::class, null, $request->name);
            }
            elseif ($request->cat === 3) {
                $cat = new CatGobPower();
                $duplicityCheck = self::duplicityCheck(CatGobPower::class, null, $request->name);
            }
            elseif ($request->cat === 4) {
                $cat = new CatAttending();
                $duplicityCheck = self::duplicityCheck(CatAttending::class, null, $request->name, $request->acronym);
            }
            elseif ($request->cat === 5) {
                $cat = new CatPopulation();
                $duplicityCheck = self::duplicityCheck(CatPopulation::class, null, $request->name);
            }
            elseif ($request->cat === 6) {
                $cat = new CatSolidarityAction();
                $duplicityCheck = self::duplicityCheck(CatSolidarityAction::class, null, $request->name, $request->acronym);
            }
            elseif ($request->cat === 7) {
                $cat = new CatOds();
                $duplicityCheck = self::duplicityCheck(CatOds::class, null, $request->name, $request->acronym);
            }
            elseif ($request->cat === 8) {
                $cat = new CatTopic();
                $duplicityCheck = self::duplicityCheck(CatTopic::class, null, $request->name);
            }
            elseif ($request->cat === 9) {
                $cat = new CatRightsRecommendation();
                $duplicityCheck = self::duplicityCheck(CatRightsRecommendation::class, null, $request->name);
            }
            elseif ($request->cat === 10) {
                $cat = new CatSubtopic();
                $duplicityCheck = self::duplicityCheck(CatSubtopic::class, null, $request->name, $request->cat_topic_id);
            }
            elseif ($request->cat === 11) {
                $cat = new CatSubRights();
                $duplicityCheck = self::duplicityCheck(CatSubRights::class, null, $request->name, $request->rights_recommendations_id);
            }
            elseif ($request->cat === 12) {
                $cat = new CatSubcategorySubrights();
                $duplicityCheck = self::duplicityCheck(CatSubcategorySubrights::class, null, $request->name, $request->sub_rights_id);
            }
            elseif ($request->cat === 13) {
                $cat = new CatGoalsOds();
                $duplicityCheck = self::duplicityCheck(CatGoalsOds::class, null, $request->name, $request->ods_id, $request->acronym);

            }


            if (! $duplicityCheck) {

                $cat->name = $request->name;

                $request->cat === 1 ? $cat->acronym = $request->acronym : null;

                $request->cat === 4 ? $cat->acronym = $request->acronym : null;

                $request->cat === 6 ? $cat->acronym = $request->acronym : null;

                $request->cat === 7 ? $cat->acronym = $request->acronym : null;

                $request->cat === 10 ? $cat->cat_topic_id = $request->cat_topic_id : null;

                $request->cat === 11 ? $cat->rights_recommendations_id = $request->rights_recommendations_id : null;

                $request->cat === 12 ? $cat->sub_rights_id = $request->sub_rights_id : null;

                if ($request->cat === 13){
                    $cat->ods_id = $request->ods_id;
                    $cat->acronym = $request->acronym;
                }

                $cat->save();
                GeneralController::saveTransactionLog(2, 'Se creo elemento en catalogo con id: ' . $cat->id);
                DB::commit();
                Cache::forget('dashboard');

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

                $cat = CatEntity::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatEntity::class, $cat->id, $request->name, $request->acronym);
            }

            elseif ($request->cat === 2) {

                $cat = CatGobOrder::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatGobOrder::class, $cat->id, $request->name);
            }

            elseif ($request->cat === 3) {

                $cat = CatGobPower::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatGobPower::class, $cat->id, $request->name);
            }

            elseif ($request->cat === 4) {

                $cat = CatAttending::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatAttending::class, $cat->id, $request->name, $request->acronym);
            }

            elseif ($request->cat === 5) {

                $cat = CatPopulation::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatPopulation::class, $cat->id, $request->name);
            }

            elseif ($request->cat === 6) {

                $cat = CatSolidarityAction::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSolidarityAction::class, $cat->id, $request->name, $request->acronym);
            }

            elseif ($request->cat === 7) {

                $cat = CatOds::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatOds::class, $cat->id, $request->name, $request->acronym);
            }

            elseif ($request->cat === 8) {

                $cat = CatTopic::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatTopic::class, $cat->id, $request->name);
            }

            elseif ($request->cat === 9) {

                $cat = CatRightsRecommendation::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatRightsRecommendation::class, $cat->id, $request->name);
            }

            elseif ($request->cat === 10) {

                $cat = CatSubtopic::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSubtopic::class, $cat->id, $request->name, $request->cat_topic_id);
            }

            elseif ($request->cat === 11) {

                $cat = CatSubRights::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSubRights::class, $cat->id, $request->name, $request->rights_recommendations_id);
            }

            elseif ($request->cat === 12) {

                $cat = CatSubcategorySubrights::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatSubcategorySubrights::class, $cat->id, $request->name, $request->sub_rights_id);
            }

            elseif ($request->cat === 13) {
                $cat = CatGoalsOds::find(decrypt($request->id));
                $duplicityCheck = self::duplicityCheck(CatGoalsOds::class, $cat->id, $request->name, $request->ods_id, $request->acronym);
            }



            if (! $duplicityCheck) {
                $cat->name = $request->name;
                $request->cat === 1 ? $cat->acronym = $request->acronym : null;
                $request->cat === 4 ? $cat->acronym = $request->acronym : null;
                $request->cat === 6 ? $cat->acronym = $request->acronym : null;
                $request->cat === 7 ? $cat->acronym = $request->acronym : null;
                $request->cat === 10 ? $cat->cat_topic_id = $request->cat_topic_id : null;
                $request->cat === 11 ? $cat->rights_recommendations_id = $request->rights_recommendations_id : null;
                $request->cat === 12 ? $cat->sub_rights_id = $request->sub_rights_id : null;
                if ($request->cat === 13){
                    $cat->ods_id = $request->ods_id;
                    $cat->acronym = $request->acronym;
                }

                $cat->isActive = true;

                $cat->save();

                GeneralController::saveTransactionLog(3, 'Se actualizo elemento en catalogo con id: ' . $cat->id);
                DB::commit();
                Cache::forget('dashboard');

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
                $cat = CatEntity::find(decrypt($request->id));
            }
            elseif ($request->cat === 2) {
                $cat = CatGobOrder::find(decrypt($request->id));
            }
            elseif ($request->cat === 3) {
                $cat = CatGobPower::find(decrypt($request->id));
            }
            elseif ($request->cat === 4) {
                $cat = CatAttending::find(decrypt($request->id));
            }
            elseif ($request->cat === 5) {
                $cat = CatPopulation::find(decrypt($request->id));
            }
            elseif ($request->cat === 6) {
                $cat = CatSolidarityAction::find(decrypt($request->id));
            }
            elseif ($request->cat === 7) {
                $cat = CatOds::find(decrypt($request->id));
            }
            elseif ($request->cat === 8) {
                $cat = CatTopic::find(decrypt($request->id));
            }
            elseif ($request->cat === 9) {
                $cat = CatRightsRecommendation::find(decrypt($request->id));
            }
            elseif ($request->cat === 10) {
                $cat = CatSubtopic::find(decrypt($request->id));
            }
            elseif ($request->cat === 11) {
                $cat = CatSubRights::find(decrypt($request->id));
            }
            elseif ($request->cat === 12) {
                $cat = CatSubcategorySubrights::find(decrypt($request->id));
            }
            elseif ($request->cat === 13) {
                $cat = CatGoalsOds::find(decrypt($request->id));
            }

            $cat->isActive = false;
            $cat->save();

            GeneralController::saveTransactionLog(3, 'Se deshabilito elemento en catalogo con id: ' . $cat->id);
            DB::commit();
            Cache::forget('dashboard');

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
                $cat = CatEntity::find(decrypt($request->id));
            }
            elseif ($request->cat === 2) {
                $cat = CatGobOrder::find(decrypt($request->id));
            }
            elseif ($request->cat === 3) {
                $cat = CatGobPower::find(decrypt($request->id));
            }
            elseif ($request->cat === 4) {
                $cat = CatAttending::find(decrypt($request->id));
            }
            elseif ($request->cat === 5) {
                $cat = CatPopulation::find(decrypt($request->id));
            }
            elseif ($request->cat === 6) {
                $cat = CatSolidarityAction::find(decrypt($request->id));
            }
            elseif ($request->cat === 7) {
                $cat = CatOds::find(decrypt($request->id));
            }
            elseif ($request->cat === 8) {
                $cat = CatTopic::find(decrypt($request->id));
            }
            elseif ($request->cat === 9) {
                $cat = CatRightsRecommendation::find(decrypt($request->id));
            }
            elseif ($request->cat === 10) {
                $cat = CatSubtopic::find(decrypt($request->id));
            }
            elseif ($request->cat === 11) {
                $cat = CatSubRights::find(decrypt($request->id));
            }
            elseif ($request->cat === 12) {
                $cat = CatSubcategorySubrights::find(decrypt($request->id));
            }
            elseif ($request->cat === 13) {
                $cat = CatGoalsOds::find(decrypt($request->id));
            }

            $cat->isActive = true;
            $cat->save();

            GeneralController::saveTransactionLog(3, 'Se habilito elemento en catalogo con id: ' . $cat->id);
            DB::commit();
            Cache::forget('dashboard');

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

    public function disableOrder($id)
    {
        try {

            $orders   = CatGobOrder::find(decrypt($id));

            $orders->isActive = false;
            $orders ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableEntity($id)
    {
        try {

            $entities   = CatEntity::find(decrypt($id));

            $entities->isActive = false;
            $entities ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disablePower($id)
    {
        try {

            $powers   = CatGobPower::find(decrypt($id));
            $powers->isActive = false;
            $powers ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableAttendig($id)
    {
        try {

            $attending  = CatAttending::find(decrypt($id));
            $attending->isActive = false;
            $attending ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disablePopulation($id)
    {
        try {

            $population  = CatPopulation::find(decrypt($id));
            $population ->isActive = false;
            $population ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableAction($id)
    {
        try {

            $action  = CatSolidarityAction::find(decrypt($id));
            $action ->isActive = false;
            $action ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableOds($id)
    {
        try {

            $ods  = CatOds::find(decrypt($id));
            $ods ->isActive = false;
            $ods ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableTopic($id)
    {
        try {

            $topic  = CatTopic::find(decrypt($id));
            $topic ->isActive = false;
            $topic ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableRight($id)
    {
        try {

            $right  = CatRightsRecommendation::find(decrypt($id));
            $right ->isActive = false;
            $right ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableSubtopic($id)
    {
        try {

            $subtopic  = CatSubtopic::find(decrypt($id));
            $subtopic ->isActive = false;
            $subtopic ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableSubright($id)
    {
        try {

            $subright  = CatSubRights::find(decrypt($id));
            $subright ->isActive = false;
            $subright ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableSubcategory($id)
    {
        try {

            $subcategory = CatSubcategorySubrights::find(decrypt($id));
            $subcategory ->isActive = false;
            $subcategory ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableGoalsOds($id)
    {
        try {

            $goalsods  = CatGoalsOds::find(decrypt($id));
            $goalsods ->isActive = false;
            $goalsods ->save();

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function searchCats(Request $request)
    {
        try {
            $data = $request->all();

            switch ($data['data']['name']) {
                case 'authorityAttending':
                {
                    $datos = $data['data'];
                    $results = CatAttending::where('isActive', 1)
                    ->where(function ($query) use ($datos) {
                           if(  ( $datos['action'] === "acronym" || $datos['action'] === "name" ) AND strlen($datos['search']) > 0 ){
                              return $query->where($datos['action'], 'like', '%'.$datos['search'].'%');
                           }else if(strlen($datos['action']) > 0 AND $datos['action'] === 'all' ){
                              return $query->where('isActive',1 );
                           }
                    })->paginate($data['perPage']);;

                 break;
                }

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo completar la acción',
                    ], 500);
                break;
            }

            return response()->json([
                'success' => true,
                'lResults' => $results
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }


}
