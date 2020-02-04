<div id="redeemInvTokenModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin: o auto; top: 30%;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleApprDai">
          <i class="fa fa-lock lockLogo" aria-hidden="true" style="font-size: 45px;" ></i>
        </h4>
      </div>
      <div class="modal-body">
        <form class="form-group" id="redeemTokenForm" action="#">
          <div class="row text-center">
            <div class="alert alert-info hide" id="apprAlertModal"></div>
            <div class="col-md-6">
              <button id="apprDai" style="border-radius: 0;" class="btn btn-default btn-lg btn-block" id="getInvToken">Get INV Tokens</button>
            </div>
            <div class="col-md-6">
              <input type="number" name="invToken" class="form-control" placeholder="Balance" value="0.00" max="" min="0">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <input type="submit" id="redeemTokenBtn" class="btn btn-default btn-lg btn-block buy-now-btn" value="Redeem Tokens">
            </div>
          </div>
        </form>
        <div class="row text-center hide">
          <div class="col-md-6">
            Redeemed INV Tokens
          </div>
          <div class="col-md-6" id="redeemedInvToken">

          </div>
        </div>
      </div>
      <div class="row text-center hide">
          <div class="col-md-6">
            Dai Balance
          </div>
          <div class="col-md-6" id="daiBalance">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
