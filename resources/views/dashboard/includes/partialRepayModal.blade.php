{{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#repayModal">Open Modal</button> --}}
<div id="partialRepayModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Repay</h4>
      </div>
      <div class="modal-body">
        <p style="font-size: 20px;">You are about to partial repay <b><i>{{$project->title}}</i></b> for <b>${{$project->investment->total_projected_costs}}</b></p>
      </div>
      <div class="modal-footer">
        <form action=" {{route('dashboard.investment.declareFixedDividend', [$project->id])}}" method="POST">
          {{csrf_field()}}
              <span class="declare-fixed-statement "><small><input type="number" name="fixed_dividend_percent" id="fixedDividendPercent" step="0.01" min="1" max="100" required> % </small></span>
              <input type="hidden" class="investors-list" id="partialInvestor_list" name="investors_list">
          <input type="submit" class="btn btn-default" value="Repay">
        </form>
      </div>
    </div>

  </div>
</div>
