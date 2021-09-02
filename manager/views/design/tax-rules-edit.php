<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="../images/favicon.ico" />
</head>



<body class="subheader--transparent page--loading">
    <div class="wrapper">

        <?php
  include 'includes/header.php';
?>
        <div class="body" id="body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">
                <!-- begin:: Subheader -->
                <div id="subheader" class="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Tax Rules</h3>
                            <div class="subheader__breadcrumbs">
                                <a javascript:void(0) class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Tax Rules </a>
                            </div>

                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="container grid__item grid__item--fluid">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning font-info"></i></div>
                                <div class="alert-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but .</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Tax Rules</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <div class="card-head-actions">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-brand">
                                                <i class="la la-plus"></i> Add</a>
                                        </div>
                                    </div>
                                </div>
                                <form class="form">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <div class="section section--first">
                                                    <div class="section__body">
                                                        <div class="shape-bg-color-1 p-4 rounded">
                                                            <div class="form-group">
                                                                <label>Tax Group Name</label>
                                                                <input type="email" class="form-control" placeholder="Name">
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <label>Summary</label>
                                                                <textarea class="form-control" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="heading heading--md pt-4">Tax Rules</div>
                                                        
                                                        <div class="">
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="border rounded p-4  h-100">
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="">Name</label>
                                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="">Tax Rate(%) </label>
                                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="">Country</label>
                                                                        <input class="form-control" type="text" value="" id="example-text-input">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="border rounded p-4  h-100">
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="">States</label>
                                                                        <select class="form-control" tabindex="-98">
                                                                            <option>All States</option>
                                                                            <option>Specific States</option>
                                                                            <option>Excluding States</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="">Select States</label>
                                                                        <select class="form-control" tabindex="">
                                                                            <option>Auto Select</option>
                                                                            <option>Auto Select</option>
                                                                            <option>Auto Select</option>
                                                                            <option>Auto Select</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="checkbox">
                                                                            <input type="checkbox"> Combined Tax
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <table class="table table-bordered table-hover table-edited mt-4">
                                                            <thead>
                                                                <tr>
                                                                    <th width="70%">Name</th>
                                                                    <th width="30%">Tax Rate</th>
                                                                    

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td scope="row"><input type="text" class="input-edited"></td>
                                                                    <td><input type="text" class="input-edited"></td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <div class="row mb-5">
                                                            <div class="col-xl-12"><a href="javascript:;" class="btn btn-bold btn-label-brand"><i class="la la-plus"></i> Add more</a></div>
                                                        </div>
</div>



                                                        <!-- <table class="table table-bordered table-hover table-edited">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Tax Rate(%)</th>
                                                                    <th>Country</th>
                                                                    <th>States</th>
                                                                    <th>Select States</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td scope="row">CGST </td>
                                                                    <td class="selected-td">9</td>
                                                                    <td>US </td>
                                                                    <td>Specific States</td>
                                                                    <td>Alaska Georgia Idaho</td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row"><input type="text" class="input-edited"></td>
                                                                    <td class="selected-td"><input type="text" class="input-edited"></td>
                                                                    <td><input type="text" class="input-edited"></td>
                                                                    <td><select class="input-edited selectpicker">
                                                                            <option>All States</option>
                                                                            <option>Specific States</option>
                                                                            <option>Excluding States</option>
                                                                        </select></td>

                                                                    <td>



                                                                        <select multiple="" class="input-edited selectpicker">
                                                                            <option value="AL">Alabama</option>
                                                                            <option value="AK">Alaska</option>
                                                                            <option value="AZ">Arizona</option>
                                                                            <option value="AR">Arkansas</option>
                                                                            <option value="CA">California</option>
                                                                            <option value="CO">Colorado</option>
                                                                            <option value="CT">Connecticut</option>
                                                                            <option value="DE">Delaware</option>
                                                                            <option value="DC">District Of Columbia</option>
                                                                            <option value="FL">Florida</option>
                                                                            <option value="GA">Georgia</option>
                                                                            <option value="HI">Hawaii</option>
                                                                            <option value="ID">Idaho</option>
                                                                            <option value="IL">Illinois</option>
                                                                            <option value="IN">Indiana</option>
                                                                            <option value="IA">Iowa</option>
                                                                            <option value="KS">Kansas</option>
                                                                            <option value="KY">Kentucky</option>
                                                                            <option value="LA">Louisiana</option>
                                                                            <option value="ME">Maine</option>
                                                                            <option value="MD">Maryland</option>
                                                                            <option value="MA">Massachusetts</option>
                                                                            <option value="MI">Michigan</option>
                                                                            <option value="MN">Minnesota</option>
                                                                            <option value="MS">Mississippi</option>
                                                                            <option value="MO">Missouri</option>
                                                                            <option value="MT">Montana</option>
                                                                            <option value="NE">Nebraska</option>
                                                                            <option value="NV">Nevada</option>
                                                                            <option value="NH">New Hampshire</option>
                                                                            <option value="NJ">New Jersey</option>
                                                                            <option value="NM">New Mexico</option>
                                                                            <option value="NY">New York</option>
                                                                            <option value="NC">North Carolina</option>
                                                                            <option value="ND">North Dakota</option>
                                                                            <option value="OH">Ohio</option>
                                                                            <option value="OK">Oklahoma</option>
                                                                            <option value="OR">Oregon</option>
                                                                            <option value="PA">Pennsylvania</option>
                                                                            <option value="RI">Rhode Island</option>
                                                                            <option value="SC">South Carolina</option>
                                                                            <option value="SD">South Dakota</option>
                                                                            <option value="TN">Tennessee</option>
                                                                            <option value="TX">Texas</option>
                                                                            <option value="UT">Utah</option>
                                                                            <option value="VT">Vermont</option>
                                                                            <option value="VA">Virginia</option>
                                                                            <option value="WA">Washington</option>
                                                                            <option value="WV">West Virginia</option>
                                                                            <option value="WI">Wisconsin</option>
                                                                            <option value="WY">Wyoming</option>
                                                                        </select></td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                        <div class="row mb-5">
                                                            <div class="col-xl-12">
                                                                <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-label-brand">
                                                                    <i class="la la-plus"></i> Add Row</a>
                                                            </div>
                                                        </div>
                                                        <div class="border p-4">
                                                            <label class="checkbox checkbox--bold mb-0">
                                                                <input type="checkbox" checked>Combined Tax<span></span>
                                                            </label></div>
                                                        <div class="heading heading--md pt-4">Tax Details</div>
                                                        <table class="table table-bordered table-hover table-edited">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Tax Rate</th>
                                                                    <th>Apply On</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td scope="row"><input type="text" class="input-edited"></td>
                                                                    <td><input type="text" class="input-edited"></td>
                                                                    <td class="selected-td"><select class="input-edited"></select></td>
                                                                </tr>
                                                            </tbody>
                                                        </table> -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="card__foot">
                                        <div class="form__actions text-center">
                                            <button type="reset" class="btn btn-success">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>

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
        <script src="../js/vendors/bootstrap-select.min.js"></script>

    </div>

</body>


</html>