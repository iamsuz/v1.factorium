{{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#repayModal">Open Modal</button> --}}
<div id="repayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Repay</h4>
      </div>
      <div class="modal-body">
        <p style="font-size: 20px;">You are about to repay <b><i>{{$project->title}}</i></b> for <b>{{$project->investment->total_projected_costs}}</b></p>
      </div>
      <div class="modal-footer">
        <form action=" {{route('dashboard.investment.declareRepurchase', [$project->id])}}" method="POST">
          {{csrf_field()}}
          <input class="hide" type="number" name="repurchase_rate" id="repurchase_rate" value="1" step="0.01">
          <input type="hidden" name="investors_list" id="repayInvestor">
          <input type="submit" class="btn btn-default" value="Repay">
        </form>
      </div>
    </div>

  </div>
</div>
