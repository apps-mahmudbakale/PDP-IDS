<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

trait ExportsMemberListPdf
{
    /**
     * Export the category's member listing to a PDF document.
     *
     * Expects the consuming controller to define `$category` and
     * `$categoryLabel` properties.
     */
    public function exportPdf(): Response
    {
        $members = Member::where('category', $this->category)->get();

        $view = view('pages.apps.members._list-pdf', [
            'members' => $members,
            'label' => $this->categoryLabel,
        ]);

        $render = fn ($totalPages) => Pdf::loadHTML($view->with('totalPages', $totalPages)->render())
            ->setPaper('a4', 'landscape');

        // dompdf does not support the `pages` CSS counter, so render once to
        // learn the page count, then render again with the total baked in.
        $probe = $render(0);
        $probe->render();

        $pageCount = $probe->getCanvas()->get_page_count();

        $filename = strtolower($this->category).'-members-'.now()->format('Y-m-d').'.pdf';

        return $render($pageCount)->download($filename);
    }
}
