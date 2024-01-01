<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\VoterProfile;
use Exception;
use Str;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = VoterProfile::select('id', 'first_name', 'last_name', 'dob', 'email', 'mobile', 'created_at');
                
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        return $row->first_name . ' ' . $row->last_name;
                    })
                    ->addColumn('dob', function($row){
                        return $row->age;
                    })
                    ->addColumn('action', function($row){
                        $editUrl = route('voter.edit', ['voter' => $row->id]);
                        $deleteUrl = route('voter.destroy', ['voter' => $row->id]);
                        $actionBtn = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>
                        <a href="#" class="delete btn btn-danger btn-sm delete-confirm" data-remote="'.$deleteUrl.'" data-method="delete">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        
            return view('voters.list');
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the request'], 500);
        }
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('voters.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'dob.required' => 'The date of birth is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'The minimum age should be 18 years old.',
        ];

        $this->validate($request, [
            'dob' => 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:voter_profiles,email',
            'mobile' => 'required||regex:/^[6-9]{1}[0-9]{9}$/',
            'address' => 'required|min:5',
            'taluk' => 'required|min:5',
            'district' => 'required|min:5',
            'state' => 'required|min:5',
        ], $messages);

        try {

            $voter_profile = new VoterProfile();
            $voter_profile->first_name = $request->first_name;
            $voter_profile->last_name = $request->last_name;
            $voter_profile->dob = $request->dob;
            $voter_profile->register_id = 'voter-id-reg-num: '.Str::random(6);
            $voter_profile->email = $request->email;
            $voter_profile->mobile = $request->mobile;
            $voter_profile->address = $request->address;
            $voter_profile->taluk = $request->taluk;
            $voter_profile->district = $request->district;
            $voter_profile->state = $request->state;
            $voter_profile->save();

            Mail::send('mails.voter_register_verification',
                ['voter_profile' => $voter_profile, 'register_id' => $voter_profile->register_id], function ($m) use ($voter_profile) {
                    $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $m->to($voter_profile->email, $voter_profile->first_name. ' '. $voter_profile->last_name);
                    $m->subject("Congratulations on Completing Your Voter ID Registration!");
                }
            );

                return redirect()->route('voter.index')->with(['status' => 'success', 'message' => 'voter profile stored successfully']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the request'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voter_profile = VoterProfile::find($id);

        return view('voters.edit', ['voter_profile' => $voter_profile]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'dob.required' => 'The date of birth is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'The minimum age should be 18 years old.',
        ];

        $this->validate($request, [
            'dob' => 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:voter_profiles,email,'.$id,
            'mobile' => 'required||regex:/^[6-9]{1}[0-9]{9}$/',
            'address' => 'required|min:5',
            'taluk' => 'required|min:5',
            'district' => 'required|min:5',
            'state' => 'required|min:5',
        ], $messages);

        try {

            $voter_profile = VoterProfile::findOrFail($id);
            $voter_profile->first_name = $request->first_name;
            $voter_profile->last_name = $request->last_name;
            $voter_profile->dob = $request->dob;
            $voter_profile->email = $request->email;
            $voter_profile->mobile = $request->mobile;
            $voter_profile->address = $request->address;
            $voter_profile->taluk = $request->taluk;
            $voter_profile->district = $request->district;
            $voter_profile->state = $request->state;
            $voter_profile->save();

                return redirect()->route('voter.index')->with(['status' => 'success', 'message' => 'voter profile updated successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Record not found.');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the request'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $voter_profile = VoterProfile::findOrFail($id);
            $voter_profile->delete();

            return redirect()->route('voter.index')->with(['status' => 'success', 'message' => 'voter profile deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Record not found.');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the request'], 500);
        }
    }
}
