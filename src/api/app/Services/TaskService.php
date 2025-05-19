<?php

namespace App\Services;

use App\Models\Task;
use App\Services\UsesRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    use UsesRepository;

    /**
     * @param string $id
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return \App\Models\Task
     */
    public function attachFile(string $id, UploadedFile $file): Task
    {
        $fileName = $file->getClientOriginalName();
        Storage::disk("storage")->put($fileName, $file->getContent());

        $attachmentUrl = asset("storage/$fileName");
        $updateAttributes = [
            "attachment_url" => $attachmentUrl
        ];

        $task = $this->repository()->task()->update($id, $updateAttributes, true);
        return $task;
    }
}
