<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test; // Testモデルを使えるように読み込む
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {   
        // dd('test');

        // Eloquent（エロクアント）
        $values = Test::all(); // 全件取得
        $count = Test::count(); // 件数を取得　数字になっている・コレクション型ではない
        $first = Test::findOrFail(1); // idを指定すると、そのインスタンスを返す

        // where　条件指定：テキスト列が 'aaa'のものだけ取得
        $whereBBB = Test::where('text', '=', 'aaa'); // Eloquent/Builder　見に行っているだけでデータ取得はしていない　
        $whereBBB = Test::where('text', '=', 'aaa')->get(); // Collection 　「->get()」と記述するとデータ取得する
        dd($values, $count, $first, $whereBBB);



        // クエリビルダ
        DB::table('tests')->where('text', '=', 'aaa')
        ->select('id', 'text')
        ->get(); // コレクション型で返ってくる

        // dd($values); // die + var_dump 処理を止めて内容を確認できる

        return view('tests.test', compact('values')); // viewはLaravelのヘルパ関数 フォルダ名.ファイル名
    } 
}
