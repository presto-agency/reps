<?php


namespace App\Http\ViewComposers;


use App\Models\ChatSmile;
use Illuminate\View\View;

class Smiles
{

    private $category;

    public function __construct()
    {
        $smiles      = [];
        $extraSmiles = ChatSmile::orderBy('updated_at', 'Desc')->get();
        foreach ($extraSmiles as $smile) {
            $smiles[] = [
                'charactor' => $smile->charactor,
                'filename'  => pathinfo($smile->image)["basename"],
            ];
        }

        $this->category = json_encode($smiles);
    }

    public function compose(View $view)
    {
        $view->with('smiles', $this->category);
    }

}
