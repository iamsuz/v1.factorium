<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\KonkreteController;
use App\InvestorProjectToken;
use App\SchedulerJob;

class UpdateInvestorsTokenBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investor:token:balance';

    protected $konkrete;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->konkrete = new KonkreteController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Command investor:token:balance execution STARTED @ " . \Carbon\Carbon::now());

        // Track the Job execution date time
        $job = SchedulerJob::create([
            'type' => 'investor_project_tokens'
        ]);

        $investorsProjects = \DB::table('users')
            ->join('investment_investor', 'users.id', '=', 'investment_investor.user_id')
            ->join('projects', 'projects.id', '=', 'investment_investor.project_id')
            ->select('users.id as user_id', 'users.wallet_address', 'projects.id as project_id')
            ->where('users.wallet_address', '<>', '')
            ->where('projects.wallet_address', '<>', '')
            ->where('projects.contract_address', '<>', '')
            ->groupBy(['user_id', 'project_id'])
            ->get();
        foreach ($investorsProjects as $key => $value) {
            $result = $this->konkrete->getUserTokenBalance($value->wallet_address, $value->project_id);
            $resultArr = json_decode($result->getContent());
            \Log::info($result);
            if($resultArr->status) {
                $resultData = $resultArr->data;

                $investorTokens = InvestorProjectToken::where('user_id', $value->user_id)->where('project_id', $value->project_id);

                if(count($investorTokens->get())) {
                    $investorTokens->update([
                        'tokens' => $resultData->balance,
                        'job_id' => $job->id
                    ]);
                } else {
                    InvestorProjectToken::create([
                        'user_id' => $value->user_id,
                        'project_id' => $value->project_id,
                        'tokens' => $resultData->balance,
                        'symbol' => $resultData->symbol,
                        'job_id' => $job->id
                    ]);
                }
            }
        }

        \Log::info("Command investor:token:balance execution ENDED @ " . \Carbon\Carbon::now());
    }
}
