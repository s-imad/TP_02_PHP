<?php if (!empty($errorMessage)) { ?>
    <div class="alert alert-danger col-md-6 mx-auto text-center">
        <?= $errorMessage ?>
    </div>
<?php } ?>

<?php if (!empty($successMessage)) { ?>
    <div class="alert alert-success col-md-6 mx-auto text-center">
        <?= $successMessage ?>
    </div>
<?php } ?>