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

    /*作品登録 */
    public function itemCreate(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:100',
            'kana' => 'required|regex:/^[ぁ-んァ-ンー]+$/u',
            'status'=>'required',
            'type' => 'required|integer',
            'detail' => 'required|max:500',
        ],
        [
            'name.required' => '"作品名"が入力されていません。',
            'kana.required' => '"よみがな"が入力されていません。',
            'status.required' => '"ステータス"が選択されていません。',
            'type.required'  => '"ジャンル"が選択されていません。',
            'detail.required'  => '"あらすじ"が入力されていません。',
        ]);

        Item::create([
            'name' => $request->name,
            'kana' => $request->kana,
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
                'name' => 'required',
                'kana' => 'required|regex:/^[ぁ-んァ-ンー]+$/u',
                'status' => 'required',
                'type' => 'required',
                'detail' => 'required',
            ]);
    
        //編集情報の保存
        $items = Item::where('id', '=', $request->id)->first();
        $items->name = $request->name;
        $items->kana = $request->kana;
        $items->status =$request->status;
        $items->type =$request->type;
        $items->detail = $request->detail;
        $items->save();

        return redirect('items');
    }
    //削除
    public function itemDelete(Request $request){
        $item = Item::where('id' , '=' , $request->id)->first();

        $item->reviews()->delete();
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

        // 現在のリクエストに含まれるクエリ文字列を取得
        $queryParams = $request->query();

        //セレクトボックス
        $selectType = $request->input('type');
        if(!empty($selectType)) {
            $query->where('type', '=', "$selectType");
        }
        //検索欄
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
            -> orWhere('detail', 'LIKE', "%{$keyword}%");
        }
    //チェックボックス
        //あいう順に並べる
        $orderKana = $request->input('orderKana');
        if(!empty($orderKana)) {
            $query->orderBy('kana', 'asc');
        }
        //レビュー順に並べる
        $query->leftJoin('item_reviews', 'items.id', '=', 'item_reviews.item_id')
        ->select('items.*', ItemReview::raw('AVG(item_reviews.stars) as avg_stars'))
        ->groupBy('items.id')
        ->orderByDesc('avg_stars');
        
        $items = $query->paginate(10);
        //次のページへのリンクに追加
        $items->appends($queryParams);

        return view('item.items', compact('items'));

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