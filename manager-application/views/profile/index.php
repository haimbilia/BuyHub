<main class="main">
    <div class="container">
        <div class="grid grid--desktop grid--ver grid--ver-desktop app">
            <!--Begin:: App Aside Mobile Toggle-->
            <button class="app__aside-close d-none" id="user_profile_aside_close">
                <i class="la la-close"></i>
            </button>
            <!--End:: App Aside Mobile Toggle-->

            <!--Begin:: App Aside-->
            <?php require_once CONF_THEME_PATH . 'profile/leftSideBar.php'; ?>
            <!--End:: App Aside-->
            <!--Begin:: App Content-->
            <div class="grid__item grid__item--fluid app__content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <!--begin::Card header-->
                            <div class="card-head">
                                <!--begin::Card title-->
                                <div class="card-head-label">
                                    <h3 class="card-head-title">Profile Details</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--begin::Card header-->
                            <!--begin::Content-->

                            <!--begin::Form-->
                            <form id="_form" class="form form-horizontal" novalidate="novalidate">
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Input group-->
                                    <div class="row form-group">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label label">Avatar</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-image-input="true" style="background-image: url(/yokart/demo2/assets/media/avatars/blank.png)">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url(/yokart/demo2/assets/media/avatars/150-26.jpg)">
                                                </div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Label-->
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-image-input-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                    <input type="hidden" name="avatar_remove">
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Cancel-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-image-input-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>


                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-image-input-action="remove" data-toggle="tooltip" title="" data-original-title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->
                                            <!--begin::Hint-->
                                            <div class="form-text">Allowed file types: png, jpg,
                                                jpeg.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!--begin::Label-->
                                                <label class="label required">Full Name</label>
                                                <input type="text" class="form-control " placeholder=" " value="">
                                                <!--end::Label-->
                                                <!--begin::Col-->

                                                <!--end::Col-->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!--begin::Label-->
                                                <label class="label">Company</label>
                                                <input type="text" class="form-control " placeholder=" " value="">
                                                <!--end::Label-->

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!--begin::Label-->
                                                <label class="label">Full Name</label>
                                                <input type="text" class="form-control " placeholder=" " value="">
                                                <!--end::Label-->
                                                <!--begin::Col-->

                                                <!--end::Col-->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!--begin::Label-->
                                                <label class="label">Full Name</label>
                                                <input type="text" class="form-control " placeholder=" " value="">
                                                <!--end::Label-->

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!--begin::Label-->
                                                <label class="label">Contact Phone</label>
                                                <input type="text" class="form-control " placeholder=" " value="">
                                                <!--end::Label-->
                                                <!--begin::Col-->

                                                <!--end::Col-->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!--begin::Label-->
                                                <label class="label">Company Site </label>
                                                <input type="text" class="form-control " placeholder=" " value="">
                                                <!--end::Label-->

                                            </div>
                                        </div>

                                    </div>                                                    
                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-foot">
                                    <div class="row">
                                        <div class="col"><button type="reset" class="btn btn-outline-brand">Cancel</button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-brand gb-btn gb-btn-primary ">Update</button>
                                        </div>
                                    </div>

                                </div>
                                <!--end::Actions-->
                                <input type="hidden">
                                <div></div>
                            </form>
                            <!--end::Form-->

                            <!--end::Content-->
                        </div>
                    </div>
                </div>
            </div>
            <!--End:: App Content-->
        </div>

    </div>
</main>