<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />

</head>



<body class="">
    <div class="wrapper">
        <?php
  include 'includes/header.php';
?>
        <div class="body " id="body">
            <div class="content " id="content">

                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">

                                Form Controls </h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Forms &amp; Controls </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Form Validation </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Form Controls </a>
                            </div>
                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="#" class="btn subheader__btn-secondary">
                                    Reports
                                </a>

                                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="top" data-original-title="Quick actions">
                                    <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                        <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                        <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="container">
                    <!--begin::card-->
                    <div class="row">
                        <div class="col-lg-6">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Default Validation 1
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form form--label-right" id="form_1" novalidate="novalidate">
                                    <div class="card-body">
                                        <div class="form-group form-group-last hide">
                                            <div class="alert alert-danger" role="alert" id="form_1_msg">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    Oh snap! Change a few things up and try submitting again.
                                                </div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Email *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" name="email" placeholder="Enter your email" aria-describedby="email-error">
                                                <div id="email-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">URL *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="url" placeholder="Enter your url" aria-describedby="url-error">
                                                    <div class="input-group-append"><span class="input-group-text">.via.com</span></div>
                                                </div>
                                                <div id="url-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please enter your website URL.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Digits</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <div class="input-icon input-icon--left">
                                                        <input type="text" class="form-control" name="digits" placeholder="Enter digits" aria-describedby="digits-error">
                                                        <span class="input-icon__icon input-icon__icon--left"><span><i class="la la-calculator"></i></span></span>
                                                    </div>
                                                </div>
                                                <div id="digits-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please enter only digits</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Credit Card</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="creditcard" placeholder="Enter card number" aria-describedby="creditcard-error">
                                                    <div class="input-group-append"><span class="input-group-text"><i class="la la-credit-card"></i></span></div>
                                                </div>
                                                <div id="creditcard-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please enter your credit card number</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">US Phone</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="phone" placeholder="Enter phone" aria-describedby="phone-error">
                                                    <div class="input-group-append"><span class="btn btn-brand btn-icon"><i class="la la-phone"></i></span></div>
                                                </div>
                                                <div id="phone-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please enter your US phone number</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Option *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub validate is-invalid">
                                                <select class="form-control" name="option" aria-describedby="option-error">
                                                    <option value="">Select</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                                <div id="option-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please select an option.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Options *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub validate is-invalid">
                                                <select class="form-control" name="options" multiple="" size="5" aria-describedby="options-error">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                                <div id="options-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please select at least one or maximum 4 options</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Memo *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <textarea class="form-control" name="memo" placeholder="Enter a menu" rows="8" aria-describedby="memo-error"></textarea>
                                                <div id="memo-error" class="error invalid-feedback">This field is required.</div>
                                                <span class="form-text text-muted">Please enter a menu within text length range 10 and 100.</span>
                                            </div>
                                        </div>

                                        <div class="separator separator--border-dashed separator--space-xl"></div>

                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Checkbox *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkbox" aria-describedby="checkbox-error">
                                                        <div id="checkbox-error" class="error invalid-feedback">This field is required.</div> Tick me
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="form-text text-muted">Please tick the checkbox</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Checkboxes *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="checkbox-list">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkboxes" aria-describedby="checkboxes-error">
                                                        <div id="checkboxes-error" class="error invalid-feedback">This field is required.</div> Option 1
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkboxes"> Option 2
                                                        <span></span>
                                                    </label>
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="checkboxes"> Option 3
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="form-text text-muted">Please select at lease 1 and maximum 2 options</span>
                                            </div>
                                        </div>
                                        <div class="form-group row validate is-invalid">
                                            <label class="col-form-label col-lg-3 col-sm-12">Radios *</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="checkbox" name="radio" aria-describedby="radio-error">
                                                        <div id="radio-error" class="error invalid-feedback">This field is required.</div> Option 1
                                                        <span></span>
                                                    </label>
                                                    <label class="radio">
                                                        <input type="checkbox" name="radio"> Option 2
                                                        <span></span>
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="radio"> Option 3
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <span class="form-text text-muted">Please select an option</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <div class="row">
                                                <div class="col-lg-9 ml-lg-auto">
                                                    <button type="submit" class="btn btn-brand">Validate</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::card-->
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">
                                            Advanced Validation
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="form form--label-right" id="form_2" novalidate="novalidate">
                                    <div class="card-body">
                                        <div class="section">
                                            <h3 class="section__title">
                                                Billing Information:
                                            </h3>
                                            <div class="section__content">
                                                <div class="form-group row validate is-invalid">
                                                    <div class="col-lg-12">
                                                        <label class="form-control-label">* Cardholder Name:</label>
                                                        <input type="text" name="billing_card_name" class="form-control is-invalid" placeholder="" value="" aria-describedby="billing_card_name-error">
                                                        <div id="billing_card_name-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group row validate is-invalid">
                                                    <div class="col-lg-12">
                                                        <label class="form-control-label">* Card Number:</label>
                                                        <input type="text" name="billing_card_number" class="form-control is-invalid" placeholder="" value="" aria-describedby="billing_card_number-error">
                                                        <div id="billing_card_number-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-last row">
                                                    <div class="col-lg-4 form-group-sub validate is-invalid">
                                                        <label class="form-control-label">* Exp Month:</label>
                                                        <select class="form-control is-invalid" name="billing_card_exp_month" aria-describedby="billing_card_exp_month-error">
                                                            <option value="">Select</option>
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>
                                                            <option value="07">07</option>
                                                            <option value="08">08</option>
                                                            <option value="09">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>
                                                        <div id="billing_card_exp_month-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                    <div class="col-lg-4 form-group-sub validate is-invalid">
                                                        <label class="form-control-label">* Exp Year:</label>
                                                        <select class="form-control is-invalid" name="billing_card_exp_year" aria-describedby="billing_card_exp_year-error">
                                                            <option value="">Select</option>
                                                            <option value="2018">2018</option>
                                                            <option value="2019">2019</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                        </select>
                                                        <div id="billing_card_exp_year-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                    <div class="col-lg-4 form-group-sub validate is-invalid">
                                                        <label class="form-control-label">* CVV:</label>
                                                        <input type="number" class="form-control is-invalid" name="billing_card_cvv" placeholder="" value="" aria-describedby="billing_card_cvv-error">
                                                        <div id="billing_card_cvv-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="separator separator--border-dashed separator--space-xl"></div>

                                        <div class="section">
                                            <h3 class="section__title">
                                                Billing Address
                                                <i data-toggle="tooltip" data-width="auto" class="section__help" title="" data-original-title="If different than the corresponding address"></i>
                                            </h3>
                                            <div class="section__content">
                                                <div class="form-group row validate is-invalid">
                                                    <div class="col-lg-12">
                                                        <label class="form-control-label">* Address 1:</label>
                                                        <input type="text" name="billing_address_1" class="form-control is-invalid" placeholder="" value="" aria-describedby="billing_address_1-error">
                                                        <div id="billing_address_1-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <label class="form-control-label">Address 2:</label>
                                                        <input type="text" name="billing_address_2" class="form-control" placeholder="" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-last row">
                                                    <div class="col-lg-5 form-group-sub validate is-invalid">
                                                        <label class="form-control-label">* City:</label>
                                                        <input type="text" class="form-control is-invalid" name="billing_city" placeholder="" value="" aria-describedby="billing_city-error">
                                                        <div id="billing_city-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                    <div class="col-lg-5 form-group-sub validate is-invalid">
                                                        <label class="form-control-label">* State:</label>
                                                        <input type="text" class="form-control is-invalid" name="billing_state" placeholder="" value="" aria-describedby="billing_state-error">
                                                        <div id="billing_state-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                    <div class="col-lg-2 form-group-sub validate is-invalid">
                                                        <label class="form-control-label">* ZIP:</label>
                                                        <input type="text" class="form-control is-invalid" name="billing_zip" placeholder="" value="" aria-describedby="billing_zip-error">
                                                        <div id="billing_zip-error" class="error invalid-feedback">This field is required.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="separator separator--border-dashed separator--space-xl"></div>

                                        <div class="section">
                                            <h3 class="section__title margin-b-20">
                                                Delivery Type:
                                            </h3>
                                            <div class="section__content">
                                                <div class="form-group form-group-last validate is-invalid">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label class="option">
                                                                <span class="option__control">
                                                                    <span class="radio radio--state-brand">
                                                                        <input type="radio" name="billing_delivery" value="" class="is-invalid" aria-describedby="billing_delivery-error">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                                <span class="option__label">
                                                                    <span class="option__head">
                                                                        <span class="option__title">
                                                                            Standart Delevery
                                                                        </span>
                                                                        <span class="option__focus">
                                                                            Free
                                                                        </span>
                                                                    </span>
                                                                    <span class="option__body">
                                                                        Estimated 14-20 Day Shipping
                                                                        (&nbsp;Duties end taxes may be due
                                                                        upon delivery&nbsp;)
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="option">
                                                                <span class="option__control">
                                                                    <span class="radio radio--state-brand">
                                                                        <input type="radio" name="billing_delivery" value="">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                                <span class="option__label">
                                                                    <span class="option__head">
                                                                        <span class="option__title">
                                                                            Fast Delevery
                                                                        </span>
                                                                        <span class="option__focus">
                                                                            $&nbsp;8.00
                                                                        </span>
                                                                    </span>
                                                                    <span class="option__body">
                                                                        Estimated 2-5 Day Shipping
                                                                        (&nbsp;Duties end taxes may be due
                                                                        upon delivery&nbsp;)
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div id="billing_delivery-error" class="error invalid-feedback">This field is required.</div>
                                                    <div class="form-text text-muted">
                                                        <!--must use this helper element to display error message for the options-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="form__actions">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-brand">Validate</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::card-->
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>

        <?php
  include 'includes/footer.php';
?>
    </div>

</body>


</html>