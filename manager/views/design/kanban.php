<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>



<body class="">
    <div class="wrapper">
        <?php
        include 'includes/header.php';
        ?>
        <div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">
                <!-- begin CONTAINER-->
                <div class="container  grid__item grid__item--fluid mt-30">
                    <!-- begin:: Subheader -->
                    <div class="subheader grid__item" id="subheader">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Kanban Board</h3>
                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Kanban Board </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Kanban Board </a>
                            </div>
                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="javascript:;" class="btn subheader__btn-secondary add_card">
                                    + Add Card
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- end:: Subheader -->
                    <div class="kanban__wrapper">
                        <div class="card card_copy">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        To Do
                                    </h3>
                                </div>
                                <div class="card-head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md" x-placement="bottom-end" style="position: absolute; transform: translate3d(-227px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">

                                            <!--begin::Nav-->
                                            <ul class="nav nav--block">
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-edit"></i>
                                                        <span class="nav__link-text">Rename</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-trash"></i>
                                                        <span class="nav__link-text">Remove</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!--end::Nav-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list__items drag1">
                                <li class="list__item">
                                        <h3>A/B Testing</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3> Email Template</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>Adwords</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>DNS Changeover</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                </ul>
                                <div class="add_more_item mt-5 text-center"><a href="javascript:void(0);" class="link add__item" data-toggle="modal" data-target="#modal_1">+ Add new task</a></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        In Progress
                                    </h3>
                                </div>
                                <div class="card-head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md" x-placement="bottom-end" style="position: absolute; transform: translate3d(-227px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">

                                            <!--begin::Nav-->
                                            <ul class="nav nav--block">
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-edit"></i>
                                                        <span class="nav__link-text">Rename</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-trash"></i>
                                                        <span class="nav__link-text">Remove</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!--end::Nav-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list__items drag2">
                                <li class="list__item">
                                        <h3>A/B Testing</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3> Email Template</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>Adwords</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>DNS Changeover</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                </ul>
                                <div class="add_more_item mt-5 text-center"><a href="javascript:void(0);" class="link add__item" data-toggle="modal" data-target="#modal_1">+ Add new task</a></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        In Review
                                    </h3>
                                </div>
                                <div class="card-head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md" x-placement="bottom-end" style="position: absolute; transform: translate3d(-227px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">

                                            <!--begin::Nav-->
                                            <ul class="nav nav--block">
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-edit"></i>
                                                        <span class="nav__link-text">Rename</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-trash"></i>
                                                        <span class="nav__link-text">Remove</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!--end::Nav-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list__items drag3">
                                <li class="list__item">
                                        <h3>A/B Testing</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3> Email Template</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>Adwords</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>DNS Changeover</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                </ul>
                                <div class="add_more_item mt-5 text-center"><a href="javascript:void(0);" class="link add__item" data-toggle="modal" data-target="#modal_1">+ Add new task</a></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-head">
                                <div class="card-head-label">
                                    <h3 class="card-head-title">
                                        Done
                                    </h3>
                                </div>
                                <div class="card-head-toolbar">
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md" x-placement="bottom-end" style="position: absolute; transform: translate3d(-227px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">

                                            <!--begin::Nav-->
                                            <ul class="nav nav--block">
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-edit"></i>
                                                        <span class="nav__link-text">Rename</span>
                                                    </a>
                                                </li>
                                                <li class="nav__item">
                                                    <a href="#" class="nav__link">
                                                        <i class="nav__link-icon flaticon2-trash"></i>
                                                        <span class="nav__link-text">Remove</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!--end::Nav-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list__items drag4">
                                    <li class="list__item">
                                        <h3>A/B Testing</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3> Email Template</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>Adwords</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                    <li class="list__item">
                                        <h3>DNS Changeover</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, fugit beatae dignissimos......</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="new_item">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="taskTitle" placeholder="Task title" />
                                        </div>
                                        <div class="form-group">
                                            <label>Description </label>
                                            <textarea id="taskDesc" class="form-control" rows="8"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary add_item">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </div>

</body>

<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(function() {
        $(".drag1, .drag2, .drag3, .drag4").sortable({
            connectWith: ".list__items",
            stack: ".list__items ul"
        });
        $(".add_item").on("click", function() {
            newTask();
        });
        function newTask(e) {
            let itemTitle = $('input[name="taskTitle"]').val();
            let itemDesc = $('#taskDesc').val();
            $(".drag1").append("<li class='list__item'><h3>" +
                itemTitle + "</h3><p>" + itemDesc + "</p></li>");
            $('input[name="taskTitle"], #taskDesc').val("");
            $("#modal_1, .modal-backdrop").attr("style", "display:none");
        }
        $(".add_card").on("click", function() {
            $('.card_copy').clone().removeClass('card_copy').appendTo('.kanban__wrapper');
        });
    });
</script>

</html>