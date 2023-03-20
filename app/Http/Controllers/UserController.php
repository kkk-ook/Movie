<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*ユーザー一覧*/
    public function users() {
        //認証ユーザー取得
        $user = Auth::user();

        //管理者ならtrue
        if($user->role == 1){
            $users = User::all();
        //ユーザーならfalse
        } else {$users = [$user]; 
        
        }

        return view('user.users', compact('users'));
    }

    /*編集画面の表示*/
    public function edit(Request $request) {
        $users = User::where('id','=',$request->id)->first();
        
        return view('user.edit')->with([
            'user' => $users,
        ]);
    }

    //ユーザー編集
    public function userEdit(Request $request) {
        if($request->type == 1){
            $request->validate([
                'name' => ['required'],
                'email' => ['required'],
                'password' => ['required,max:8'],
                'confirm_password' => ['required', 'same:password'],
            ]);
        } else {
            $request->validate([
                'name'=>['required'],
                'email'=>['required','email'],
                'role'=>['required'],
            ]);
        }

        //編集情報の保存
        $users = User::where('id', '=', $request->id)->first();
        $users->name = $request->name;
        $users->email =$request->email;
        //パスワードのハッシュ化
        $users->password = Hash::make($request->password);
        $users->role = $request->role;
        $users->save();

        return redirect('users');
    }

    public function userDelete(Request $request){
            $user = User::where('id' , '=' , $request->id)->first();
            //ユーザーIDが自分のIDだったら削除してログイン画面へ遷移
            if(($user->id == Auth::id())) {
                $user->delete();

            return redirect('/');
            //他人のIDだったら削除してユーザー一覧画面に遷移
            }else{
                $user->delete();

            return redirect('users');
            }
    }
}

