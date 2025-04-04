<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;
use App\Models\History;
use Carbon\Carbon;

class NewsController extends Controller
{
    //
    public function add()
    {
        return view("admin.news.create", ["hogee" => "NewsControllerからcreate.blade.phpに渡された文字列です", "fuga"=> "こんにちは"]);
    }

    public function create(Request $request)
    {

        $this->validate($request, News::$rules);

        $news = new News;
        // $form = $request->all();

        // // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
        // if (isset($form['image'])) {
        //     $path = $request->file('image')->store('public/image');
        //     $news->image_path = basename($path);
        // } else {
        //     $news->image_path = null;
        // }

        // // フォームから送信されてきた_tokenを削除する
        // unset($form['_token']);
        // // フォームから送信されてきたimageを削除する
        // unset($form['image']);

        // // データベースに保存する
        // $news->fill($form);
        $news->title = $request->hoge;
        $news->body = $request->body;
        $news->save();

        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != null) {
            // 検索されたら検索結果を取得する
            $posts = News::where('title', $cond_title)->get();
        } else {
            // それ以外はすべてのニュースを取得する
            $posts = News::all();
        }
        return view('admin.news.index', ['aaa' => $posts, 'cond_title' => $cond_title]);
    }

    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $news = News::find($request->id);
        if (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit', ['news_form' => $news]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, News::$rules);
        // News Modelからデータを取得する
        $news = News::find($request->id);
        // 送信されてきたフォームデータを格納する
        $news_form = $request->all();

        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        unset($news_form['image']);
        unset($news_form['remove']);
        unset($news_form['_token']);

        // 該当するデータを上書きして保存する
        $news->fill($news_form)->save();

        $history = new History();
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news');
    }

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $news = News::find($request->id);

        // 削除する
        $news->delete();

        return redirect('admin/news/');
    }
}

