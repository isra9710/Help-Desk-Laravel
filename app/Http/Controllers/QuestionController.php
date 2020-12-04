<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Department;
use App\Models\Subarea;
use App\Models\Role;
use App\Models\Priority;

use App\Models\Question;
use App\Models\Poll;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::paginate(2);
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $questions = Question::paginate(5);
        return view('management.question.index',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'questions'=>$questions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $status='';
        $content='';
        $question = new Question();
        try{
            $status='success';
            $status='Pregunta registrada con éxito';
            $question->question = "¿".$request->question."?";
            $question->save();
        }catch(\Throwable $th){
        DB::rollBack();
        $status = 'error';
        $content= 'Error al intentar registrar pregunta';
        }
        if(auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.question.create')
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('coordinator.question.create')
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        $departments = Department::paginate(2);
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.question.edit',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'question'=>$question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
        $status='success';
        $content='Pregunta editada con éxito';
        try{
            $question->question=$request->question;
            $question->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar registrar pregunta';
            }
        if(auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.question.create')
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('coordinator.question.create')
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        $status='warning';
        $content='';
        try{
            if($question->active){
                $question->active=FALSE;
                $content= 'Pregunta desactivada';
            }else{
                if(auth()->user()->isAdministrator()){
                    $content= 'Pregunta reactivada';
                    $question->active=TRUE;
                }
            }
            $question->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            if($question->active){
                $content= 'Error al intentar desactivar pregunta';
            }
            else{
                $content= 'Error al intentar reactivar pregunta';
            }
            
            }
        if(auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.question.create')
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('coordinator.question.create')
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }
}
