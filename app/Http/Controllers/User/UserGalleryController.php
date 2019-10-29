<?php

namespace App\Http\Controllers\User;

use App\Models\UserGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $images = self::getUserImages();

        return view('user.gallery.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserGallery $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserGallery $request)
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private static function getUserImages()
    {
        $data = null;
        $data = UserGallery::with('users', 'comments')
            ->where('user_id', self::getAuthUser()->id)
            ->get();
        return $data;
    }

    private static function getAuthUser()
    {
        return auth()->user();
    }
}
