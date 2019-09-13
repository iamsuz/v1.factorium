{{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#repayModal">Open Modal</button> --}}
<div class="modal fade" id="audcBankDetailsModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Bank Details</h4>
      </div>
      <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
        <section id="section-colors-left" class="color-panel-right panel-open-left center" style="position: static;">
        <div class="color-wrap-left" style="">
          <div class="row">
            <div class="col-md-12 text-center">
              <h2>
                @if($project->projectconfiguration->payment_switch)
                Thank you
                @else
                Thank you <br><div style="margin-top: 1.2rem;"> Please deposit ${{number_format($investor->pivot->amount)}} to</div>
                @endif
              </h2>
            </div>
          </div>
          <br>
          @if($project->investment)
          {{-- @if($project->investment->bank) --}}
          <div class="row">
            <div class="col-md-offset-2 col-md-8 text-justify">

              @if($project->projectconfiguration->payment_switch)
              @else

              <table class="table table-bordered">
                <tr><td>Bank</td><td>@if($project->investment->bank){!!$project->investment->bank!!}@else Westpac @endif</td></tr>
                <tr><td>Account Name</td><td>@if($project->investment->bank_account_name){!!$project->investment->bank_account_name!!}@else Konkrete Distributed Registries Ltd @endif</td></tr>
                <tr><td>BSB </td><td>@if($project->investment->bsb){!!$project->investment->bsb!!}@else 033002 @endif</td></tr>
                <tr><td>Account No</td><td>@if($project->investment->bank_account_number){!!$project->investment->bank_account_number!!}@else 968825 @endif</td></tr>
                <tr><td>SWIFT Code</td><td>@if($project->investment->swift_code){!!$project->investment->swift_code!!}@else WPACAU2S @endif</td></tr>
                <tr><td>Reference</td><td>INV{{ $investor->id }}</td></tr>
              </table>

              @if($project->investment->bitcoin_wallet_address)
              <h2 class="text-center" style="font-size: 1.4em; font-weight: 600; margin-bottom: 1.5rem;">Or pay using Bitcoin</h2>
              <table class="table table-bordered">
                <tr><td>Bitcoin wallet address</td><td>{!!$project->investment->bitcoin_wallet_address!!}</td></tr>
              </table>
              @endif

              @endif
            </div>
          </div>
          <br>
          {{-- @endif --}}
          @endif
        </div>
      </section>
      </div>
      <div class="modal-footer">
        {{-- <button class="btn btn-primary">Transferred</button> --}}
      </div>
    </div>

  </div>
</div>
