<?php

namespace App\Observers;

use App\Models\CuSubmission;
use App\Services\CuSelectionService;

class CuSubmissionObserver
{
    protected CuSelectionService $service;

    public function __construct(CuSelectionService $service)
    {
        $this->service = $service;
    }

    public function updated(CuSubmission $submission)
    {
        // kalau baru saja disetujui, recalculation
        if ($submission->isDirty('status')
            && $submission->status === CuSubmission::STATUS_APPROVED) {
            $this->service->recalculateForPeserta($submission->peserta_id);
        }
    }
}
