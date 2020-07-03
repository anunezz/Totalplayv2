<?php namespace App\Http\Models;

use App\Http\Models\Cats\CatAttending;
use App\Http\Models\Cats\CatEntity;
use App\Http\Models\Cats\CatGoalsOds;
use App\Http\Models\Cats\CatOds;
use App\Http\Models\Cats\CatGobOrder;
use App\Http\Models\Cats\CatGobPower;
use App\Http\Models\Cats\CatDate;
use App\Http\Models\Cats\CatPopulation;
use App\Http\Models\Cats\CatSolidarityAction;
use App\Http\Models\Cats\CatSubcategorySubrights;
use App\Http\Models\Cats\CatSubRights;
use App\Http\Models\Cats\CatRightsRecommendation;
use App\Http\Models\Cats\CatSubtopic;
use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\DataControl;
use App\Http\Traits\CustomModelLogic;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Recommendation
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description

 * @property int|null $cat_entitie_id
 * @property int|null $cat_gob_order_id
 * @property int|null $cat_population_id
 * @property int|null $cat_solidarity_action_id
 * @property int|null $cat_date_id
 * @property int|null $user_id
 * @property int|null $cat_od_id
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatEntitieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatGobOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatOdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatPopulationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatReviewRightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatReviewTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatRightsRecommendationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatSolidarityActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $cat_entity_id
 * @method static \Illuminate\Database\Eloquent\Builder|Recommendation whereCatEntityId($value)
 * @property string $recommendation
 * @property int|null $cat_gob_power_id
 * @property int|null $cat_attendig_id
 * @property int|null $cat_subtopic_id
 * @property int|null $cat_ods_id
 * @property string $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatAttendigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatGobPowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatOdsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereCatSubtopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Recommendation whereRecommendation($value)
 */
class Recommendation extends Model
{
    use CustomModelLogic;

    protected $fillable = ['recommendation','recommendation_like','validity','directed', 'cat_entity_id', 'date',
        'comments','invoice', 'isPublished', 'typeIndicator','levelAttention','attentionClassification', 'isType'];

    protected $appends = ['hash', 'is_creator', 'implode_order', 'implode_power', 'implode_attendig',
        'implode_population', 'implode_action','implode_attendigacronym','format_rec','first_topic','second_topic'];


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function entity()
    {
        return $this->belongsTo(
            CatEntity::class,
            'cat_entity_id'
        );
    }

    public function order()
    {
        return $this->belongsToMany(
            CatGobOrder::class,
            'orders_recommendation'
        )->whereIsactive(true);
    }

    public function power()
    {
        return $this->belongsToMany(
            CatGobPower::class,
            'powers_recommendation'
        )->whereIsactive(true);
    }

    public function attendig()
    {
        return $this->belongsToMany(
            CatAttending::class,
            'attendig_recommendation'
        )->whereIsactive(true);
    }


    public function right()
    {
        return $this->belongsToMany(
            CatRightsRecommendation::class,
            'recommendation_right_subright',
            'recommendation_id',
            'right_id'
        );
    }

    public function subright()
    {
        return $this->belongsToMany(
            CatSubRights::class,
            'recommendation_right_subright',
            'recommendation_id',
            'subrigth_id'
        );
    }

    public function subcategory()
    {
        return $this->belongsToMany(
            CatSubcategorySubrights::class,
            'recommendation_right_subright',
            'recommendation_id',
            'subcategory_subrights_id'
        );
    }

    public function population()
    {
        return $this->belongsToMany(
            CatPopulation::class,
            'population_recommendation'
        )->whereIsactive(true);
    }

    public function action()
    {
        return $this->belongsToMany(
            CatSolidarityAction::class,
            'action_recommendation'
        )->whereIsactive(true);
    }

    public function date()
    {
        return $this->belongsTo(
            CatDate::class,
            'cat_date_id'
        );
    }

    public function ods(){
        return $this->belongsToMany(
            CatOds::class,
            'ods_recommendation',
            'recommendation_id',
            'ods_id'
        )->distinct('ods_id');
    }


    public function goalsOds()
    {
        return $this->belongsToMany(
            CatGoalsOds::class,
            'ods_recommendation',
            'recommendation_id',
            'goals_ods_id'
        )->distinct('goals_ods_id');
    }


    public function topic()
    {
        return $this->belongsToMany(
            CatTopic::class,
            'themes_recommendation',
            'recommendation_id',
            'cat_topic_id'
        );
    }
    public function second()
    {
        return $this->belongsToMany(
            CatSubtopic::class,
            'themes_recommendation',
            'recommendation_id',
            'cat_subtopic_id'
        );
    }


    public function getFirstTopicAttribute(){
        return $this->topic->pluck('id');
    }

    public function getSecondTopicAttribute(){
        return $this->second->pluck('id');
    }


    public function subtopic()
    {
        return $this->belongsToMany(
            CatSubTopic::class,
            'themes_recommendation',
            'recommendation_id',
            'cat_subtopic_id'
        );
    }


    public function documents()
    {
        return $this->hasMany(
            Document::class,
            'recommendation_id'
        )->where('isActive', true);
    }

    public function reportedaction()
    {
        return $this->hasMany(
            ReportedAction::class,
            'recommendation_id'
        )->where('isActive', true);
    }

    public function dataControl()
    {
        return $this->hasOne(DataControl::class,
            'recommendation_id');
    }

    public function docs(){
        return $this->belongsToMany(
            DocumentRecommendation::class,
            'recommendation_docs',
            'recommendation_id',
            'document_id'
        );
    }

    public function scopeSearch($query, $filters)
    {
        return $query->when(! empty ($filters), function ($query) use ($filters) {

            return $query->where(function($q) use ($filters)
            {
                $filters = json_decode($filters, false);

                if ($filters->recommendation) {
                    $q->where('recommendation', 'like', '%' . $filters->recommendation . '%');
                }
            });
        });
    }

    public function scopeConsult($query, $search){

        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where(function ($q) use ($search){

                $q->when(!empty($search->date), function ($q) use ($search){
                    $parseDate = Carbon::parse($search->date)->format('Y');

                    return $q->where('date',$parseDate);
                });
                $q->when(!empty($search->isPublished), function ($q) use ($search){

                    return $q->where('isPublished',$search->isPublished[0]);
                });
                $q->when(!empty($search->recommendation), function ($q) use ($search){
                    return $q->where('recommendation','like','%'.$search->recommendation.'%');
                });

                $q->when(!empty($search->cat_entity_id), function ($q) use ($search){
                    return $q->whereHas('entity', function ($qq) use ($search) {
                        return $qq->where('id',$search->cat_entity_id);
                    });
                });

            });
        });
    }



    public function scopePublicConsult($query, $search){
        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where(function ($q) use ($search){

                $q->when(!empty($search['year']) && count($search['year']) > 0, function ($q) use ($search){
                    return $q->whereIn('date',$search['year']);
                });

                $q->when(isset($search['published']), function ($q) use ($search){
                    return $q->where('isPublished',$search['published']);
                });

                //En observacion
                $q->when(isset($search['recommendation']), function ($q) use ($search){
                    return $q->where('recommendation','like','%'.$search['recommendation'].'%')
                           ->orWhere('recommendation_like','like','%'.$search['recommendation'].'%');
                });

                $q->when(isset($search['invoice']), function ($q) use ($search){
                    return $q->where('invoice','like','%'.$search['invoice'].'%');
                });
                //fn de la observacion

                $q->when(!empty($search['entities']) && count($search['entities']) > 0, function ($q) use ($search){
                    return $q->whereIn('cat_entity_id',$search['entities']);
                });
                $q->when(!empty($search['populations']) && count($search['populations']) > 0, function ($q) use ($search){
                    return $q->whereHas('population', function ($qq) use ($search) {
                        return $qq->whereIn('cat_population_id',$search['populations']);
                    });
                });
                $q->when(!empty($search['authorities']) && count($search['authorities']) > 0, function ($q) use ($search){
                    return $q->whereHas('attendig', function ($qq) use ($search) {
                        return $qq->whereIn('cat_attending_id',$search['authorities']);
                    });
                });
                $q->when(!empty($search['ods']) && count($search['ods']) > 0, function ($q) use ($search){

                    return $q->whereHas('ods', function ($qq) use ($search) {
                        $ods = [];
                        $subOds = [];
                        foreach($search['ods'] as $item){
                            if( count($item) > 0 ){
                                array_push($ods,$item['ods_id']);
                                array_push($subOds,$item['cat_goal_id']);
                            }

                        }
                        return $qq->whereIn('ods_id',$ods)
                            ->whereIn('goals_ods_id',$subOds);

                    });
                });
                $q->when(!empty($search['topics']) && count($search['topics']) > 0, function ($q) use ($search){

                    return $q->whereHas('topic', function ($qq) use ($search) {
                        $topic = [];
                        foreach($search['topics'] as $item){
                                if(count($item['cat_topic_id']) > 0){
                                    $topic = $item['cat_topic_id'];
                                }
                        }

                        if( count($topic) > 0 ){
                            $topic = array_unique($topic);
                           // dd("temas: ",$topic);
                            return $qq->whereIn('cat_topic_id',$topic);
                        }

                    });

                });

                $q->when(!empty($search['topics']) && count($search['topics']) > 0, function ($q) use ($search){

                    return $q->whereHas('topic', function ($qq) use ($search) {
                        $subtopic = [];
                        foreach($search['topics'] as $item){
                            if(  count($item) > 0 ){
                                if(count($item['cat_subtopic_id']) > 0){
                                    $subtopic = $item['cat_subtopic_id'];
                                }
                            }
                        }
                        if( count($subtopic) > 0 ){
                            $subtopic = array_unique($subtopic);
                            return $qq->whereIn('cat_subtopic_id',$subtopic);
                        }

                    });

                });


                $q->when(!empty($search['rights']) && count($search['rights']) > 0, function ($q) use ($search){
                    return $q->whereHas('right', function ($qq) use ($search) {
                        $righIds = [];
                        foreach($search['rights'] as $item){
                            if(count($item) > 0 ){
                                if( $item['right_id'] !== null ){
                                    array_push($righIds,$item['right_id']);
                                }
                            }
                        }
                        $righIds = array_unique($righIds);

                        if( count($righIds) > 0){
                            return  $qq->whereIn('right_id',$righIds);
                        }

                    });
                });

                $q->when(!empty($search['rights']) && count($search['rights']) > 0, function ($q) use ($search){
                    return $q->whereHas('right', function ($qq) use ($search) {
                        $subIds = [];

                        foreach($search['rights'] as $item){
                            if(  count($item) > 0 ){
                                if ( $item['subrights_id'] !== null  ) {
                                    array_push($subIds,$item['subrights_id']);
                                }
                            }

                        }
                        $subIds = array_unique($subIds);

                        if( count($subIds) > 0 ){
                            return  $qq->whereIn('subrigth_id',$subIds);
                        }

                    });
                });


                $q->when(!empty($search['rights']) && count($search['rights']) > 0, function ($q) use ($search){
                    return $q->whereHas('right', function ($qq) use ($search) {
                        $subCatIds = [];
                        foreach($search['rights'] as $item){
                            if(  count($item) > 0 ){
                                if ( $item['subcategory_id'] !== null ) {
                                    array_push($subCatIds,$item['subcategory_id']);
                                }
                            }
                        }
                        $subCatIds = array_unique($subCatIds);

                        if( count($subCatIds) > 0 ){
                            return  $qq->whereIn('subcategory_subrights_id',$subCatIds);
                        }

                    });
                });


                $q->when(!empty($search['actions']) && count($search['actions']) > 0, function ($q) use ($search){
                    return $q->whereHas('action', function ($qq) use ($search) {
                        return $qq->whereIn('cat_solidarity_action_id',$search['actions']);
                    });
                });

            });
        });
    }



    public function scopeFilterConsole($query, $search){
       // dd("Estas llegando en la recomnedacion: ",$search);
        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where(function ($q) use ($search){
                $q->when(!empty($search['date']), function ($q) use ($search){
                    if( count($search['date']) > 0){
                        return $q->whereIn('date', $search['date']);
                    }
                });
            });
        });
    }




    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function getIsCreatorAttribute()
    {
        if(\Auth::check()){
            return $this->user_id === auth()->user()->id;
        }

    }

    public function getImplodeOrderAttribute()
    {
        return implode(', ', $this->order->pluck('name')->toArray());
    }

    public function getImplodePowerAttribute()
    {
        return implode(', ', $this->power->pluck('name')->toArray());
    }

    public function getImplodeAttendigAttribute()
    {
        return implode(', ', $this->attendig->pluck('name')->toArray());
    }

    public function getImplodeAttendigacronymAttribute()
    {
        return implode(', ', $this->attendig->pluck('acronym')->toArray());
    }

    public function getImplodePopulationAttribute()
    {
        return implode(', ', $this->population->pluck('name')->toArray());
    }

    public function getImplodeActionAttribute()
    {
        return implode('| ', $this->action->pluck('name')->toArray());
    }

    public function getFormatRecAttribute()
    {
        do{
            $findSpace = strpos($this->recommendation, '&nbsp; &nbsp;');

            if ($findSpace != false) $this->recommendation = str_replace('&nbsp; &nbsp;','&nbsp;',$this->recommendation);
        }while($findSpace != false);

        if (substr_count($this->recommendation, '</p>')>1){
            $onlyText = explode("</p>", $this->recommendation);
            $fullText = '';

            foreach ($onlyText as $text){
                if (strpos($text, '">&nbsp;')==false){
                    $fullText = $fullText.$text;
                }
            }

            $format = str_replace('margin-left:','',$fullText);
            $format = str_replace('text-align:','',$format);

            return $format;
        }else{

            $format = str_replace('margin-left:','',$this->recommendation);
            $format = str_replace('text-align:','',$format);
            return $format;
        }

    }

    // public function getImplodeRightAttribute()
    // {
    //     return implode(', ', $this->right->pluck('name')->toArray());
    // }
}

