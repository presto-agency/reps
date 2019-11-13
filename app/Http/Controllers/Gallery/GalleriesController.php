<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\User\GalleryHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleriesController extends Controller
{
    public $routCheck;

    public function __construct()
    {
        $this->routCheck = GalleryHelper::checkUrlGalleries();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relation = ['comments'];
        $row = ['id', 'sign', 'positive_count', 'negative_count', 'picture',];
        $userImage = GalleryHelper::getUserImage($id, $relation, $row);

        // get previous user id
        $previous = GalleryHelper::previousGalleriesImage($id, $relation, $row);

        // get next user id
        $next = GalleryHelper::nextGalleriesImage($id, $relation, $row);

        $routCheck = $this->routCheck;

        return view('gallery.show', compact('userImage', 'previous', 'next', 'routCheck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->to('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->to('/');

    }

    public function loadGalleries()
    {
        $row = ['id', 'picture', 'user_id'];
        if (request()->ajax()) {
            $visible_title = false;
            $routCheck = $this->routCheck;
            if (request('id') > 0) {
                $images = GalleryHelper::getGalleriesImagesAjaxId($row,request('id'));
            } else {
                $images = GalleryHelper::getGalleriesImagesAjax($row);
                $visible_title = true;
            }
            echo view('gallery.components.index', compact('images', 'routCheck', 'visible_title'));
        }
    }
}
