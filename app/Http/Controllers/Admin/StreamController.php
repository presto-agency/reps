<?php

namespace App\Http\Controllers\Admin;

use AdminSection;
use App\Http\Controllers\Controller;
use App\Models\Stream;

class StreamController extends Controller
{

    public function show($id)
    {

        $relations = [
            'users',
            'countries',
            'races',
        ];

        $stream = Stream::with($relations)->findOrFail($id);

        $content = view('admin.stream.show', compact('stream'));

        return AdminSection::view($content, 'Stream');
    }

}
