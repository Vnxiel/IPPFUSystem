<div class="modal fade" id="changePassword-LoginModal" tabindex="-1" aria-labelledby="changePassword-LoginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="changePassModalLabel">Change User Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="changePasswordForm">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label fw-bolder">Username:</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
          </div>
          <div class="mb-3">
            <label for="otp" class="form-label fw-bolder">OTP Code:</label>
            <div class="input-group">
              <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP code" required>
              <button type="button" class="btn btn-outline-secondary" id="getOtpBtn">Get OTP</button>
            </div>
          </div>
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
