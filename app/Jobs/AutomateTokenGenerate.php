<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Project;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutomateTokenGenerate extends Job implements SelfHandling,ShouldQueue
{
    use  InteractsWithQueue, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $project;
    protected $responseResult;
    public function __construct($project)
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
        $project = $this->project;
        $project= Project::findOrFail($project);
        $tokens = $project->investment->invoice_amount;
        $url = env('KONKRETE_IP', 'http://localhost:5050');
        $client = new \GuzzleHttp\Client();
        $request = $client->request('POST',$url.'/contract/deploy',[
            'query'=>['project_id'=> $project->id,'project_name'=>$project->project_site,'token_symbol'=>$project->token_symbol,'number_of_tokens'=>$tokens]
        ]);
        $response = $request->getBody()->getContents();

        $this->responseResult = json_decode($response);

        if($this->responseResult->status) {
            // Update contract address in DB
            $project->contract_address = $this->responseResult->data->contract_address;
            $project->save();
        }
    }

    public function getResponse()
    {
        return $this->responseResult;
    }
}
