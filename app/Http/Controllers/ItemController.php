<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\ItemReview;
use App\Models\Genre;
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

        $genres = Genre::all();
        
        return view('item.items',compact("items","genres"));
    }
/**************************************
 *作品登録画面の表示
****************************************/
    public function itemAdd()
    {
        $genres = Genre::all();

        return view('item.add',compact('genres'));
    }

    /*商品登録 */
    public function itemCreate(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:100',
            'kana' => 'required|regex:/^[ぁ-んァ-ンー]+$/u',
            'status'=>'required',
            'genre_id' => 'required',
            'detail' => 'required|max:500',
        ],
        [
            'name.required' => '作品名が入力されていません。',
            'kana.required' => 'よみがなが入力されていません。',
            'status.required' => 'ステータスが選択されていません。',
            'genre_id.required'  => 'ジャンルが選択されていません。',
            'detail.required'  => '説明欄が入力されていません。',
        ]);

        $item=Item::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'status' => $request->status,
            'detail' => $request->detail
        ]);

        $item->genres()->attach($request->genre_id);
        
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

        $genres = Genre::all();

        return view('item.itemEdit',compact("genres"))->with([
            'item' => $items,
        ]);
    }


    /*編集*/
    public function itemEdit(Request $request) {
        $request->validate([
            'name' => 'required',
            'kana' => 'required|regex:/^[ぁ-んァ-ンー]+$/u',
            'status' => 'required',
            'genre_id' => 'required',
            'detail' => 'required',
        ],
        [
            'name.required' => '作品名が入力されていません。',
            'kana.required' => 'よみがなが入力されていません。',
            'status.required' => 'ステータスが選択されていません。',
            'genre_id.required'  => 'ジャンルが選択されていません。',
            'detail.required'  => '説明欄が入力されていません。',
        ]);

        //編集情報の保存
        $items = Item::where('id', '=', $request->id)->first();
        $items->name = $request->name;
        $items->kana = $request->kana;
        $items->status = $request->status;
        $items->detail = $request->detail;
        $items->genres()->detach();
        $items->genres()->attach($request->genre_id);
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
    public function itemSearch(Request $request){

        $genres = Genre::all();
        $user = Auth::user();
        $query = Item::query();
        if($user->role == 1){
        //ユーザーならfalse
        } else { 
            $query->where('status', 'active');
        }

        // 現在のリクエストに含まれるクエリ文字列を取得
        $queryParams = $request->query();

        //ジャンル
        $selectGenres = $request->input('genre');
        if($selectGenres[0]!=null) {
            foreach($selectGenres as $genre){
                $query->whereHas('genres', function ($q) use ($genre) {
                    $q->where('name', $genre);
                });
            }
        }
        //キーワード検索
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

        return view('item.items', compact('items','genres'));

    }

    /*ページネーション*/
    public function pagi()
    {
        $items = Item::paginate(5);
        return view('item.items', compact('items','genres'));
    }


/**************************************
*レビュー画面の表示
*****************************************/
public function reviewShow(){
    $user = Auth::user();

    $query =  Item::with('reviews');
        //管理者ならtrue
    if($user->role !== 1){
        $query->where('status','active');
    }
    $items = $query->paginate(10);

    $genres = Genre::all();

    return view('item.review',compact('items','user','genres'));
}

/*レビュー投稿機能*/
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

/*検索*/
    public function reviewSearch(Request $request){

        $genres = Genre::all();
        $user = Auth::user();
        $query = Item::query();
        if($user->role == 1){
        //ユーザーならfalse
        } else { 
            $query->where('status', 'active');
        }

        // 現在のリクエストに含まれるクエリ文字列を取得
        $queryParams = $request->query();

        //ジャンル
        $selectGenres = $request->input('genre');
        
        if($selectGenres[0]!=null) {
            foreach($selectGenres as $genre){
                $query->whereHas('genres', function ($q) use ($genre) {
                    $q->where('name', $genre);
                });
            }
        }
        //キーワード検索
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

        return view('item.review', compact('items','genres','user'));

    }


}