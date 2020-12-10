<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Poll;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Ticket $ticket)
    {
        //
         //
         $status = 'success';//Estado por defecto de mensajes 
         $content = 'Se registró tu opinión con éxito';//Contenido del mensaje por defecto
         $questions = Question::where('active',TRUE)->get();
         $pollTest= Poll::where('idTicket',$ticket->idTicket)->first();
         if($pollTest){
             $status = 'error';//Estado por defecto de mensajes 
             $content = 'Ya has llenado una encuesta de este ticket anteriormente';//Contenido del mensaje por defecto
         }
         else{
             
                    $poll= new Poll();
                    $poll->idTicket=$ticket->idTicket;
                    $poll->score=$request->score;
                    $poll->save();
                    $i=0;
                    foreach($questions as $question){
                        $i=$i+1;
                        $answer= new Answer();
                        $answer->idPoll = $poll->idPoll;
                        $answer->idQuestion=$question->idQuestion;
                        $arrayAnswer = $request->only([$question->idQuestion]);
                        $answer->answer=$arrayAnswer[$i];
                        $answer->save();   
                    }
              
         }
        return back()
        ->with('process_result',[
         'status'=>$status,
         'content'=>$content
         ]);
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
