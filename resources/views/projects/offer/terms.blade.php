  <!-- Modal -->
  <div class="modal fade" id="myTermsModal" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
          @include('dashboard.projects.invoiceTearmsCond')
        </div>
        <div class="modal-footer" style="padding-right: 38px;">
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="terms_accepted_button">I have read the @if($project->project_prospectus_text) <abbr title="{{$project->project_prospectus_text}}"><span id="abbrev"></span></abbr>@else<span>Factoring Arrangement</span>@endif, take me to the application form</button>
        </div>
      </div>
      <script>
        $(document).ready(function () {
            var str1 = "{{$project->project_prospectus_text}}";
            var split_names = str1.trim().split(" ");
            if (split_names.length > 1) {
              var newResult = [];
              for(var i=0;i < split_names.length; i++){
                newResult.push(split_names[i].charAt(0));
              }
              $('#abbrev').html(newResult);
            }else{
            $('#abbrev').html(str1);
          }
        });
      </script>
    </div>
  </div>