<?php

namespace App\Http\Traits;

use App\Http\Models\Cats\CatTopic;
use App\Http\Models\Cats\CatSubtopic;
use stdClass;

trait TopicsTrait
{
    public static function orderTopics($items, $topic = [])
    {

        $data = CatTopic::with('subtopics')
            ->where('isActive', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        $total = count($data);

        $ideEdit = [];
        $topics = [];
        $idsSub = [];
        if ($items!==null){
            foreach ($items as $item){
                array_push($ideEdit, $item->id);
                $idsSub [] = $item->cat_topic_id;
            }
        }

        $idsTopics = [];
        foreach ($topic as $id){
            if (isset($id->id)){
                $idsTopics [] = $id->id;
            }else{
                $idsTopics = $topic;
            }
        }
       /* $uniIds = array_unique($idsSub);
        foreach ($uniIds as $id){
            for ($i=0; $i<count($idsTopics);$i++){
                if ($idsTopics[$i]==$id){
                    unset($idsTopics[$i]);
                }
            }
        }*/

//       dd($idsTopics);

        $showIde = [];
        $lists=[];
        $listTopics = [];
        $totalAux = 1;
        foreach ($data as $topic) {
            $subtopics = [];

            foreach ($topic->subtopics as $sub){
                $valid= strpos($sub->name, '.-');
                if ($valid) {
                    $aux = explode(".-", $sub->name);
                    $sub->name= $aux[1];
                }
            }
            $subTopics = self::arraySort( $topic->subtopics->toArray(), 'name', SORT_ASC);

            foreach ($subTopics as $subtopic) {
                $total++;
                /*$name = '';
                $validName= strpos($subtopic->name, '.-');
                if ($validName==false) {
                    $name = $subtopic->name;
                }else{
                    $aux = explode(".-", $subtopic->name);
                    $name = $aux[1];
                }
dd($subtopic->name,$name);*/
                $subtopics[] = [
                    'id' => $total,
                    'label' => $subtopic['name'],
                    'name' => $subtopic['name'],
                    'cat_topic_id' => $topic -> id,
                    'cat_subtopic_id' => $subtopic['id'],
                ];
                foreach ($ideEdit as $value){
                    if ($value===$subtopic['id']){
                        array_push($showIde,$total);
                        $lists[] = [
                            'id' => $total,
                            'label' => $subtopic['name'],
                            'name' => $subtopic['name'],
                            'cat_topic_id' => $topic->id,
                            'cat_subtopic_id' => $subtopic['id'],
                        ];
                    }
                }



            }

            $topics[] = [
                'id' => $totalAux,
                'topic_id'=>$topic->id,
                'name' => $topic->name,
                'children' => $subtopics
            ];

//            show topics
            foreach ($idsTopics as $top){
                if($topic->id == $top){
                    $listTopics [] = $topic->id;
                    array_push($showIde,$totalAux);
                }
            }

            $totalAux += 1;
        }
        $tree= $topics;

        return $tree = [
            'tree'            => $tree,
            'showIde'          => $showIde,
            'listThemes'        => $lists,
            'idsTopics'         => $listTopics,
        ];

    }

    public static function arraySort($array, $on, $order=SORT_ASC){
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
}
