<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DiggingDeeperController extends Controller
{
    public function collections()
    {
        $result = [];

        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());

        /*dd(
            get_class($eloquentCollection),
            get_class($collection),
            $collection
        );*/

        $result['first'] = $collection->first();
        $result['last'] = $collection->last();

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
            ->keyBy('id');

        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

        $result['where_first'] = $collection
            ->firstWhere('created_at', '>', '2020-01-17 01:35:11');

        $result['map']['all'] = $collection->map(function (array $item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        $collection->transform(function (array $item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;
        });

        $result['map']['not_exists'] = $result['map']['all']->where('exists', '=', false);

        $newItem = new \stdClass();
        $newItem->id = 9999;

        $newItem2 = new \stdClass();
        $newItem2 = 8888;

        $newItemFirst = $collection->prepend($newItem)->first();
        $newItemLast = $collection->push($newItem)->last();
        $pulledItem = $collection->pull(1);

        //dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));

       /* $filtered = $collection->filter(function ($item) {
            $byDay = $item->created_at->isFriday();
            $byDate = $item->created_at->day = 11;

            $result = $byDate && $byDay;

            return $result;
        });*/

        $sortedSimpleCollection = collect([5, 3, 1, 2, 4])->sort();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');

        dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));

    }
}
