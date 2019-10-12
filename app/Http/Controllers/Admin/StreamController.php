<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Models\Stream;
use App\Http\Controllers\Controller;

class StreamController extends Controller
{
    public function show($id)
    {

        $columns = [
            'id',
            'user_id',
            'title',
            'race_id',
            'content',
            'country_id',
            'stream_url',
            'approved',
        ];
        $relations = [
            'users',
            'countries',
            'races',
        ];

        $stream = Stream::select($columns)->with($relations)->findOrFail($id);

        $content = view('admin.stream.show',
            compact('stream')
        );


        return AdminSection::view($content, 'Stream');
    }
}
