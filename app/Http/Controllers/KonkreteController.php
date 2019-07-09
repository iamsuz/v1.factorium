<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\IssueingToken;
use App\Transaction;
use App\Services\Konkrete as KonkreteClient;
use App\Project;

class KonkreteController extends Controller
{
    protected $konkreteClient;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->konkreteClient = new KonkreteClient();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create smart contract wallet
     * Deploy smart contract
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function tokenize(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'number_of_tokens' => 'required|integer|min:100',
            'token_symbol' => 'required|alpha|between:3,4'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if($request->project_id) {

            // Valid request
            $projectId = (int)$request->project_id;
            $numberOfTokens = $request->number_of_tokens;
            $tokenSymbol = $request->token_symbol;

            $projectDetails = Project::findOrFail($projectId);
            $projectHash = $projectDetails->project_site;

            $response =  $this->konkreteClient->curlKonkrete('POST', '/api/v1/contracts/deploy', [], [
                'project_id' => $projectId,
                'project_name' => $projectHash,
                'token_symbol' => $tokenSymbol,
                'number_of_tokens' =>$numberOfTokens
            ]);

            $responseResult = json_decode($response);

            if($responseResult->status) {

                // Update contract address in DB
                $projectDetails->contract_address = $responseResult->data->contract_address;
                $projectDetails->save();

                return response([
                    'status' => true,
                    'message' => 'Contract deployed successfully! Please verify the contract once page is reloaded!',
                    'data' => $responseResult->data
                ], 200);

            } else {
                return response([
                    'status' => false,
                    'message' => $responseResult->message
                ], 200);
            }

        } else {
            return response()->status(400);
        }
    }

    /**
     * Load project wallet with tokens from owner wallet
     * @param projectId int
     * @return \Illuminate\Http\Response
     */
    public function loadProjectWallet($projectId)
    {
        if($projectId) {
            $project = Project::findOrFail((int)$projectId);

            if($project->wallet_address && $project->contract_address) {
                $response =  $this->konkreteClient->curlKonkrete('POST', '/api/v1/contracts/transfer', [], [
                    'project_id' => (int)$projectId,
                    'wallet_address' => $project->wallet_address
                ]);
                $responseResult = json_decode($response);

                if($responseResult->status) {
                    // Update contract address in DB
                    $project->is_wallet_tokenized = 1;
                    $project->save();

                    return response([
                        'status' => true,
                        'message' => $responseResult->message
                    ], 200);

                } else {
                    return response([
                        'status' => false,
                        'message' => $responseResult->message
                    ], 200);
                }

            } else {
                return response()->status(400);
            }
        } else {
            return response()->status(400);
        }
    }

    /**
     * Get contract details
     * @param projectId int
     * @return \Illuminate\Http\Response
     */
    public function getContractDetails($projectId)
    {
        if($projectId) {
            $response =  $this->konkreteClient->curlKonkrete('POST', '/api/v1/contracts/details', [], [
                'project_id' => (int)$projectId
            ]);
            $responseResult = json_decode($response);

            if($responseResult->status) {
                return response([
                    'status' => true,
                    'message' => $responseResult->message,
                    'data' => $responseResult->data
                ], 200);

            } else {
                return response([
                    'status' => false,
                    'message' => $responseResult->message
                ], 200);
            }
        } else {
            return false;
        }
    }

    /**
     * Verify smart contract
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function verifyContract(Request $request)
    {
        $projectId = $request->project_id;

        if($projectId) {
            $response =  $this->konkreteClient->curlKonkrete('POST', '/api/v1/contracts/verify', [], [
                                'project_id' => (int)$projectId
                            ]);
            $responseResult = json_decode($response);

            if($responseResult->status) {
                return response([
                    'status' => true,
                    'message' => $responseResult->message,
                    'data' => $responseResult->data
                ], 200);

            } else {
                return response([
                    'status' => false,
                    'message' => $responseResult->message
                ], 200);
            }
        }
    }

    public function createWallet(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $response = $this->konkreteClient->curlKonkrete('POST','/api/v2/projects/createWallet',[],[
            'projectId' => (int)$request->project_id
        ]);
        $result = json_decode($response);
        if($result->status){
            $project->wallet_address = $result->data->address;
            $project->save();
            return response([
                'status' => true,
                'message' => $result->message
            ],200);
        } else {
            return false;
        }
    }

    /**
     * Get user token balance for given project
     *
     * @param walletAddress string
     * @param projectId int
     * @return \Illuminate\Http\Response
     */
    public function getUserTokenBalance($walletAddress, $projectId)
    {
        if($walletAddress && $projectId) {
            $response =  $this->konkreteClient->curlKonkrete('GET', '/api/v1/accounts/getBalance', [], [
                                'account' => $walletAddress,
                                'project_id' => (int)$projectId
                            ]);
            $responseResult = json_decode($response);

            if($responseResult->status) {
                return response([
                    'status' => true,
                    'message' => $responseResult->message,
                    'data' => $responseResult->data
                ], 200);

            } else {
                return response([
                    'status' => false,
                    'message' => $responseResult->message
                ], 200);
            }
        } else {
            return false;
        }
    }

    public function issueTokens(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $data = Transaction::where('project_id', $project->id)->select(['user_id','project_id','investment_investor_id','transaction_type','transaction_date','amount','rate','number_of_shares'])->get();
        IssueingToken::insert($data->toArray());
        return response([
            'status' => true,
            'message' => 'Process has been initiated to issue tokens to existing Investors!'
        ],200);
    }
}
