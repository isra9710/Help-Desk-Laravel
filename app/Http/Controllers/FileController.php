<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
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
    public function create(Ticket $ticket,$option)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $files=File::where('idTicket',$ticket->idTicket)->paginate(2);
        return view('management.file.addFile',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'files'=>$files,'option'=>$option]);
    }

    public function createG(Ticket $ticket){
        
        $files=File::where('idTicket',$ticket->idTicket)->paginate(2);
        return view('management.file.addFileG',['ticket'=>$ticket,'files'=>$files]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ticket $ticket,$option,Request $request)
    {
        //
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se anexó con éxito tu archivo al ticket '.$ticket->idTicket;//Contenido del mensaje por defecto
        try{
            $dataFile = new File();
            $fileName = "";//Nombre del archivo
            $dataFile->idTicket=$ticket->idTicket;
            $dataFile->fileDescription=$request->fileDescription;
            $dataFile->directoryFile="x";
            $dataFile->save();
            $file= $request->file('file');
            $fileName =auth()->user()->username.$dataFile->idFile.$request->file->getClientOriginalName();
            $path = $file->storeAs('public',$fileName);
            $dataFile->directoryFile = $path;
            $dataFile->update();
        }
        catch(\Throwable $th){
            $status = 'error';
            $content= 'Error al intentar asociar el archivo al ticket número'.$ticket->idTicket;
        }
        if($option==1){
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
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se anexó con éxito tu archivo al ticket '.$ticket->idTicket;//Contenido del mensaje por defecto
        try{
            $dataFile = new File();
            $fileName = "";//Nombre del archivo
            $dataFile->idTicket=$ticket->idTicket;
            $dataFile->fileDescription=$request->fileDescription;
            $dataFile->directoryFile="x";
            $dataFile->save();
            $file= $request->file('file');
            $fileName =$ticket->employeeNumber.$dataFile->idFile.$request->file->getClientOriginalName();
            $path = $file->storeAs('public',$fileName);
            $dataFile->directoryFile = $path;
            $dataFile->update();
        }
        catch(\Throwable $th){
            $status = 'error';
            $content= 'Error al intentar asociar el archivo al ticket número'.$ticket->idTicket;
        }
   
        return redirect()
        ->route('guest.ticket.show',['ticket'=>$ticket])
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

    public function download(File $file){
        return response()->download('storage/'.$file->directoryFile);
    }
}
