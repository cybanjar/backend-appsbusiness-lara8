<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
   
    public function index()
    {
        $post = Post::all();
        return response()->json($post);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string',
            'harga'     => 'required|integer',
            'deskripsi' => 'required|string',
            'kondisi'   => 'in:baru, bekas',
            'lokasi'    => 'required|string',
            'photo'     => 'string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();
        $post = Post::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Successfully!',
            'data'    => $post  
        ]);
    }

    
    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }
   
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if(!$post) {
            return response()->json([
                'message' => 'Post not found!'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string',
            'harga'     => 'required|integer',
            'deskripsi' => 'required|string',
            'kondisi'   => 'in:baru, bekas',
            'lokasi'    => 'required|string',
            'photo'     => 'string',
        ]);

        $data = $request->all();
        $post->fill($data);
        $post->save();
        
        return response()->json([
            'success'   => true,
            'message'   => 'Successfully',
            'data'      => $post
        ]);
    }
    
    public function destroy($id)
    {
        $post = Post::find($id);
        if(!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found!'
            ], 400);
        }

        $post->delete();
        return response()->json([
            'message' => 'Post has been deleted!'
        ], 200);
    }
}
