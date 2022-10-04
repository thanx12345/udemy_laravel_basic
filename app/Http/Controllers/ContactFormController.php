<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;
use App\Services\CheckFormService;
use App\Http\Requests\StoreContactRequest; 

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ルーティング記述後に追加
        // ナビゲーション追加
        // $contacts = ContactForm::select('id', 'name', 'title', 'created_at')
        // ->get();
        
        // ペジネーション対応
        // $contacts = ContactForm::select('id', 'name', 'title', 'created_at')
        // ->paginate(20);

        // 検索フォーム
        $search = $request->search;
        $query = ContactForm::search($search); //クエリのローカルスコープ

        $contacts = $query->select('id', 'name', 'title', 'created_at')
        ->paginate(20);

        return view('contacts.index', compact('contacts')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        // dd($request, $request->name);

        // createメソッドでまとめて登録できる
        ContactForm::create([
            'name' => $request->name,
            'title' => $request->title,
            'email' => $request->email,
            'url' => $request->url,
            'gender' => $request->gender,
            'age' => $request->age,
            'contact' => $request->contact,
            ]);
            //保存した後はリダイレクトをかける
            return to_route('contacts.index'); // to_route でリダイレクト (Laravel9からの書き方) 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 1件だけ取得,findは一致する情報を返す
        $contact = ContactForm::find($id);

        // 性別年齢の表示
        // staticで指定しているので:: でメソッドを指定できる
        $gender = CheckFormService::checkGender($contact);
        $age = CheckFormService::checkAge($contact); 

        

        return view('contacts.show', 
        compact('contact', 'gender', 'age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 1件だけ取得,findは一致する情報を返す
        $contact = ContactForm::find($id);

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = ContactForm::find($id);
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->url = $request->url;
        $contact->gender = $request->gender;
        $contact->age = $request->age;
        $contact->contact = $request->contact;
        $contact->save(); //これがないと保存できない！

        return to_route('contacts.index'); //リダイレクト
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = ContactForm::find($id);
        $contact->delete(); // deleteで削除

        return to_route('contacts.index'); 

    }
}
