<?php

namespace App;

use App\Models\Log;
use Illuminate\Http\Request;

class Logger
{
    public static function logAction(Request $request = null, $sourceModel, $sourceId, $action = null, $targetModel = null, $targetId = null, $description = null, $note=null)
    {
        $log                = new Log();
        $log->user_id       = auth()->id();
        $log->action        = $action ? $action : $request->method() . ' ' . $request->path();
        $log->srce_model    = $sourceModel;
        $log->srce_id       = $sourceId;
        $log->trgt_model    = $targetModel;
        $log->trgt_id       = $targetId;
        $log->description   = $description ? $description : ('Realizó la acción ' . $request->method() . ' en ' . $request->path());
        $log->note          = $note;
        $log->save();
    }
}