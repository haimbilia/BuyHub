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

                                    Treeview </h3>

                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Components </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Extended </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Tree View </a>
                                </div>
                            </div>
                            <div class="subheader__toolbar">
                                <div class="subheader__wrapper">
                                    <a href="#" class="btn subheader__btn-secondary">
                                        Reports
                                    </a>

                                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title=""
                                        data-placement="top" data-original-title="Quick actions">
                                        <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Products
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                            <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                            <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New
                                                Download</a>
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
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-light alert-elevate fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                    <div class="alert-text">
                                        <div class="alert-text">jsTree is jquery plugin, that provides interactive
                                            trees.
                                            <br>
                                            For more info please visit the plugin's <a class="link font-bold"
                                                href="https://www.jstree.com/demo/" target="_blank">Demo Page</a> or
                                            <a class="link font-bold" href="https://github.com/vakata/jstree"
                                                target="_blank">Github Repo</a>.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Basic Tree
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tree_1" class="tree-demo jstree jstree-1 jstree-default" role="tree"
                                            aria-multiselectable="true" tabindex="0" aria-activedescendant="j1_1"
                                            aria-busy="false">
                                            <ul class="jstree-container-ul jstree-children" role="group">
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j1_1_anchor" aria-expanded="true" id="j1_1"
                                                    class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl"
                                                        role="presentation"></i><a class="jstree-anchor" href="#"
                                                        tabindex="-1" id="j1_1_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom"
                                                            role="presentation"></i>
                                                        Root node 1
                                                    </a>
                                                    <ul role="group" class="jstree-children">
                                                        <li role="treeitem"
                                                            data-jstree="{ &quot;selected&quot; : true }"
                                                            aria-selected="true" aria-level="2"
                                                            aria-labelledby="j1_2_anchor" id="j1_2"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor jstree-clicked" href="javascript:;"
                                                                tabindex="-1" id="j1_2_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                Initially selected </a></li>
                                                        <li role="treeitem"
                                                            data-jstree="{ &quot;icon&quot; : &quot;fa fa-briefcase font-success &quot; }"
                                                            aria-selected="false" aria-level="2"
                                                            aria-labelledby="j1_3_anchor" id="j1_3"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j1_3_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-briefcase font-success  jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                custom icon URL
                                                            </a></li>
                                                        <li role="treeitem" data-jstree="{ &quot;opened&quot; : true }"
                                                            aria-selected="false" aria-level="2"
                                                            aria-labelledby="j1_4_anchor" aria-expanded="true" id="j1_4"
                                                            class="jstree-node  jstree-open"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j1_4_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                initially open
                                                            </a>
                                                            <ul role="group" class="jstree-children">
                                                                <li role="treeitem"
                                                                    data-jstree="{ &quot;disabled&quot; : true }"
                                                                    aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j1_5_anchor" aria-disabled="true"
                                                                    id="j1_5" class="jstree-node  jstree-leaf"><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a
                                                                        class="jstree-anchor jstree-disabled" href="#"
                                                                        tabindex="-1" id="j1_5_anchor"><i
                                                                            class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom"
                                                                            role="presentation"></i>
                                                                        Disabled Node
                                                                    </a></li>
                                                                <li role="treeitem"
                                                                    data-jstree="{ &quot;type&quot; : &quot;file&quot; }"
                                                                    aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j1_6_anchor" id="j1_6"
                                                                    class="jstree-node  jstree-leaf jstree-last"><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a class="jstree-anchor"
                                                                        href="#" tabindex="-1" id="j1_6_anchor"><i
                                                                            class="jstree-icon jstree-themeicon fa fa-file jstree-themeicon-custom"
                                                                            role="presentation"></i>
                                                                        Another node
                                                                    </a></li>
                                                            </ul>
                                                        </li>
                                                        <li role="treeitem"
                                                            data-jstree="{ &quot;icon&quot; : &quot;fa fa-warning font-danger&quot; }"
                                                            aria-selected="false" aria-level="2"
                                                            aria-labelledby="j1_7_anchor" id="j1_7"
                                                            class="jstree-node  jstree-leaf jstree-last"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j1_7_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                Custom icon class (bootstrap)
                                                            </a></li>
                                                    </ul>
                                                </li>
                                                <li role="treeitem"
                                                    data-jstree="{ &quot;type&quot; : &quot;file&quot; }"
                                                    aria-selected="false" aria-level="1" aria-labelledby="j1_8_anchor"
                                                    id="j1_8" class="jstree-node  jstree-leaf jstree-last"><i
                                                        class="jstree-icon jstree-ocl" role="presentation"></i><a
                                                        class="jstree-anchor" href="#" tabindex="-1" id="j1_8_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-file jstree-themeicon-custom"
                                                            role="presentation"></i>
                                                        Clickanle link node </a></li>
                                            </ul>
                                        </div>
                                        <div class="alert alert-outline-primary margin-t-10">
                                            Note! Opened and selected nodes will be saved in the user's browser, so when
                                            returning to the same tree the previous state will be restored.
                                        </div>
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Custom Icons &amp; Clickable Nodes
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tree_2" class="tree-demo jstree jstree-2 jstree-default" role="tree"
                                            aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1"
                                            aria-busy="false">
                                            <ul class="jstree-container-ul jstree-children" role="group">
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j2_1_anchor" aria-expanded="true" id="j2_1"
                                                    class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl"
                                                        role="presentation"></i><a class="jstree-anchor" href="#"
                                                        tabindex="-1" id="j2_1_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                            role="presentation"></i>
                                                        Root node 1
                                                    </a>
                                                    <ul role="group" class="jstree-children">
                                                        <li role="treeitem"
                                                            data-jstree="{ &quot;selected&quot; : true }"
                                                            aria-selected="true" aria-level="2"
                                                            aria-labelledby="j2_2_anchor" id="j2_2"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-clicked"
                                                                href="javascript:;" tabindex="-1" id="j2_2_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                Initially selected </a></li>
                                                        <li role="treeitem"
                                                            data-jstree="{ &quot;icon&quot; : &quot;fa fa-briefcase font-success &quot; }"
                                                            aria-selected="false" aria-level="2"
                                                            aria-labelledby="j2_3_anchor" id="j2_3"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j2_3_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-briefcase font-success  jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                custom icon URL
                                                            </a></li>
                                                        <li role="treeitem" data-jstree="{ &quot;opened&quot; : true }"
                                                            aria-selected="false" aria-level="2"
                                                            aria-labelledby="j2_4_anchor" aria-expanded="true" id="j2_4"
                                                            class="jstree-node  jstree-open"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j2_4_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                initially open
                                                            </a>
                                                            <ul role="group" class="jstree-children">
                                                                <li role="treeitem"
                                                                    data-jstree="{ &quot;disabled&quot; : true }"
                                                                    aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j2_5_anchor" aria-disabled="true"
                                                                    id="j2_5" class="jstree-node  jstree-leaf"><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a
                                                                        class="jstree-anchor  jstree-disabled" href="#"
                                                                        tabindex="-1" id="j2_5_anchor"><i
                                                                            class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                                            role="presentation"></i>
                                                                        Disabled Node
                                                                    </a></li>
                                                                <li role="treeitem"
                                                                    data-jstree="{ &quot;type&quot; : &quot;file&quot; }"
                                                                    aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j2_6_anchor" id="j2_6"
                                                                    class="jstree-node  jstree-leaf jstree-last"><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a class="jstree-anchor"
                                                                        href="#" tabindex="-1" id="j2_6_anchor"><i
                                                                            class="jstree-icon jstree-themeicon fa fa-file  font-warning jstree-themeicon-custom"
                                                                            role="presentation"></i>
                                                                        Another node
                                                                    </a></li>
                                                            </ul>
                                                        </li>
                                                        <li role="treeitem"
                                                            data-jstree="{ &quot;icon&quot; : &quot;fa fa-warning font-danger&quot; }"
                                                            aria-selected="false" aria-level="2"
                                                            aria-labelledby="j2_7_anchor" id="j2_7"
                                                            class="jstree-node  jstree-leaf jstree-last"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j2_7_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>
                                                                Custom icon class (bootstrap)
                                                            </a></li>
                                                    </ul>
                                                </li>
                                                <li role="treeitem"
                                                    data-jstree="{ &quot;type&quot; : &quot;file&quot; }"
                                                    aria-selected="false" aria-level="1" aria-labelledby="j2_8_anchor"
                                                    id="j2_8" class="jstree-node  jstree-leaf jstree-last"><i
                                                        class="jstree-icon jstree-ocl" role="presentation"></i><a
                                                        class="jstree-anchor" href="http://www.jstree.com" tabindex="-1"
                                                        id="j2_8_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-file  font-warning jstree-themeicon-custom"
                                                            role="presentation"></i>
                                                        Clickanle link node </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Checkable Tree
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tree_3"
                                            class="tree-demo jstree jstree-3 jstree-default jstree-checkbox-selection"
                                            role="tree" aria-multiselectable="true" tabindex="0"
                                            aria-activedescendant="j3_1" aria-busy="false">
                                            <ul class="jstree-container-ul jstree-children jstree-wholerow-ul jstree-no-dots"
                                                role="group">
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j3_1_anchor" aria-expanded="true" id="j3_1"
                                                    class="jstree-node  jstree-open">
                                                    <div unselectable="on" role="presentation" class="jstree-wholerow">
                                                        &nbsp;</div><i class="jstree-icon jstree-ocl"
                                                        role="presentation"></i><a class="jstree-anchor" href="#"
                                                        tabindex="-1" id="j3_1_anchor"><i
                                                            class="jstree-icon jstree-checkbox jstree-undetermined"
                                                            role="presentation"></i><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                            role="presentation"></i>Same but with checkboxes</a>
                                                    <ul role="group" class="jstree-children">
                                                        <li role="treeitem" aria-selected="true" aria-level="2"
                                                            aria-labelledby="j3_2_anchor" id="j3_2"
                                                            class="jstree-node  jstree-leaf">
                                                            <div unselectable="on" role="presentation"
                                                                class="jstree-wholerow jstree-wholerow-clicked">&nbsp;
                                                            </div><i class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-clicked" href="#"
                                                                tabindex="-1" id="j3_2_anchor"><i
                                                                    class="jstree-icon jstree-checkbox"
                                                                    role="presentation"></i><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                                    role="presentation"></i>initially selected</a>
                                                        </li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j3_3_anchor" id="j3_3"
                                                            class="jstree-node  jstree-leaf">
                                                            <div unselectable="on" role="presentation"
                                                                class="jstree-wholerow">&nbsp;</div><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j3_3_anchor"><i
                                                                    class="jstree-icon jstree-checkbox"
                                                                    role="presentation"></i><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>custom icon</a>
                                                        </li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j3_4_anchor" aria-expanded="true" id="j3_4"
                                                            class="jstree-node  jstree-open">
                                                            <div unselectable="on" role="presentation"
                                                                class="jstree-wholerow">&nbsp;</div><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j3_4_anchor"><i
                                                                    class="jstree-icon jstree-checkbox"
                                                                    role="presentation"></i><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-default jstree-themeicon-custom"
                                                                    role="presentation"></i>initially open</a>
                                                            <ul role="group" class="jstree-children">
                                                                <li role="treeitem" aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j3_5_anchor" id="j3_5"
                                                                    class="jstree-node  jstree-leaf jstree-last">
                                                                    <div unselectable="on" role="presentation"
                                                                        class="jstree-wholerow">&nbsp;</div><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a class="jstree-anchor"
                                                                        href="#" tabindex="-1" id="j3_5_anchor"><i
                                                                            class="jstree-icon jstree-checkbox"
                                                                            role="presentation"></i><i
                                                                            class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                                            role="presentation"></i>Another node</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j3_6_anchor" id="j3_6"
                                                            class="jstree-node  jstree-leaf">
                                                            <div unselectable="on" role="presentation"
                                                                class="jstree-wholerow">&nbsp;</div><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j3_6_anchor"><i
                                                                    class="jstree-icon jstree-checkbox"
                                                                    role="presentation"></i><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-waring jstree-themeicon-custom"
                                                                    role="presentation"></i>custom icon</a>
                                                        </li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j3_7_anchor" aria-disabled="true" id="j3_7"
                                                            class="jstree-node  jstree-leaf jstree-last">
                                                            <div unselectable="on" role="presentation"
                                                                class="jstree-wholerow">&nbsp;</div><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-disabled" href="#"
                                                                tabindex="-1" id="j3_7_anchor"><i
                                                                    class="jstree-icon jstree-checkbox"
                                                                    role="presentation"></i><i
                                                                    class="jstree-icon jstree-themeicon fa fa-check font-success jstree-themeicon-custom"
                                                                    role="presentation"></i>disabled node</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j3_8_anchor" id="j3_8"
                                                    class="jstree-node  jstree-leaf jstree-last">
                                                    <div unselectable="on" role="presentation" class="jstree-wholerow">
                                                        &nbsp;</div><i class="jstree-icon jstree-ocl"
                                                        role="presentation"></i><a class="jstree-anchor" href="#"
                                                        tabindex="-1" id="j3_8_anchor"><i
                                                            class="jstree-icon jstree-checkbox"
                                                            role="presentation"></i><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-warning jstree-themeicon-custom"
                                                            role="presentation"></i>And wholerow selection</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end::card-->
                            </div>
                            <div class="col-lg-6">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Contextual Menu
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tree_4" class="tree-demo jstree jstree-4 jstree-default" role="tree"
                                            aria-multiselectable="true" tabindex="0" aria-activedescendant="j4_1"
                                            aria-busy="false">
                                            <ul class="jstree-container-ul jstree-children jstree-contextmenu"
                                                role="group">
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j4_1_anchor" aria-expanded="true" id="j4_1"
                                                    class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl"
                                                        role="presentation"></i><a class="jstree-anchor" href="#"
                                                        tabindex="-1" id="j4_1_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-brand jstree-themeicon-custom"
                                                            role="presentation"></i>Parent Node</a>
                                                    <ul role="group" class="jstree-children">
                                                        <li role="treeitem" aria-selected="true" aria-level="2"
                                                            aria-labelledby="j4_2_anchor" id="j4_2"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-clicked" href="#"
                                                                tabindex="-1" id="j4_2_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-brand jstree-themeicon-custom"
                                                                    role="presentation"></i>Initially selected</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j4_3_anchor" id="j4_3"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j4_3_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>Custom Icon</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j4_4_anchor" aria-expanded="true" id="j4_4"
                                                            class="jstree-node  jstree-open"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j4_4_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-success jstree-themeicon-custom"
                                                                    role="presentation"></i>Initially open</a>
                                                            <ul role="group" class="jstree-children">
                                                                <li role="treeitem" aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j4_5_anchor" id="j4_5"
                                                                    class="jstree-node  jstree-leaf jstree-last"><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a class="jstree-anchor"
                                                                        href="#" tabindex="-1" id="j4_5_anchor"><i
                                                                            class="jstree-icon jstree-themeicon fa fa-file font-waring jstree-themeicon-custom"
                                                                            role="presentation"></i>Another node</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j4_6_anchor" id="j4_6"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j4_6_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-waring jstree-themeicon-custom"
                                                                    role="presentation"></i>Another Custom Icon</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j4_7_anchor" aria-disabled="true" id="j4_7"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-disabled" href="#"
                                                                tabindex="-1" id="j4_7_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-check font-success jstree-themeicon-custom"
                                                                    role="presentation"></i>Disabled Node</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j4_8_anchor" aria-expanded="false"
                                                            id="j4_8" class="jstree-node  jstree-closed jstree-last"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j4_8_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>Sub Nodes</a></li>
                                                    </ul>
                                                </li>
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j4_14_anchor" id="j4_14"
                                                    class="jstree-node  jstree-leaf jstree-last"><i
                                                        class="jstree-icon jstree-ocl" role="presentation"></i><a
                                                        class="jstree-anchor" href="#" tabindex="-1"
                                                        id="j4_14_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-brand jstree-themeicon-custom"
                                                            role="presentation"></i>Another Node</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Drag &amp; Drop
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tree_5" class="tree-demo jstree jstree-5 jstree-default" role="tree"
                                            aria-multiselectable="true" tabindex="0" aria-activedescendant="j5_1"
                                            aria-busy="false">
                                            <ul class="jstree-container-ul jstree-children" role="group">
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j5_1_anchor" aria-expanded="true" id="j5_1"
                                                    class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl"
                                                        role="presentation"></i><a class="jstree-anchor" href="#"
                                                        tabindex="-1" id="j5_1_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-success jstree-themeicon-custom"
                                                            role="presentation"></i>Parent Node</a>
                                                    <ul role="group" class="jstree-children">
                                                        <li role="treeitem" aria-selected="true" aria-level="2"
                                                            aria-labelledby="j5_2_anchor" id="j5_2"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-clicked" href="#"
                                                                tabindex="-1" id="j5_2_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-success jstree-themeicon-custom"
                                                                    role="presentation"></i>Initially selected</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j5_3_anchor" id="j5_3"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j5_3_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>Custom Icon</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j5_4_anchor" aria-expanded="true" id="j5_4"
                                                            class="jstree-node  jstree-open"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j5_4_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-success jstree-themeicon-custom"
                                                                    role="presentation"></i>Initially open</a>
                                                            <ul role="group" class="jstree-children">
                                                                <li role="treeitem" aria-selected="false" aria-level="3"
                                                                    aria-labelledby="j5_5_anchor" id="j5_5"
                                                                    class="jstree-node  jstree-leaf jstree-last"><i
                                                                        class="jstree-icon jstree-ocl"
                                                                        role="presentation"></i><a class="jstree-anchor"
                                                                        href="#" tabindex="-1" id="j5_5_anchor"><i
                                                                            class="jstree-icon jstree-themeicon fa fa-file font-waring jstree-themeicon-custom"
                                                                            role="presentation"></i>Another node</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j5_6_anchor" id="j5_6"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j5_6_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-warning font-waring jstree-themeicon-custom"
                                                                    role="presentation"></i>Another Custom Icon</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j5_7_anchor" aria-disabled="true" id="j5_7"
                                                            class="jstree-node  jstree-leaf"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a
                                                                class="jstree-anchor  jstree-disabled" href="#"
                                                                tabindex="-1" id="j5_7_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-check font-success jstree-themeicon-custom"
                                                                    role="presentation"></i>Disabled Node</a></li>
                                                        <li role="treeitem" aria-selected="false" aria-level="2"
                                                            aria-labelledby="j5_8_anchor" aria-expanded="false"
                                                            id="j5_8" class="jstree-node  jstree-closed jstree-last"><i
                                                                class="jstree-icon jstree-ocl"
                                                                role="presentation"></i><a class="jstree-anchor"
                                                                href="#" tabindex="-1" id="j5_8_anchor"><i
                                                                    class="jstree-icon jstree-themeicon fa fa-folder font-danger jstree-themeicon-custom"
                                                                    role="presentation"></i>Sub Nodes</a></li>
                                                    </ul>
                                                </li>
                                                <li role="treeitem" aria-selected="false" aria-level="1"
                                                    aria-labelledby="j5_14_anchor" id="j5_14"
                                                    class="jstree-node  jstree-leaf jstree-last"><i
                                                        class="jstree-icon jstree-ocl" role="presentation"></i><a
                                                        class="jstree-anchor" href="#" tabindex="-1"
                                                        id="j5_14_anchor"><i
                                                            class="jstree-icon jstree-themeicon fa fa-folder font-success jstree-themeicon-custom"
                                                            role="presentation"></i>Another Node</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end::card-->

                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Ajax Data
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tree_6" class="tree-demo jstree jstree-6 jstree-default" role="tree"
                                            aria-multiselectable="true" tabindex="0" aria-activedescendant="j6_loading"
                                            aria-busy="false">
                                            <ul class="jstree-container-ul jstree-children" role="group">
                                                <li id="j6_loading"
                                                    class="jstree-initial-node jstree-loading jstree-leaf jstree-last"
                                                    role="tree-item"><i class="jstree-icon jstree-ocl"></i><a
                                                        class="jstree-anchor" href="#"><i
                                                            class="jstree-icon jstree-themeicon-hidden"></i>Loading
                                                        ...</a></li>
                                            </ul>
                                        </div>
                                        <div class="alert alert-outline-primary margin-t-10">
                                            Note! The tree nodes are loaded from server side demo script via ajax.
                                        </div>
                                    </div>
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