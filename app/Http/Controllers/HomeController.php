<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index() {
        return view('home', [
            'posts' => Post::all()
        ]);
    }

    public function upload(Request $request) {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
            ]);
    
            $data = new Post([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);
    
            $data->save();
    
            return response()->json([
                'status' => 200,
                'message' => 'Post created successfully',
                'post' => $data,
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the post',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}