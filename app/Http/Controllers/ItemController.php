<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\ItemReview;
use Illuminate\Validation\Rule;

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

/***********************************
 *作品一覧画面の表示
*************************************/
    public function items(){
        //管理者ならtrue
        $user = Auth::user();
        $query = Item::query();
        if($user->role == 1){
        //ユーザーならfalse
        } else { 
            $query->where('status', '=', 'active');
        }
        $items = $query->paginate(10);
        
        return view('item.items',compact("items"));
    }
/**************************************
 *商品登録画面の表示
****************************************/
    public function itemAdd()
    {
        return view('item.add');
    }

    /*商品登録 */
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

        Item::create([
            'name' => $request->name,
            'status' => $request->status,
            'type' => $request->type,
            'detail' => $request->detail
        ]);
    
        //商品一覧画面に戻る  
        return redirect('items');
    }



/*************************************
 * 詳細画面の表示
****************************************/ 
    public function detail($id)
    {
        $item = Item::find($id);


        return view('item.detail',compact('item'));
    }

/**************************************
*編集画面の表示
*****************************************/
    public function show(Request $request, $id) {
        $items = Item::where('id','=',$request->id)->first();
        
        return view('item.itemEdit')->with([
            'item' => $items,
        ]);
    }


    /*編集*/
    public function itemEdit(Request $request) {
            $request->validate([
                'name' => ['required'],
                'status' => ['required'],
                'type' => ['required'],
                'detail' => ['required'],
            ]);
    
        //編集情報の保存
        $items = Item::where('id', '=', $request->id)->first();
        $items->name = $request->name;
        $items->status =$request->status;
        $items->type =$request->type;
        $items->detail = $request->detail;
        $items->save();

        return redirect('items');
    }
    //削除
    public function itemDelete(Request $request){
        $item = Item::where('id' , '=' , $request->id)->first();

            $item->delete();

        return redirect('items');
    }
    
/* 一覧画面検索 */
    public function search(Request $request){

        $user = Auth::user();
        $query = Item::query();
        if($user->role == 1){
        //ユーザーならfalse
        } else { 
            $query->where('status', '=', 'active');
        }         

        //セレクトボックス
        $selectType = $request->input('type');
        //検索欄
        $keyword = $request->input('keyword');

        if(!empty($selectType)) {
            $query->where('type', '=', "$selectType");
        }

        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
            -> orWhere('detail', 'LIKE', "%{$keyword}%");
        }



        $items = $query->paginate(5);

        return view('item.items', compact('items', 'keyword'));

    }

    /*ページネーション*/
    public function pagi()
    {
        $items = Item::paginate(5);
        return view('item.items', compact('items'));
    }


/**************************************
*レビュー画面の表示
*****************************************/
public function reviewShow(){
    $user = Auth::user();

    $query =  Item::with('reviews');
        //管理者ならtrue
    if($user->role !== 1){
        $query->where("status","active");
    }
    $items = $query->paginate(10);

    return view('item.review',compact("items","user"));
}


public function review(Request $request) {

        // バリデーション
        $request->validate([
            'stars' => 'required',
            'comment' => 'max:500'
        ],
        [
        'stars.required' => 'スコアが入力されていません。'
    ]);

        if (!ItemReview::where(["user_id" => $request->user()->id, "item_id" => $request->item_id])->exists()) {
            //レビューしていない時
            $review = new ItemReview();
        } else {
            //既にレビューしている時
            $review = ItemReview::where([["user_id", $request->user()->id ],[ "item_id", $request->item_id]])->first();
        }
        $review->item_id = $request->item_id;
        $review->user_id = $request->user_id;
        $review->stars = $request->stars;
        $review->comment = $request->comment;
        $review->save();

        return redirect('/review');

    }



}