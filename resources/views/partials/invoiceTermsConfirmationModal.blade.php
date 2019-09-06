{{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#repayModal">Open Modal</button> --}}
<div id="" class="modal fade invoiceConfirmationModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Repay</h4>
      </div>
      <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
        @include('dashboard.projects.invoiceTearmsCond')
      </div>
      <div class="modal-footer">
          <button class="btn btn-primary" id="confirmInvoiceBtn">Confirm</button>
      </div>
    </div>

  </div>
</div>
