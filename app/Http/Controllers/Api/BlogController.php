<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    public function index(): JsonResponse
    {
        $blogs = Blog::query()
            ->select([
                'id',
                'title',
                'slug',
                'excerpt',
                'cover_image',
                'author_name',
                'author_role',
                'author_avatar',
                'reading_time',
                'published_at',
            ])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $blogs->map(static function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'coverImage' => $blog->cover_image,

                    'author' => [
                        'name' => $blog->author_name,
                        'role' => $blog->author_role,
                        'avatar' => $blog->author_avatar,
                    ],

                    'readingTime' => $blog->reading_time,
                    'publishedAt' => $blog->published_at?->format('Y-m-d'),
                ];
            }),
        ]);
    }



    public function show(string $slug): JsonResponse
    {
        $blog = Blog::query()
            ->select([
                'id',
                'title',
                'slug',
                'excerpt',
                'cover_image',
                'author_name',
                'author_role',
                'author_avatar',
                'reading_time',
                'published_at',
                'meta_title',
                'meta_description',
                'content',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'excerpt' => $blog->excerpt,
                'coverImage' => $blog->cover_image,

                'author' => [
                    'name' => $blog->author_name,
                    'role' => $blog->author_role,
                    'avatar' => $blog->author_avatar,
                ],

                'readingTime' => $blog->reading_time,
                'publishedAt' => $blog->published_at?->format('Y-m-d'),

                'metaTitle' => $blog->meta_title,
                'metaDescription' => $blog->meta_description,

                'content' => $blog->content,
            ],
        ]);
    }
}
