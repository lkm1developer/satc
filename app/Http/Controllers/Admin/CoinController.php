<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use Auth;
use Validator;
use App\IP;
use App\Server;
use App\Sharednode;
use App\Reservation;
use Carbon\Carbon;
use Response; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
       $coins=allmasternode::with('MNS')->get();
	   return view('admin.coin.index')->with('coins',$coins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.coin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
				// 'ipfile' => 'required|file|mimes:txt|max:2048'	
				'name' => 'required|string',	
				'python_name' => 'required|string'	,
				'masternode' => 'required|string'	,
				'timeoutgap' => 'required|numeric',	
				'time' => 'required|numeric',	
				'shortnm' => 'required|string'	,
				'port' => 'required|integer'	,
				'minbal' => 'required|integer'	,
				'shortnm' => 'required|string'	,
				'bitcoin_talk' => 'required|url'	,
				'github' => 'required|url'	,
				'discord' => 'required|url'	,
				'twitter' => 'required|url'	,
				'explorer_link' => 'required|url',	
				'website' => 'required|url'	,
				'logo' => 'required|file|mimes:png,png,gif|max:2048',	
							
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput();
				
			} 
		 
		$image = $request->file('logo');
		$filename=time().'.'.$image->getClientOriginalExtension();		
		$destinationPath = public_path('/images');
		$image->move($destinationPath, $filename);
		$coin = new allmasternode;		
		$coin->logo='/images/'.$filename;		
		$coin->name=$request->get('name');
		$coin->py_name=$request->get('python_name');
		$coin->masternode=$request->get('masternode');
		$coin->timeoutgap=$request->get('timeoutgap');
		$coin->estmtime=$request->get('time');
		$coin->coinname=$request->get('name');
		$coin->shortnm=$request->get('shortnm');
		$coin->port=$request->get('port');
		$coin->kyd=$request->get('kyd');
		$coin->minbal=$request->get('minbal');
		$coin->bitcoin_talk=$request->get('bitcoin_talk');
		$coin->github=$request->get('github');
		$coin->discord=$request->get('discord');
		$coin->twitter=$request->get('twitter');
		$coin->explorer_link=$request->get('explorer_link');
		$coin->website=$request->get('website');
		$coin->active=$request->get('active');
        $coin->save();
		Session::flash('message', 'Coin Added'); 
		
		return redirect('/admin/coins/'.$coin->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
         $coins=allmasternode::where('id',$id)->with('MNS')->first();
		 return view('admin.coin.show')->with('coins',$coins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
		$coin=allmasternode::findorfail($id);
		$validator = Validator::make($request->all(), [
				// 'ipfile' => 'required|file|mimes:txt|max:2048'	
				'name' => 'required|string',	
				'python_name' => 'required|string'	,
				'masternode' => 'required|string'	,
				'timeoutgap' => 'required|numeric',	
				'time' => 'required|numeric',	
				'shortnm' => 'required|string'	,
				'port' => 'required|integer'	,
				'minbal' => 'required|integer'	,
				'shortnm' => 'required|string'	,
				'bitcoin_talk' => 'required|url'	,
				'github' => 'required|url'	,
				'discord' => 'required|url'	,
				'twitter' => 'required|url'	,
				'explorer_link' => 'required|url',	
				'website' => 'required|url'	,
					
							
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput();
				
			} 
		if($request->has('logo')){
			$validator = Validator::make($request->all(), [
				'logo' => 'required|file|mimes:png,png,gif|max:2048'							
			]);
			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput();				
			} 
		$image = $request->file('logo');
		$filename=time().'.'.$image->getClientOriginalExtension();		
		$destinationPath = public_path('/images');
		$image->move($destinationPath, $filename);
		$coin->logo='/images/'.$filename;
		}			
		$coin->name=$request->get('name');
		$coin->py_name=$request->get('python_name');
		$coin->py_name=$request->get('masternode');
		$coin->timeoutgap=$request->get('timeoutgap');
		$coin->estmtime=$request->get('time');
		$coin->coinname=$request->get('name');
		$coin->shortnm=$request->get('shortnm');
		$coin->port=$request->get('port');
		$coin->minbal=$request->get('minbal');
		$coin->kyd=$request->get('kyd');
		$coin->bitcoin_talk=$request->get('bitcoin_talk');
		$coin->github=$request->get('github');
		$coin->discord=$request->get('discord');
		$coin->twitter=$request->get('twitter');
		$coin->explorer_link=$request->get('explorer_link');
		$coin->website=$request->get('website');
		$coin->active=$request->get('active');
        $coin->save();
		Session::flash('message', 'Coin Updated'); 
		return redirect('/admin/coins/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
       allmasternode::destroy($id);
	   Session::flash('message', 'Coin Deleted'); 
	   return redirect('admin/coins');
    }

}