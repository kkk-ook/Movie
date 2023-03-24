<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function items(){
        $items= Item::all();
        return view('item.items',compact("items"));
    }
    /**
     *商品登録画面の表示
     */
    public function itemAdd()
    {
        return view('item.add');
    }

    /**
     * 商品登録
     *
     * @return \Illuminate\Http\Response
     */
    public function itemCreate(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:100',
            'status'=>'required',
            'type' => 'required|integer',
            'detail' => 'required|max:500',
        ],
        [
            'name.required' => '名前欄が入力されていません。',
            'status.required' => 'ステータスが選択されていません。',
            'type.required'  => '種別欄が選択されていません。',
            'detail.required'  => '説明欄が入力されていません。',
        ]);

        //**ユーザIDも登録する** */
        Item::create([
            'name' => $request->name,
            'status' => $request->status,
            'type' => $request->type,
            'detail' => $request->detail
        ]);
      
        //商品一覧画面に戻る  
        return redirect()->route('items');
    }

        //検索
    public function itemSearch(Request $request){
        $query = Item::query();

        $itemKeyword = $request->input('itemKeyword');

        if(!empty($itemKeyword)) {
            $query->where('name', 'LIKE', "%{$itemKeyword}%")
            -> orWhere('detail', 'LIKE', "%{$itemKeyword}%");
        }

        $items = $query->get();

        return view('item.items', compact('items', 'itemKeyword'));

    }



    /**
     * 詳細画面
     */ 
    public function detail($id)
    {
        $item = Item::find($id);


        return view('item.detail',compact('item'));
    }
}
