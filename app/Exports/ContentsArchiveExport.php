<?php

namespace App\Exports;

use App\Models\UserArchive;
use App\Models\UserContent;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;


class ContentsArchiveExport implements FromCollection, WithHeadings
{
    private $contentArchive;

    public function __construct($contentArchive)
    {
        $this->contentArchive = $contentArchive;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection($this->contentArchive);
    }

    public function headings(): array
    {
        // return ["No", "Content Posted", "Caption", "Date Post"];
        return ["Content Posted", "Caption", "Date Post"];
    }
}
