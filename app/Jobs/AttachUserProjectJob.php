<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AttachUserProjectJob implements ShouldQueue
{
    use Queueable;

    private int $user_id;

    /**
     * Create a new job instance.
     */
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $project = Project::create([
            'name' => 'Project for user ' . $this->user_id,
        ]);

        $project->users()->sync([$this->user_id]);
    }
}
