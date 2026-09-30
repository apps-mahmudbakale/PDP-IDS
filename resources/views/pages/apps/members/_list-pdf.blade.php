<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $label }} Members</title>
    <style>
        @page {
            margin: 28mm 12mm 20mm 12mm;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 9px;
            color: #1f2937;
            margin: 0;
        }

        .page-footer {
            position: fixed;
            bottom: -16mm;
            left: 0;
            right: 0;
            font-size: 8px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 4px;
        }

        .page-footer:after {
            content: "Page " counter(page) " of {{ $totalPages }}";
            float: right;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        header {
            margin-bottom: 10px;
        }

        header h1 {
            font-size: 15px;
            margin: 0 0 3px 0;
        }

        header .meta {
            font-size: 8.5px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #f3f4f6;
            color: #111827;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            text-align: left;
            padding: 7px 6px;
            border-bottom: 1px solid #d1d5db;
        }

        tbody td {
            padding: 6px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .cell-user {
            width: 34%;
        }

        /* Departments add a seventh column, so the name column yields space. */
        .with-department .cell-user {
            width: 26%;
        }

        .cell-department {
            width: 14%;
        }

        .cell-photo {
            width: 12%;
            text-align: center;
        }

        /*
         * dompdf does not grow a table row to fit a replaced element, so a
         * photo taller than the row spills over the row beneath it. The row
         * is pinned to the photo height plus cell padding instead, and the
         * photo is made a block box so it contributes to that height.
         */
        td.photo-cell {
            height: 60pt;
            padding: 4px;
        }

        .cell-dob {
            width: 10%;
        }

        .photo {
            display: block;
            width: 60pt;
            height: 60pt;
            margin: 0 auto;
        }

        .initials {
            display: block;
            width: 60pt;
            height: 60pt;
            background-color: #e1f4fb;
            color: #0d99c6;
            font-size: 26px;
            font-weight: bold;
            line-height: 60pt;
            text-align: center;
        }

        .name {
            font-weight: bold;
        }

        .subtitle {
            font-size: 8px;
            color: #6b7280;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 24px 0;
            font-size: 10px;
        }
    </style>
</head>
<body class="{{ $withDepartment ? 'with-department' : '' }}">

<header>
    <h1>{{ $label }} Members</h1>
    <div class="meta">
        Total members: {{ $members->count() }} &nbsp;|&nbsp; Generated on {{ now()->format('d M Y, h:i A') }}
    </div>
</header>

<table>
    <thead>
        <tr>
            <th class="cell-photo">Photo</th>
            <th class="cell-user">Name</th>
            <th>Position</th>
            @if($withDepartment)
                <th class="cell-department">Department</th>
            @endif
            <th>Phone</th>
            <th>State</th>
            <th class="cell-dob">DOB</th>
        </tr>
    </thead>
    <tbody>
        @forelse($members as $member)
            <tr>
                <td class="center photo-cell">
                    @if($member->image_data_uri)
                        <img src="{{ $member->image_data_uri }}" alt="{{ $member->firstname }}" class="photo">
                    @else
                        <div class="initials">{{ substr($member->firstname, 0, 1) }}{{ substr($member->surname, 0, 1) }}</div>
                    @endif
                </td>
                <td>
                    <div class="name">{{ $member->full_name }}</div>
                    @if($member->title)
                        <div class="subtitle">{{ $member->title }}</div>
                    @endif
                </td>
                <td>{{ $member->position }}</td>
                @if($withDepartment)
                    <td>{{ $member->department ?? 'N/A' }}</td>
                @endif
                <td>{{ $member->phone ?? 'N/A' }}</td>
                <td>{{ $member->state ?? 'N/A' }}</td>
                <td>{{ $member->dob?->format('Y-m-d') ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ $withDepartment ? 7 : 6 }}" class="empty">No {{ $label }} members found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="page-footer"></div>

</body>
</html>
