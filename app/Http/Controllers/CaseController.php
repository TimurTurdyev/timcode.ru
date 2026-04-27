<?php

namespace App\Http\Controllers;

use App\Services\MarkdownCaseParser;
use Illuminate\View\View;

class CaseController extends Controller
{
    public function show(string $slug): View
    {
        $path = resource_path("content/cases/{$slug}.md");

        abort_unless(file_exists($path), 404);

        $realPath = realpath($path);
        $basePath = realpath(resource_path('content/cases'));

        if (! $realPath || ! $basePath || ! str_starts_with($realPath, $basePath . DIRECTORY_SEPARATOR)) {
            logger()->warning('[FIX] Path traversal attempt blocked', ['slug' => $slug, 'resolved' => $realPath]);
            abort(404);
        }

        $raw = file_get_contents($realPath);
        ['meta' => $meta, 'html' => $html] = (new MarkdownCaseParser())->parseFull($raw);

        return view('cases.show', compact('meta', 'html', 'slug'));
    }
}
