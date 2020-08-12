<?php

namespace App\Http\Controllers;

use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Models\Cats\CatSection;
use App\Http\Models\Cats\CatSeries;
use App\Http\Models\Cats\CatSubseries;
use App\Http\Models\Formalities;
use App\Repositories\Formality\FormalityRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormalitiesController extends Controller
{
    protected $formalityRepo;

    public function __construct(FormalityRepository $formalityRepository)
    {
        $this->formalityRepo = $formalityRepository;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()){
            $data = $request->all();
            if(auth()->user()->cat_profile_id === 1){
                $formalities = Formalities::with('user.determinant')
                    ->search($data['filters'])
                    ->orderBy('created_at', 'DESC')
                    ->paginate($data['perPage']);
            }else{
                $formalities = Formalities::with('user.determinant')
                    ->whereUnitId(auth()->user()->cat_unit_id)
                    ->search($data['filters'])
                    ->orderBy('created_at', 'DESC')
                    ->paginate($data['perPage']);
            }

            return response()->json([
               'formalities' => $formalities,
                'success' => true
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {

            DB::beginTransaction();
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;

            $formality = $this->formalityRepo->create($data);

            GeneralController::saveTransactionLog(2,
                'El usuario con id: '.auth()->user()->id.' Crea un nuevo trámite con id: '. $formality->id);

            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return response()->json([
                'success' => true,
                'formality' => $this->formalityRepo->find($id)
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        try {

            $formality = $this->formalityRepo->find($id);
            $formality->primariValues = $formality->serie->primarivalues;
            return response()->json([
                'success' => true,
                'formality' =>$formality
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $formality = $this->formalityRepo->update($id,$request->all());

            GeneralController::saveTransactionLog(2,
                'Edita un trámite con id: ' . $formality->id);

            DB::commit();

            return response()->json([
                'success' => true,
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        try {
            DB::beginTransaction();

            $this->formalityRepo->delete($id);

            DB::commit();
            return response()->json([
                'success' => true,
            ]);
        }
        catch ( \Exception $e ) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allSection(Request $request)
    {
        $data = $request->all();
        $id = isset($data['unit_id']) ? (int)$data['unit_id'] : null;

        try {
            $sections = CatAdministrativeUnit::find($id);
            if (!is_null($sections->sectionAll)) {
                return response()->json([
                    'success' => true,
                    'sections' =>$sections->sectionAll
                ]);
            }
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allSeries(Request $request)
    {
        try {
            $serie = $request->all();
            return response()->json([
                'success' => true,
                'series' =>CatSeries::with('primarivalues','descriptions')->whereCatSectionId($serie['id'])->get()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allSubSeries(Request $request)
    {
        try {

            $subSerie = $request->all();

            return response()->json([
                'success' => true,
                'subSeries' =>CatSubseries::with('descrip')->orderBy('name')->whereCatSeriesId($subSerie['id'])->get()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function SortCode(Request $request)
    {
        try {
            $data = $request->all();

            return response()->json([
                'success' => true,
                'total' =>Formalities::where('sort_code', 'like', $data['code'].'%')->count()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allUserUnit(Request $request)
    {
        try {
            if(auth()->user()->cat_profile_id === 1){
                $usersId = Formalities::all()->pluck('user_id');
            }else{
                $usersId = Formalities::whereUnit_id(auth()->user()->cat_unit_id)->get()->pluck('user_id');
            }

            return response()->json([
                'success' => true,
                'users' => User::whereIn('id',$usersId)->get()
            ]);
        }
        catch ( \Exception $e ) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
