<?php

namespace App\Jobs;

use App\Project;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Konkrete as KonkreteClient;

class LoadProjectWallet extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $project;
    protected $konkreteClient;
    protected $responseResult;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->responseResult;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $project = Project::findOrFail($this->project->id);
        $konkreteClient = new KonkreteClient();
        if($project->wallet_address && $project->contract_address) {
            $response =  $konkreteClient->curlKonkrete('POST', '/api/v1/contracts/transfer', [], [
                'project_id' => $this->project->id,
                'wallet_address' => $project->wallet_address
            ]);
            $this->responseResult = json_decode($response);

            if($this->responseResult->status) {
                    // Update contract address in DB
                $project->is_wallet_tokenized = 1;
                $project->save();

            }
        }
    }
    public function getResponse()
    {
        return $this->responseResult;
    }
}
