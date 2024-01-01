<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\VoterProfile;

class VotersReportExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $district;
    protected $state;

    public function __construct($district = null, $state = null)
    {
        $this->district = $district;
        $this->state = $state;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = VoterProfile::query();

        if ($this->district) {
            $query->where('district', 'like', '%' . $this->district . '%');
        }
        if ($this->state) {
            $query->where('state', 'like', '%' . $this->state . '%');
        }

        return $query->get(['first_name', 'last_name', 'dob', 'register_id', 'email', 'mobile', 'address', 'taluk', 'district', 'state', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Date of Birth',
            'Registration Id',
            'Email',
            'Mobile',
            'address',
            'taluk',
            'district',
            'state',
            'Created At',
        ];
    }
}
