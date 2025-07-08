<form action="<?= AppUtil::url(['ctl' => 'account', 'act' => 'edit']) ?>" 
      method="post" class="needs-validation" novalidate>

    <div class="mb-3">
        <label class="form-label fw-semibold">Current Password</label>
        <input type="password" name="current_password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">New Password</label>
        <input type="password" name="new_password" class="form-control" required minlength="6">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control" required minlength="6">
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary rounded-pill px-3">Change Password</button>
        <a href="<?= AppUtil::url(['ctl' => 'account']) ?>" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
    </div>
</form>