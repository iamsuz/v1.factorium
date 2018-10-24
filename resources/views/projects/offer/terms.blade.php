  <!-- Modal -->
  <div class="modal fade" id="myTermsModal" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          @if($project->investment){!! $project->investment->PDS_part_1_link !!}@endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="terms_accepted_button">I have read the prospectus, take me to the application form</button>
        </div>
      </div>

    </div>
  </div>
