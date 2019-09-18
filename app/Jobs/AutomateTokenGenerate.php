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
    protected $projectId;
    protected $numberOfTokens;
    protected $tokenSymbol;
    protected $projectHash;
    protected $responseResult;
    protected $url;
    
    public function __construct($projectId,$numberOfTokens,$tokenSymbol,$projectHash)
    {
        $this->projectId = $projectId;
        $this->numberOfTokens = $numberOfTokens;
        $this->tokenSymbol = $tokenSymbol;
        $this->projectHash = $projectHash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->url = env('KONKRETE_IP', 'http://localhost:5050');
        
        $client = new \GuzzleHttp\Client();
        $request = $client->request('POST',$this->url.'/contract/deploy',[
            'query'=>['project_id'=> $this->projectId,'project_name'=>$this->projectHash,'token_symbol'=>$this->tokenSymbol,'number_of_tokens'=>$this->numberOfTokens]
        ]);
        $response = $request->getBody()->getContents();

        $this->responseResult = json_decode($response);

        if($this->responseResult->status) {
            $project = Project::findOrFail($this->projectId);
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
