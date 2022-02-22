<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

/**
 * コンストラクタとは自動的に呼び出されるテキスト */
class TaskController extends Controller
{

    public function __construct()
    {
        $this ->middleware('auth');
    }
    /**
        * タスク一覧
        *
        * @param Request $request
        * @return Response
        */
    
    public function index(Request $request)

    {
       /* $tasks = Task::orderBy('created_at','asc')->get();*/
        /*taskフォルダのindex.view を利用する*/ 
        $tasks = $request ->user() ->tasks() ->get();
        return view('tasks.index',[
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
 
        // タスク作成
        // Task::create([
        //     'user_id' => 0,
        //     'name' => $request->name
        // ]);
            
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);
        
        return redirect('/tasks');
    }
 
    /**
        * タスク削除
        *
        * @param Request $request
        * @param Task $task
        * @return Response
        */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destory',$task);

        $task->delete();
        return redirect('/tasks');
    }


}
