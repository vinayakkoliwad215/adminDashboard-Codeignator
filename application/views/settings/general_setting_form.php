<?php $s = $setting ?? null; ?>

<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" name="name" value="<?= $s->name ?? '' ?>" required>
</div>

<div class="form-group">
    <label>Code</label>
    <input type="text" class="form-control" name="code" value="<?= $s->code ?? '' ?>" required>
</div>
<!-- Checkbox for Prefix -->
<div class="form-check mb-3">
    <input type="checkbox" class="form-check-input" id="prefixchecked"
        name="prefixchecked" value="1"
        <?= isset($s) && $s->prefixchecked == 1 ? 'checked' : '' ?>>
    <label class="form-check-label" for="prefixchecked">Enable Prefix</label>
</div>


<div class="form-group">
    <label>Mobile Number</label>
    <input type="text" class="form-control" name="mobilenumber" value="<?= $s->mobilenumber ?? '' ?>" required>
</div>

<div class="form-group">
    <label>Address</label>
    <textarea class="form-control" name="address"><?= $s->address ?? '' ?></textarea>
</div>

<div class="form-group">
    <label>City</label>
    <input type="text" class="form-control" name="city" value="<?= $s->city ?? '' ?>" required>
</div>

<div class="form-group">
    <label>Currency</label>
    <input type="text" class="form-control" name="currency" value="<?= $s->currency ?? '' ?>">
</div>
