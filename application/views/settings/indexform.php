                            <div id="images" class="tab-pane fade">
                                <form action="<?= base_url('generalSettings/storeImages') ?>"
                                    method="post" enctype="multipart/form-data">

                                    <input type="hidden" name="id" value="<?= $setting->id ?? '' ?>">

                                    <div class="row">
                                        <!-- Logo -->
                                        <div class="col-md-4">
                                            <label>Logo Image</label>
                                            <input type="file" class="form-control" name="logo_image" accept="image/*">

                                            <?php if (!empty($setting->logo_image)): ?>
                                                <img src="<?= base_url($setting->logo_image) ?>"
                                                    class="img-thumbnail mt-2" style="height:120px;">
                                            <?php endif; ?>
                                        </div>

                                        <!-- Login Background -->
                                        <div class="col-md-4">
                                            <label>Login Background</label>
                                            <input type="file" class="form-control" name="login_background" accept="image/*">

                                            <?php if (!empty($setting->login_background)): ?>
                                                <img src="<?= base_url($setting->login_background) ?>"
                                                    class="img-thumbnail mt-2" style="height:120px;">
                                            <?php endif; ?>
                                        </div>

                                        <!-- Site Background -->
                                        <div class="col-md-4">
                                            <label>Site Background</label>
                                            <input type="file" class="form-control" name="site_background" accept="image/*">

                                            <?php if (!empty($setting->site_background)): ?>
                                                <img src="<?= base_url($setting->site_background) ?>"
                                                    class="img-thumbnail mt-2" style="height:120px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <button class="btn btn-success mt-3 btn-block">
                                        Save Images
                                    </button>
                                </form>
                            </div>