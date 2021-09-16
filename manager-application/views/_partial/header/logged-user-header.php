<div class="app">
    <?php $this->includeTemplate('_partial/header/left-navigation.php') ?>
    <div class="wrap">
        <header class="main-header">
            <div class="container-fluid">
                <div class="main-header-inner">
                    <div class="page-title">
                        <h1>
                            <?php
                            if (array_key_exists('pageTitle', $this->variables)) {
                                echo $this->variables['pageTitle'];
                            } else {
                                echo Labels::getLabel('LBL_Dashboard', $adminLangId);
                            } ?>
                        </h1>
                        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                    </div>
                    <div class="main-header-toolbar">
                        <ul class="accounts-nav">
                            <li>
                                <a data-toggle="modal" data-target="#search-main" href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24" />
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" id="Path-2" fill="#000000" fill-rule="nonzero" />
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" id="Path" fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>

                                </a>
                                <div class="modal fade" id="search-main">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form method="get" class="form">
                                                    <input type="search" class="form-control" placeholder="Go to...">

                                                    <ul class="search-results">
                                                        <li class="search-results_item">
                                                            <h6 class="title">Products</h6>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>

                                                                <div class="">
                                                                    <a href="javascript:;" class="text-hover-primary">
                                                                        <div>Br<strong class="highlight">a</strong>nds
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="search-results_item">
                                                            <h6 class="title">Products</h6>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>

                                                                <div class="">
                                                                    <a href="javascript:;" class="text-hover-primary">
                                                                        <div>Br<strong class="highlight">a</strong>nds
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="search-results_item">
                                                            <h6 class="title">Products</h6>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>

                                                                <div class="">
                                                                    <a href="javascript:;" class="text-hover-primary">
                                                                        <div>Br<strong class="highlight">a</strong>nds
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="search-results_item">
                                                            <h6 class="title">Products</h6>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>
                                                                <div class="search-results_links">
                                                                    <a href="javascript:;">
                                                                        Br<strong class="highlight">a</strong>nds

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="search-results_data">
                                                                <i class="search-results_icn">
                                                                    <svg class="svg" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg" class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--external-svg SVG--color-svg SVG--color--gray200-svg" style="width: 12px; height: 12px;">
                                                                        <path d="M2 4v10h10v-3a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2zm5.707 5.707a1 1 0 1 1-1.414-1.414l6.3-6.298H9.017a.998.998 0 1 1 0-1.995h5.986A.995.995 0 0 1 16 .998v5.986a.998.998 0 1 1-1.995 0V3.406z" fill-rule="evenodd"></path>
                                                                    </svg>
                                                                </i>

                                                                <div class="">
                                                                    <a href="javascript:;" class="text-hover-primary">
                                                                        <div>Br<strong class="highlight">a</strong>nds
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>



                                                    </ul>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="search-native">

                                                    <p>
                                                        <label class="" for="">
                                                            Press <kbd>Ctrl-F</kbd> again to use native browser
                                                            search. <input type="checkbox">

                                                        </label>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                            <rect id="Rectangle-7" fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                            <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle no-after" data-toggle="dropdown" href="">
                                    <img class="accounts-nav_avatar" aria-expanded="false" src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_4.jpg" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-anim">
                                    <ul class="nav nav-block">
                                        <li class="nav__item">
                                            <a class="dropdown-item nav__link" href="#">
                                                Hi, Michael Williams </a>
                                        </li>
                                        <li class="nav__item "><a class="dropdown-item nav__link" data-org-url="#" href="#">Dashboard</a></li>
                                        <li class="nav__item logout"><a class="dropdown-item nav__link" data-org-url="#" href="#">Logout </a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>
        </header>
        <!-- <main class="main"> -->