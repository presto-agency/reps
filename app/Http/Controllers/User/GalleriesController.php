<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleriesController extends Controller
{
    public  $routCheck;

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
        $row = ['id', 'picture'];
        $images = GalleryHelper::getGalleriesImages($row);

        $routCheck = $this->routCheck;

        return view('user.gallery.index', compact('images', 'routCheck'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return back();

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

        return view('user.gallery.show', compact('userImage', 'previous', 'next','routCheck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back();
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
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back();

    }
}
