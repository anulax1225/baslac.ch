<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::paginate(15);
        if (count($articles) > $request->page) return response($articles[$request->page]);
        return response(["message" => "Page not found"], 404);
    }

    public function show(Request $request)
    {
        $article = Article::find($request->id);
        if ($article) return response($article);
        return response(["message" => "Article not found"], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["name" => "required"]);
        if ($validator->fails()) return response($validator->messages(), 400);
        response(Article::create($request->all()));
    }

    public function update(Request $request)
    {
        $article = Article::find($request->id);
        if (!$article) return response(["message" => "Article not found"], 404);
        $article->update($request->all());
        return response($article);
    }

    public function destroy(Request $request)
    {
        $article = Article::find($request->id);
        if (!$article) return response(["message" => "Article not found"], 404);
        $article->destroy();
        return response([]);
    }
}
