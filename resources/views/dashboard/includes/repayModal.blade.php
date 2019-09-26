{{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#repayModal">Open Modal</button> --}}
<div id="repayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Repay</h4>
      </div>
      <div class="modal-body">
        @if($balanceAudk) <h4 class="text-center">
          @if(isset(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id))
          @if($project->investment->total_projected_costs > $balanceAudk->balance)
          You dont have sufficient token to repay
          @endif
        @endif</h4>
        @endif
        <p style="font-size: 20px;" class="text-center">You are about to repay <b><i>{{$project->title}}</i></b> for <b>${{$project->investment->total_projected_costs}}</b></p>
      </div>
      <div class="modal-footer">
        @if($balanceAudk)
        <h4 class="text-center">
          @if(isset(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id))
          @if($project->investment->total_projected_costs > $balanceAudk->balance)
          <button class="btn btn-default notifyUser">Notify invoice issuer to buy more AUDC</button>
          @else
          <form action=" {{route('dashboard.investment.declareRepurchase', [$project->id])}}" method="POST">
            {{csrf_field()}}
            <input class="hide" type="number" name="repurchase_rate" id="repurchase_rate" value="1" step="0.01">
            <input type="hidden" name="investors_list" id="repayInvestor">
            <input type="submit" class="btn btn-default" value="Repay">
          </form>
          @endif
        @endif</h4>
        @endif
      </div>
    </div>

  </div>
</div>
