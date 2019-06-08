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
use App\Template;
use Mail;
use FroalaEditor_Image;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use App\Jobs\SendNewsLetter;
use App\Jobs\SendWelcomeEmail;
use Log;
class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function Index()
    {
       $Templates=Template::all();
	   return view('admin.template.index')->with('templates',$Templates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function Create()
    {
        return view('admin.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function Store(Request $request)
    {
		//var_dump($request->all());
		//die;
        $validator = Validator::make($request->all(), [
				// 'ipfile' => 'required|file|mimes:txt|max:2048'	
				'title' => 'required|string',
							
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput();
				
			} 
		 
		
		$coin = new Template;	
		$coin->title=$request->get('title');
		$coin->html=$request->get('template');
        $coin->save();
		Session::flash('message', 'Template Added'); 
		
		return redirect('/admin/template/'.$coin->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function Show($id)
    {
         $Template=Template::findorFail($id);
		 return view('admin.template.show')->with('template',$Template);
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
    public function Update($id,Request $request)
    {
		$coin=Template::findorfail($id);
		$validator = Validator::make($request->all(), [	
				'title' => 'required|string',
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput();
				
			} 
		$coin->title=$request->get('title');
		$coin->html=$request->get('template');
        $coin->save();
		Session::flash('message', 'Template Updated'); 
		return redirect('/admin/template/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function Destroy($id)
    {
       Template::destroy($id);
	   Session::flash('message', 'Template Deleted'); 
	   return redirect('admin/template');
    }
	public function SendTemplate($id)
    {
       $template=Template::findorfail($id);
	    $users = User::all();
	    // $users = User::where('id',39)->get();
	   // $user = User::find(39);
	    foreach($users as $key=>$user){
			$k= ($key%100)+1;
			$this->dispatch((new SendNewsLetter($id, $user))->delay(Carbon::now()->addSeconds($k*5)));
			//((new SendNewsLetter($id, $user))->handle());
			//var_dump(time());
	    }
		Log::info("Request Cycle with Queues Begins");
       // $ck= $this->dispatch((new SendWelcomeEmail($id))->delay(Carbon::now()->addSeconds(2)));
       // $ck= $this->dispatch((new SendWelcomeEmail($id)));
        //$ck= $this->dispatch((new SendNewsLetter($id))->delay(Carbon::now()->addSeconds(12)));
       //$ck= ((new SendNewsLetter($id))->handle());
       // $ck= ((new SendNewsLetter($id))->handle());
       // $ck= $this->dispatch((new SendWelcomeEmail()));
       //$ck= (new SendWelcomeEmail($id))->handle();
	   //var_dump($ck);die;
       //$dis= $this->dispatch((new SendWelcomeEmail())->delay(Carbon::now()->addSeconds(2)));
        Log::info("Request Cycle with Queues Ends");
        
        
	   Session::flash('message', 'Email batch start '); 
	   return redirect('admin/template');
    }
	

}