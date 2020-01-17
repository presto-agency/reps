<?php


namespace App\Http\ViewComposers;


use App\Models\ChatPicture;
use App\Models\ChatSmile;
use Illuminate\View\View;

class Smiles
{

    private $ttl = 3600;//10 hours

    private $smilesJson = '';
    private $imagesJson = '';

    public function __construct()
    {
        $this->smilesJson = $this->getCacheSmiles('smilesJson');
        $this->imagesJson = $this->getCacheImages('imagesJson');
    }

    public function compose(View $view)
    {
        $view->with('smilesJson', $this->smilesJson);
        $view->with('imagesJson', $this->imagesJson);
    }


    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheSmiles(string $cache_name)
    {
        if (\Cache::has($cache_name) && ! empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                $smiles = ChatSmile::query()->orderByDesc('updated_at')->get(['image']);
                if (isset($smiles) && $smiles->isNotEmpty()) {
                    $data = [];
                    foreach ($smiles as $item) {
                        $data[] = [
                            'filename' => pathinfo($item->image)['basename'],

                        ];
                    }

                    return json_encode($data);
                }

                return '';
            });
        }

        return $data_cache;
    }

    /**
     * @param  string  $cache_name
     *
     * @return mixed
     */
    private function getCacheImages(string $cache_name)
    {
        if (\Cache::has($cache_name) && ! empty(\Cache::get($cache_name))) {
            $data_cache = \Cache::get($cache_name);
        } else {
            $data_cache = \Cache::remember($cache_name, $this->ttl, function () {
                $images = ChatPicture::query()->orderByDesc('updated_at')->get(['image']);
                if (isset($images) && $images->isNotEmpty()) {
                    $data = [];
                    foreach ($images as $item) {
                        $data[] = [
                            'filename' => pathinfo($item->image)['basename'],

                        ];
                    }

                    return json_encode($data);
                }

                return '';
            });
        }

        return $data_cache;
    }


}
