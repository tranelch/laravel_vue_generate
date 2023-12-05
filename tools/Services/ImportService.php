<?php
namespace App\Services;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportService
{
    /**
    * @param WithHeadingRow $importObject
    * @param string|\Illuminate\Http\UploadedFile $importFile
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    *
    * @throws \Exception
    */
    public static function handleImport(WithHeadingRow $importObject, string|\Illuminate\Http\UploadedFile $importFile): void {
        try {
            Excel::import($importObject, $importFile);
            return;
        } catch (ValidationException $e) {
            $message = "There were errors on your import:\n";
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // int row
                $failure->attribute(); // string heading key or column index
                $failure->errors(); // Array error messages from Laravel validator
                $failure->values(); // Array values of the row that has failed.
                $message .= "Error on row " . $failure->row() . ", column " . $failure->attribute() . ": " . implode("\n", $failure->errors()) . "\n";
            }

            throw new \Exception($message);
        }
    }
}