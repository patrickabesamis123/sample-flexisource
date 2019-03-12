<script type="text/ng-template" id="inviteManager">

<div class="" id="InviteTeamMember" >
   
      <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalLabel">Invite Team Admin</h4>
      </div>

       
      <div class="modal-body">

       
       
        <div ng-repeat="errors in InvitedErrors" class="alert alert-danger" role="alert">
            @{{errors.email}}
        </div>
   

       <ul class="addMember">
       
        <li ng-repeat="data in InvitedMembers">
            @{{data.first_name}} ( @{{data.email}} )
        </li>
        </ul>
        <form   id="InviteMemberForm" name="InviteMemberForm" >
            <fieldset>
             
            <p>If you have additional team members that will be managing the recruiting process, you may add them here.</p>
                
                <div class="field text nolabel">
                    <input type="text" name="first_name" class="text nolabel" id="Form_first_name" required="required"   ng-model="user.first_name" placeholder="First Name">
                </div>
                <div id="Form_last_name_Holder" class="field text nolabel">
                    <input type="text" name="last_name" class="text nolabel" id="Form_last_name" required="required" ng-model="user.last_name" placeholder="Last Name">
                </div>
                 
                <div class="field email text nolabel">
                    <input type="email" name="email" class="email text nolabel" id="Form_email" required="required"  ng-model="user.email" placeholder="Email">
                </div>
                 
                
                <div class="field text nolabel">
                    <input type="hidden" name="account_type" ng-model="user.account_type" value="6">
                     
                </div>
                <div class="clearfix"><!-- --></div>

            </fieldset>

                                        
        <div class="Actions">
         <hr class="divider" style="margin-bottom: 15px">
            <div class="inline-button step3buttons">
                 
                <input type="submit" name="action_doNothing" value="Invite Team Admin" class="action submitbluegreen right pull-right" id="Form_action_doNothing" ng-click="ok()" >
                <div class="clearfix"> </div>
                <div ng-show="submitting" class="text-center"><img src="images/preloader.gif" width="45"  ><br> </div>
            </div>
             
        </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" class="btn btn-primary" ng-click="cancel()">Cancel</button>
      </div>
      
     
</div>
</script>