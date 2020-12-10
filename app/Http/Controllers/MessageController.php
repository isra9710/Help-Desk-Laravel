<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
use App\Models\File;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class MessageController extends Controller
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
    public function create(Ticket $ticket, $option)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $messages = Message::where('idTicket',$ticket->idTicket)->paginate(4);
        return view('management.messages.addMessage',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'messages'=>$messages,'option'=>$option]);
    }

    public function createG(Ticket $ticket){
        $messages = Message::where('idTicket',$ticket->idTicket)->paginate(4);
        return view('management.messages.addMessageG',['ticket'=>$ticket,'messages'=>$messages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Ticket $ticket,$option)
    {
        //
       
        $message = new Message();
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se registró tu comentario al ticket '.$ticket->idTicket.' con éxito';//Contenido del mensaje por defecto
        try{
            $message->idTicket=$ticket->idTicket;
            $message->text=$request->text;
            $message->save();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar asociar un comentario al ticket número'.$ticket->idTicket;
        }
        if($option==1)
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('coordinator.ticket.inbox',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        elseif($option==2){
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()->route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        elseif($option==3){
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isCoordinator()){
                return redirect()
                ->route('coordinator.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAssistant()){
                return redirect()
                ->route('assistant.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAgent()){
                return redirect()
                ->route('agent.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('user.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }         
        }
        else{
            return redirect()
            ->route('agent.ticket.attend',['user'=>auth()->user()])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }


    public function storeG(Ticket $ticket, Request $request){
        $message = new Message();
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se registró tu comentario al ticket '.$ticket->idTicket.' con éxito';//Contenido del mensaje por defecto
        
        try{
            $message->idTicket=$ticket->idTicket;
            $message->text=$request->text;
            $message->save();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar asociar un comentario al ticket número'.$ticket->idTicket;
        }
        return redirect()
        ->route('guest.ticket.index',['ticket'=>$ticket])
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
