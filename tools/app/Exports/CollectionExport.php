<?php

namespace App\Exports;

use \Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollectionExport implements FromCollection, WithHeadings
{
    protected $collection;
    protected $heading;

    public function __construct(Collection $collection, Array $heading)
    {
        $this->collection = $collection;
        $this->heading = $heading;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return $this->heading;
    }
}
