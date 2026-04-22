<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\DownloadLogs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DownloadRedirectController extends Controller
{
    public function __invoke(Request $request, Download $download): RedirectResponse
    {
        $ip = $request->ip();

        $recentlyCounted = DownloadLogs::query()
            ->where('file_name', $download->file_name)
            ->where('ip', $ip)
            ->where('timestamp', '>=', now()->subDay())
            ->exists();

        if (! $recentlyCounted) {
            $download->increment('count');
        }

        DownloadLogs::create([
            'file_name' => $download->file_name,
            'ip' => $ip,
            'timestamp' => now(),
        ]);

        return redirect()->away($download->file_url);
    }
}
