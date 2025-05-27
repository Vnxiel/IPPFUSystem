<div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="changePassModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="changePassModalLabel">Change User Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="systemAdmin/password/change-password" method="POST">
        @csrf
        <!-- Hidden user ID -->
        <input type="hidden" name="user_id" id="change-password-user-id" value="{{ $user->id }}">

        <div class="modal-body">
        <div class="mb-3">
          <label for="newPassword" class="form-label fw-bolder">New Password:</label>
          <div class="input-group">
            <input type="password" class="form-control" name="new_password" id="newPassword" placeholder="Enter new password" required minlength="6">
            <span class="input-group-text" style="cursor:pointer;">
              <i class="fa fa-eye toggle-password" data-target="#newPassword"></i>
            </span>
          </div>
        </div>

        <div class="mb-3">
          <label for="confirmPassword" class="form-label fw-bolder">Confirm Password:</label>
          <div class="input-group">
            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Confirm new password" required minlength="6">
            <span class="input-group-text" style="cursor:pointer;">
              <i class="fa fa-eye toggle-password" data-target="#confirmPassword"></i>
            </span>
          </div>
        </div>



        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Change Password</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>
