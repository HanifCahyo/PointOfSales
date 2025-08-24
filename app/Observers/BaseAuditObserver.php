<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;


class BaseAuditObserver
{
    protected function log($model, string $action, array $oldValues = null, array $newValues = null)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $model->getTable(),
            'record_id' => $model->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }

    public function created($model)
    {
        $this->log($model, 'created', null, $model->toArray());
    }

    public function updated($model)
    {
        $this->log(
            $model,
            'updated',
            $model->getOriginal(),
            $model->getChanges()
        );
    }

    public function deleted($model)
    {
        $this->log($model, 'deleted', $model->toArray(), null);
    }
}
