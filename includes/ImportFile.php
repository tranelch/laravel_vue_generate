<?php
$import_content = "<?php
declare(strict_types = 1);

namespace App\Imports;

use App\Models\\" . $text['camelUpper']['singular'] . ";
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
//use Maatwebsite\Excel\Concerns\WithUpserts;

class " . $text['camelUpper']['plural'] . "Import implements ToModel, WithBatchInserts, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected \$validationRules;

    public function __construct(array \$validationRules) {
        \$this->validationRules = \$validationRules;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    /**
    * @param array \$row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array \$row)
    {
        // We want to expect a header row, but not use the header values as keys
        \$row = array_values(\$row);

        return new " . $text['camelUpper']['singular'] . "([
$imports_line        ]);
    }

    public function rules(): array
    {
        return \$this->validationRules;
    }
}
";

if (!is_dir('generated/app/Imports')) {
    mkdir('generated/app/Imports', 0777, true);
}
$file = fopen('generated/app/Imports/'. $text['camelUpper']['plural'] . 'Import.php', "w");
fputs($file, $import_content);
fclose($file);
