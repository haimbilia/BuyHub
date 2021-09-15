<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>

    <body class="fb-body">
        <div class="app">
            <?php include 'includes/sidebar.php';  ?>
            <div class="wrap">
                <?php include 'includes/new-header.php';  ?>
                <main class="main">
                    <div class="container">
                        <div class="card card--notification">
                            <div class="card-head">

                                <div class="d-flex justify-content-between flex-grow-1">
                                    <ul class="notification-action">
                                        <li>
                                            <label class="checkbox">
                                                <input type="checkbox">
                                                <span></span>
                                            </label>
                                        </li>
                                        <li>
                                            <a class="btn" href="" title="Remove">
                                                <svg class="icon" width="20" height="20">
                                                    <use
                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-delete">
                                                    </use>
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn" href="" title="Refresh">
                                                <svg class="icon" width="18" height="18">
                                                    <use
                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-refresh">
                                                    </use>
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn" href="" title="Message read">
                                                <svg class="icon" width="18" height="18">
                                                    <use
                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-message">
                                                    </use>
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn" href="" title="Message unread">
                                                <svg class="icon" width="18" height="18">
                                                    <use
                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-message-unread">
                                                    </use>
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                    <form class="form form--notification-search">
                                        <input type="search" placeholder="Search Notification...">
                                    </form>


                                    <div class="notification-filter">
                                        <label class="notification-filter__label">Sort By</label>
                                        <div class="notification-filter__sortby">
                                            <select class="form-control">
                                                <option>All</option>
                                                <option>Read</option>
                                                <option>Unread</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="card-body">
                                <div class="notifications">
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #F45442;" data-title="N"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #56a0f8;" data-title="T"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #e83e8c;" data-title="A"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #ffc107;" data-title="S"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #F45442;" data-title="N"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #56a0f8;" data-title="T"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #e83e8c;" data-title="A"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                    <div class="notifications__item">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        <div class="avatar avatar--small" style="color: #ffc107;" data-title="S"></div>
                                        <div class="notifications__summary">
                                            <h6>Invitaton of SnapDeal </h6>
                                            Nathan Sent you a Invitation. Ready to be accepted?
                                        </div>
                                        <date class="date small">Jun 15, 2020 3:17 PM</date>
                                    </div>
                                    <!--item-->
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="notification-list-count">Showing 1 to 10 of 135 entries</div>
                                    <div class="pagination">
                                        <li class="prev"><a href="#"><span></span></a></li>
                                        <li><a href="#" class="is-active">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                        <li class="next"><a href="#"></a></li>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </main>
                <?php include 'includes/footer.php';  ?>
            </div>
        </div>
    </body>

</html>