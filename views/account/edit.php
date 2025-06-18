<?php include_once "views/layouts/user/header.php"; ?>
<div class="container my-5" style="max-width: 800px;">
    <div class="card shadow rounded-4 border-0">
        <div class="card-body p-4">

            <h2 class="mb-4 fw-bold text-primary">Account Settings</h2>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Personal Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">Security</button>
                </li>
            </ul>

            <!-- Tab contents -->
            <div class="tab-content">

                <!-- Personal Info Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <?php include_once "views/account/_form_profile.php"; ?>
                </div>

                <!-- Security Tab -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <?php include_once "views/account/_form_security.php"; ?>
                </div>

            </div>

        </div>
    </div>
</div>

<?php include_once "views/layouts/user/footer.php"; ?>