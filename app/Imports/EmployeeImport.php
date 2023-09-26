<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $employee = new Employee([
            "name" => $row['name'],
            "lastname" => $row['lastname'],
            "id_number" => $row['id_number'],
            "number" => $row['number'],
            "gender" => $row['gender'],
            "department" => $row['department'],
            "position" => $row['position'],
            "branch_id" => $row['branch_id'],
            "birthday" => null,
            "role" => $row['role'],
        ]);
        return $employee;
    }
}
