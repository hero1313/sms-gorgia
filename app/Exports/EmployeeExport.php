<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class EmployeeExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        $type = Employee::all();
        return $type ;
    }
     public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Lastname',
            'Id number',
            'Number',
            'Gender',
            'Department',
            'Position',
            'Branch',
            'Birthday',
            '',
            
        ];
    }
}
