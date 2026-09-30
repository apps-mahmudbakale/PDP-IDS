<?php

namespace App\Http\Controllers\Concerns;

use App\Enums\MemberCategory;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

trait ExportsMemberListPdf
{
    /**
     * Export the category's member listing to a PDF document.
     *
     * Expects the consuming controller to define a `$category` property.
     */
    public function exportPdf(): Response
    {
        $members = Member::where('category', $this->category)->get();
        $category = MemberCategory::tryFrom($this->category);

        $view = view('pages.apps.members._list-pdf', [
            'members' => $members,
            'label' => $this->categoryLabel(),
            'withDepartment' => $category?->usesDepartment() ?? false,
        ]);

        $render = fn ($totalPages) => Pdf::loadHTML($view->with('totalPages', $totalPages)->render())
            ->setPaper('a4', 'landscape');

        // dompdf does not support the `pages` CSS counter, so render once to
        // learn the page count, then render again with the total baked in.
        $probe = $render(0);
        $probe->render();

        $pageCount = $probe->getCanvas()->get_page_count();

        $filename = str_replace('_', '-', strtolower($this->category))
            .'-members-'.now()->format('Y-m-d').'.pdf';

        return $render($pageCount)->download($filename);
    }

    /**
     * The human readable name of this controller's category, resolved from
     * the MemberCategory enum.
     */
    protected function categoryLabel(): string
    {
        return MemberCategory::tryFrom($this->category)?->label() ?? $this->category;
    }
}
