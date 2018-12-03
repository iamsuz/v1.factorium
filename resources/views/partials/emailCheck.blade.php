<div class="modal fade" id="checkEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <i class="fa fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form>
      <div class="modal-body row mx-3">
        <div class="md-form col-md-10">
          <input type="email" id="defaultForm-email" class="form-control validate" required="required">
        </div>
        <div class="col-md-2">
          <input type="submit" name="submit" class="btn btn-default btn-block checkEmailRequest second_color_btn" style="border-radius: 0px;padding: 9px 12px;" value="Go">
        </div>
      </div>
      </form>
      {{-- <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-default checkEmailRequest">Go</button>
      </div> --}}
    </div>
  </div>
</div>

{{-- <div class="text-center">
  <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#checkEmail">Launch
    Modal Login Form</a>
</div> --}}
