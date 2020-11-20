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
    public function create(Ticket $ticket)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $files=File::where('idTicket',$ticket->idTicket)->paginate(2);
        return view('management.file.addFile',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'files'=>$files]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ticket $ticket,Request $request)
    {
        //
        $dataFile = new File();
        $fileName = "";//Nombre del archivo
        $dataFile->idTicket=$ticket->idTicket;
        $dataFile->save();
        $file= $request->file('file');
        $fileName =auth()->user()->username.$dataFile->idFile.$request->file->getClientOriginalName();
        $path = $file->storeAs('public',$fileName);
        $dataFile->directoryFile = $path;
        $dataFile->update();
        if(auth()->user()->isAdministrator()){
            return redirect()->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
        }
        else{
            return redirect()->route('coordinator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
        }
        
       

    }
    public function myStore(Ticket $ticket){
        if(auth()->user()->isAdministrator()){

        }
        elseif(auth()->user()->isCoordinator()){

        }
        elseif(auth()->user()->isAssistant()){

        }
        elseif(auth()->user()->isAgent()){

        }
        elseif(auth()->user()->isUser()){

        }
        else{

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
