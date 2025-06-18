<form action="<?= AppUtil::url(['ctl' => 'account', 'act' => 'edit']) ?>" 
      method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    
    <div class="text-center mb-4">
        <img src="/media/uploads/users/<?= htmlspecialchars($_SESSION['user']['avatar_url'] ?: 'default.png') ?>" 
             class="rounded-circle shadow" width="120" height="120" alt="Avatar">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Change Avatar</label>
        <input type="file" name="avatar" class="form-control">
    </div>

    <div class="row g-3 mb-3">
        <div class="col">
            <label class="form-label fw-semibold">First Name</label>
            <input type="text" name="firstname" class="form-control" 
                   value="<?= htmlspecialchars($_SESSION['user']['firstname']) ?>">
        </div>
        <div class="col">
            <label class="form-label fw-semibold">Last Name</label>
            <input type="text" name="lastname" class="form-control" 
                   value="<?= htmlspecialchars($_SESSION['user']['lastname']) ?>">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Username</label>
        <input type="text" name="username" class="form-control" 
               value="<?= htmlspecialchars($_SESSION['user']['username']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" 
               value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Display Name</label>
        <input type="text" name="display_name" class="form-control" 
               value="<?= htmlspecialchars($_SESSION['user']['display_name']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Bio</label>
        <textarea name="bio" rows="3" class="form-control"><?= htmlspecialchars($_SESSION['user']['bio']) ?></textarea>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary rounded-pill px-3">Save Changes</button>
        <a href="<?= AppUtil::url(['ctl' => 'account']) ?>" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
    </div>
</form>