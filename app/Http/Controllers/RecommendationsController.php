<?php

namespace App\Http\Controllers;

//use App\Consulate;
use App\Http\Models\Consulate;
use App\Exports\RecommendationExport;
use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatConsulate;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGoalsOds;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatDate;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatSubRights;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\DataControl;
use App\Http\Models\Document;
use App\Http\Models\Recommendation;
use App\Http\Models\ReportedAction;
use App\Http\Traits\TopicsTrait;
use App\Imports\RecommendationsImport;
use Cache;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\RightsTrait;
use App\Http\Models\Files;
use App\Http\Models\DocumentRecommendation;
use App\User;

use App\Http\Traits\GoalsOdsTrait;
use phpDocumentor\Reflection\File;

class RecommendationsController extends Controller
{


    public function index(Request $request)
    {
        try {
            if ($request->wantsJson()){
                $data = $request->all();

                $recommendations = Consulate::with('user', 'consulate')
                    ->where('isActive', true)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate($data['perPage']);

                return response()->json([
                    'recommendations' => $recommendations,
                    'success'         => true
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

    public function documents(Request $request)
    {
        try {
            if ($request->wantsJson()){
                $data = $request->all();

                $documents = Files::select(['title','description','document_id','id','created_at','isPublished'])
                    ->with('documents:id,fileName,fileNameHash,downloadCount')
                    ->where('isActive', true)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate($data['perPage']);

                return response()->json([
                    'documents' => $documents,
                    'success'   => true
                ]);

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function getGonsult(Request $request){
        try {

             $data = $request->all();
             $search = json_decode($data['filters']);

            $recommendations = Recommendation::with('user', 'ods', 'entity:id,name',
                'order', 'power')
                ->consult($search)
                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);


            return response()->json([
                'recommendations' => $recommendations,
                'success'         => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function create(Request $request)
    {
        try {
            if ($request->wantsJson()){

                $consulates = CatConsulate::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                return response()->json([
                    'consulates'  => $consulates,
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


    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->recommendation;

            $recommendation = new Consulate();
            $recommendation->user_id = auth()->user()->id;
            $recommendation->fill($data);
            $recommendation->save();

            GeneralController::saveTransactionLog(2,
                'Crea una nueva recomendación con id: ' . $recommendation->id);

            DB::commit();
            Cache::forget('dashboard');
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

    public function saveDocument(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = new Document();
            $path = 'recommendations/files';
            $document = $request->document;
            $nameHash = encrypt($file->id) . '.' . $document->extension();

            $file->isActive = 1;
            $file->isType = 1;
            $file->save();

            $document->storeAs($path, $nameHash);

            DB::commit();

            return response()->json([
                'success'    => true,
                'documentId' => $file->id
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


    public function edit(Request $request, $id)
    {
        try {
                $entities = CatEntity::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $orders = CatGobOrder::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $powers = CatGobPower::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $attendings = CatAttending::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);


                $populations = CatPopulation::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $actions = CatSolidarityAction::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);


                $subtopics = CatSubtopic::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $dates = CatDate::where('isActive', 1)
                    ->orderBy('name')
                    ->get(['id', 'name']);

                $relations = ['order', 'power', 'attendig', 'population','dataControl',
                    'right', 'subright','subcategory', 'subtopic','goalsOds','docs','topic:id'];

                $recommendation = Recommendation::with($relations)->find(decrypt($id));

                $rights = RightsTrait::orderRights($recommendation->right->all(),$recommendation->subright->all(),$recommendation->subcategory->all());

                $topics = TopicsTrait::orderTopics($recommendation->subtopic->all(),$recommendation->topic->all());

                $goalsOds = GoalsOdsTrait::orderOds($recommendation->goalsOds->all());



                $recommendationForm = [
                    'recommendation'               => $recommendation->recommendation,
                    'validity'                     => $recommendation->validity,
                    'directed'                     => $recommendation->directed,
                    'cat_entity_id'                => $recommendation->cat_entity_id,
                    'cat_gob_order_id'             => $recommendation->order->pluck('id')->toArray(),
                    'cat_gob_power_id'             => $recommendation->power->pluck('id')->toArray(),
                    'cat_attendig_id'              => $recommendation->attendig->pluck('id')->toArray(),
                    'cat_population_id'            => $recommendation->population->pluck('id')->toArray(),
                    'cat_solidarity_action_id'     => $recommendation->action->pluck('id')->toArray(),
                    'cat_review_right_id'          => $recommendation->cat_review_right_id,
                    'cat_review_topic_id'          => $recommendation->cat_review_topic_id,
                    'date'                         => $recommendation->date,
                    'comments'                     => $recommendation->comments,
                    'invoice'                      => $recommendation->invoice,
                    'listRights'                   => $rights['listR'],
                    'listThemes'                   => $topics['listThemes'],
                    'listGoalsOds'                 => $goalsOds['listOds'],
                    'idsTopics'                    => $topics['idsTopics'],
                    'documents'                    => $recommendation->docs->pluck('id')->toArray(),
                    'dataControl'                  => $recommendation->dataControl,
                    'isPublished'                  => $recommendation->isPublished,
                ];

                Cache::forget('dashboard');

                return response()->json([
                    'entities'           => $entities,
                    'orders'             => $orders,
                    'populations'        => $populations,
                    'actions'            => $actions,
                    'dates'              => $dates,
                    'powers'             => $powers,
                    'attendings'         => $attendings,
                    'subtopics'          => $subtopics,
                    'recommendationForm' => $recommendationForm,
                    'success'            => true,
                    'showIds'            => $rights['showIds'],
                    'rights'             => $rights['rights'],
                    'showIde'            => $topics['showIde'],
                    'showOdsIds'         => $goalsOds['showOdsIds'],
                    'topics'             => $topics['tree'],
                    'goalsOds'           => $goalsOds['tree'],
                    'folioRe'            =>$recommendation->invoice,
                ]);


        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $control = $data['dataControl'];
            $recommendation = Recommendation::find(decrypt($id));
            $recommendation->fill($data);
            $recommendation->save();

            $recommendation->docs()->sync($data['documents']);

            $dataControl = DataControl::find($control['id']);
            $dataControl->fill($control);
            $dataControl->save();

            $recommendation->right()->detach();

            $listRights=[];
            foreach ($data['listRights'] as $item){
                $listRights[$item['right_id']]=[
                    'subrigth_id' => $item['subrights_id'],
                    'subcategory_subrights_id' => $item['subcategory_id']
                ];
                $recommendation->right()->attach($listRights);
                $listRights=[];
            }
            $listGoalsOds=[];
            foreach ($data['listGoalsOds'] as $item){
                $listGoalsOds[$item['cat_goal_id']]=[
                    'ods_id' => $item['ods_id']
                ];
            }
            $recommendation->goalsOds()->sync($listGoalsOds);

              /*$listThemes=[];
              foreach ($data['listThemes'] as $item) {
                  $listThemes[$item['cat_subtopic_id']] = [
                      'cat_topic_id' => $item['cat_topic_id']
                  ];
              }
                  $recommendation->subtopic()->sync($listThemes);*/
            $recommendation->topic()->detach();

            $listThemes=[];
            foreach ($data['listThemes'] as $item){
                $listThemes[$item['cat_topic_id']]=[
                    'cat_subtopic_id' => $item['cat_subtopic_id']
                ];
                $recommendation->topic()->attach($listThemes);
                $listThemes=[];
            }

            foreach ($data['idsTopics'] as $item){
                $listThemes[$item]=[
                    'cat_subtopic_id' => null
                ];
                $recommendation->topic()->attach($listThemes);
                $listThemes=[];
            }


            /*if ( count($data['cat_ods_id']) > 0 ) {
                $recommendation->ods()->sync($data['cat_ods_id']);
            }*/

            if ( count($data['cat_gob_order_id']) > 0 ){
                $recommendation->order()->sync($data['cat_gob_order_id']);
            }

            if ( count($data['cat_gob_power_id']) > 0 ){
                $recommendation->power()->sync($data['cat_gob_power_id']);
            }

            if ( count($data['cat_attendig_id']) > 0 ){
                $recommendation->attendig()->sync($data['cat_attendig_id']);
            }

            if ( count($data['cat_population_id']) > 0 ){
                $recommendation->population()->sync($data['cat_population_id']);
            }

            if ( count($data['cat_solidarity_action_id']) > 0 ){
                $recommendation->action()->sync($data['cat_solidarity_action_id']);
            }


            if ( count($data['files']) > 0 ) {
                foreach ( $data['files'] as $file ) {
                    $recommendationDocument = Document::find($file);

                    $recommendationDocument->recommendation_id = $recommendation->id;
                    $recommendationDocument->isActive = true;
                    $recommendationDocument->save();
                }
            }


            GeneralController::saveTransactionLog(2,
                'Edita una recomendación con id: ' . $recommendation->id);

            DB::commit();
            Cache::forget('dashboard');
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

    public function publish(Request $request)
    {
        try {

            $recommendation = Recommendation::find(decrypt($request->id));

            $recommendation->isPublished = true;
            $recommendation->save();
            Cache::forget('dashboard');
            GeneralController::saveTransactionLog(5,
                'Publica una recomendación con id: ' . $recommendation->id);
            Cache::forget('dashboard');
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

    public function unpublish(Request $request)
    {
        try {

            $recommendation = Recommendation::find(decrypt($request->id));

            $recommendation->isPublished = false;
            $recommendation->save();

            GeneralController::saveTransactionLog(5,
                'Despublica una recomendación con id: ' . $recommendation->id);
            Cache::forget('dashboard');
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


    public function destroy($id)
    {
        try {

            $recommendation = Recommendation::find(decrypt($id));

            $recommendation->isActive = false;
            $recommendation->save();

            GeneralController::saveTransactionLog(4,
                'Elimina una recomendación con id: ' . $recommendation->id);
            Cache::forget('dashboard');
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

    public function uploadFile(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = new Document();
            $path = 'recommendations/files';
            $document = $request->document;
            $nameHash = encrypt($file->id) . '.' . $document->extension();

            $file->user_id = auth()->user()->id;
            $file->isActive=1;
            $file->isType= 2;
            $file->fileNameHash = $nameHash;
            $file->fileName = $document->getClientOriginalName();
            $file->save();

            $document->storeAs($path, $nameHash);

            DB::commit();

            return response()->json([
                'success'    => true,
                'documentId' => $file->id,
                'name'      =>$document->getClientOriginalName(),
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

    public function getFile($id)
    {
        try {

            $document   = Document::find(decrypt($id));
            $pathToFile = storage_path() . '/app/recommendations/files/' . $document->fileNameHash;


            return response()->download(
                $pathToFile,
                $document->fileName,
                [],
                'inline'
            );
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function disableFile($id)
    {
        try {

            $document   = Document::find(decrypt($id));

            $document->isActive = false;
            $document->save();

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

    public function readExcel(Request $request)
    {
        try {
            DB::beginTransaction();

            /*$path = '/';
            $document = $request->document;

            $document->storeAs($path, 'Recomendaciones.xlsm');*/
            Excel::import(new RecommendationsImport, $request->document);
            DB::commit();
            Cache::forget('dashboard');
            $erros = session('errorMasivo');
            session()->forget(['errorsReportedActions', 'reportedActions','errorMasivo']);
            return response()->json([
                'success'    => true,
                'filas'      => $erros
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

    public function getImages($id)
    {
        try {

            $document   = Document::find(decrypt($id));
            $pathToFile = storage_path() . '/app/recommendations/files/' . $document->fileNameHash;


            return response()->download(
                $pathToFile,
                $document->fileName,
                [],
                'inline'
            );
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

    public function publicDocuments(Request $request)
    {
        try {
            if ($request->wantsJson()){
            $data = $request->all();

            $documents = Files::select(['title','description','document_id','id','created_at','isPublished'])
                ->with('documents:id,fileName,fileNameHash,downloadCount')
                ->where('isActive', true)
                ->where('isPublished', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'documents' => $documents,
                'success'   => true
            ]);

            }else{
                return response()->view('errors.404', [], 404);
            }

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }



    public function saveFile(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $files = new files();

            $data['title'];

            //$files->user_id = auth()->user()->id;
            $files->fill($data);
            $files->document_id = $data['files'][0];
            $files->save();


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

    public function files(Request $request)
    {
        try {

            $data = $request->all();
            $files = Files::select(['title','description'])

                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);

            return response()->json([
                'files' => $files,
                'success'   => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function publishDoc(Request $request)
    {
        try {

            $files = Files::find(decrypt($request->id));

            $files->isPublished = true;
            $files->save();

            GeneralController::saveTransactionLog(5,
                'Publica una recomendación con id: ' . $files->id);

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

    public function unpublishDoc(Request $request)
    {
        try {

            $files = Files::find(decrypt($request->id));

            $files->isPublished = false;
            $files->save();

            GeneralController::saveTransactionLog(5,
                'Despublica una recomendación con id: ' . $files->id);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción ',
            ], 500);
        }

    }

    public function disableFilePdf($id)
    {
        try {

            $files   = Files::find(decrypt($id));

            $files->isActive = false;
            $files->save();

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

    public function editDocuments(Request $request, $id)
    {
        try {
            $files = Files::with('documents:id,fileName')->where('id', decrypt($id))->where('isActive', 1)
                ->orderBy('title')
                ->first(['id', 'title', 'description', 'document_id']);


            return response()->json([
                'files'     => $files,
                'success'   => true

            ]);

        }

        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function updateDoc(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $files = Files::find(decrypt($id));

            $files->title = $data['text']['title'];
            $files->description = $data['text']['description'];
            $files->document_id = $data['newfile'];
            $files->isPublished = $data['isPublish'];

            $files->save();

            GeneralController::saveTransactionLog(2,
                'Edita un documento con id: ' . $files->id);

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


    public function updateDocPubli(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $data = $request->all();
            $files = Files::find(decrypt($id));

            $files->title = $data['text']['title'];
            $files->description = $data['text']['description'];
            $files->document_id = $data['newfile'];
            $files->isPublished = true;

            $files->save();


            GeneralController::saveTransactionLog(2,
                'Edita un documento con id: ' . $files->id);

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

    public function createEntities()
    {
        try {

            $entities = CatEntity::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $topics = CatTopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $subtopics = CatSubtopic::where('isActive', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'cat_topic_id']);



            return response()->json([
                'entities'    => $entities,
                'topics'      => $topics,
                'subtopics'   => $subtopics,
                'success'     => true
            ]);

        }
        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function saveEntities(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $entities = new CatEntity();

            $entities->fill($data);
            $entities->save();

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


    public function uploadFileRecommendation(Request $request)
    {
        try {
            DB::beginTransaction();

            $file = new Document();
            $path = 'recommendations/files';
            $document = $request->document;
            $nameHash = encrypt($file->id) . '.' . $document->extension();

            $file->user_id = auth()->user()->id;
            $file->isActive=1;
            $file->isType= 1;
            $file->fileNameHash = $nameHash;
            $file->fileName = $document->getClientOriginalName();

            $file->save();

            $document->storeAs($path, $nameHash);

            DB::commit();

            return response()->json([
                'success'    => true,
                'documentId' => $file->id
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

    public function recommendationDocuments(Request $request)
    {
        try {
            if ($request->wantsJson()){
                $data = $request->all();
                $documents = null;
                if (isset($data['transfer'])){
                    $documents = DocumentRecommendation::whereIsactive(1)->get();
                }
                else{
                    $documents = DocumentRecommendation::select(['folio','document_id','id','isActive'])
                        ->with('documents:id,fileName,fileNameHash,downloadCount')
                        ->where('isActive', true)
                        ->orderBy('updated_at', 'DESC')
                        ->paginate($data['perPage']);
                }

                return response()->json([
                    'documents' => $documents,
                    'success'   => true
                ]);
            }else{
                return response()->view('errors.404', [], 404);
            }
        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function disableDocumentPdf($id)
    {
        try {

            $documents   = DocumentRecommendation::find(decrypt($id));

            $documents->isActive = false;
            $documents->save();

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


    public function saveDoc(Request $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->all();

            $entidad = CatEntity::find($data['cat_entity_id']);
            $siglasE = $siglasE = explode("-", $entidad->acronym);
            $num = DocumentRecommendation::where('cat_entity_id',$data['cat_entity_id'])->count();
            $num++;
            $R = 'R';
            while (strlen($num)<4){
                $num= '0'.$num;
            }
            $folio = $R.$siglasE[0].$data['date'].$num;
            $data['folio'] = $folio;

            $files = new DocumentRecommendation();

            $files->fill($data);
            $files->document_id = $data['files'][0];

            $files->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'folio' => $folio,
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

    public function editDoc(Request $request, $id)
    {
        try {

            $files = Document::where('id', decrypt($id))->where('isActive', 1)
                ->orderBy('fileName')
                ->get(['id', 'fileName']);


            return response()->json([
                'files'     => $files,
                'success'   => true

            ]);
        }

        catch ( \Exception $e ) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function disableDocument($id)
    {
        try {

            $document   = Document::find(decrypt($id));

            $document->isActive = false;
            $document->save();

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

    public function searchCatalogs(Request $request)
    {
        try{
            $data = $request->all();

            $users = CatGoalsOds::ofType($data['filters'])->where('isActive', true)
                            ->paginate($data['perPage']);;

            /*dd(json_decode($data['filters']));
            $recommendations = Recommendation::with('user', 'ods', 'entity:id,name',
                'order', 'power')
                ->consult($search)
                ->where('isActive', true)
                ->orderBy('updated_at', 'DESC')
                ->paginate($data['perPage']);*/


            return response()->json([
                'recommendations' => $recommendations,
                'success'         => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function advancedFiltersRecommendation(Request $request)
    {
        try{

            $data = $request->all();
            if( count( $data['filters']['topics'][0]['cat_topic_id'] ) === 0 &&
                count( $data['filters']['topics'][0]['cat_subtopic_id'] ) === 0){
                $data['filters']['topics'] = [];
            }

            if( isset($data['filters']) ){
               $results = Recommendation::PublicConsult($data['filters'])
                ->where('isActive', 1) //->where('isPublished', 1)
                ->distinct('id')
                ->orderBy('id', 'desc')
                ->paginate($data['perPage']);

            }

            // if(isset($data['deleteId'])  ){
            //     $results = Recommendation::whereIn('id',$data['deleteId'])->get();
            //     foreach ($results as $d) {
            //       $d->power()->detach();
            //       $d->attendig()->detach();
            //       $d->action()->detach();
            //       $d->population()->detach();
            //       $d->order()->detach();
            //       $d->right()->detach();
            //       $d->topic()->detach();
            //       $d->ods()->detach();
            //       $d->docs()->detach();

            //         foreach ($d->reportedaction as $act) {
            //             $act->population()->detach();
            //             $act->action()->detach();
            //             $act->attendig()->detach();
            //             $act->delete();
            //         }

            //        $d->dataControl()->delete();
            //        $d->delete();
            //     }
            // }

            return response()->json([
                'lResults' => $results,
                'success' => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCatsFilters()
    {
        try{


            $CatDate = Recommendation::select('date')
            ->where('isActive', 1)
            ->where('isPublished', 1)
            ->distinct('date')
            ->orderBy('date', 'desc')
            ->get();

            $entities = CatEntity::select('id','name')->where('isActive',true)->get();

            $arrayaDate = array();
            foreach ($CatDate as $date) {
                array_push($arrayaDate, $date->date);
            }

            $results = ["date"=>$arrayaDate,
                        "entities"=>$entities];

            return response()->json([
                'lResults' => $results,
                'success'         => true
            ]);

        }
        catch ( \Exception $e ){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }



    public function downloadExcel(Request $request)
    {
        try{
        $data = $request->all();
        if( count( $data['filters']['topics'][0]['cat_topic_id'] ) === 0 &&
            count( $data['filters']['topics'][0]['cat_subtopic_id'] ) === 0){
            $data['filters']['topics'] = [];
        }

        if( isset($data['filters']) ){
           $results = Recommendation::PublicConsult($data['filters'])
            ->where('isActive', 1)
            ->distinct('id')
            ->orderBy('id', 'desc')
            ->get();
        }
        //El título no se muestra ya que lo imprime desde front
        return Excel::download(new RecommendationExport($results),'Recomendaciones.xlsx');

       }catch ( \Exception $e ){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
