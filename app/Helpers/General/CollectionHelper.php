<?php
namespace App\Helpers\General;
use Iluminate\Support\Collection;
class CollectionHelper{
    public static function paginate(Collection $collecion, $pageSize){
        $page = Paginator::resolveCurrentPage('page');
        $total=$collection->count();
        return self::paginator($collecion->forPage($page,$pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

     /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
?>