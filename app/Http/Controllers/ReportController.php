<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VotersReportExport;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\VoterProfile;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {

            $query = VoterProfile::query();

            if ($request->filled('district')) {
                $query->where('district', 'like', '%' . $request->input('district') . '%');
            }
            if ($request->filled('state')) {
                $query->where('state', 'like', '%' . $request->input('state') . '%');
            }

            $data = $query->get(['id', 'first_name', 'last_name', 'dob', 'email', 'mobile', 'created_at']);

            $report_export_url = route('export.voters', [
                'district' => $request->input('district'),
                'state' => $request->input('state')
            ]);
        
            return view('reports.list', ['data' => $data, 'export_url' => $report_export_url]);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the request'], 500);
        }
    }

    public function export(Request $request)
    {
        $district = $request->district;
        $state = $request->state;
        
        $file_name = 'voters_reports_'.\Carbon\Carbon::now().'.xlsx';

        return Excel::download(new VotersReportExport($district, $state), $file_name);
    }
}
