<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body">
    <section class="bg-second pt-3 pb-3">
        <div class="container">
            <div class="section-head section--white--head justify-content-center mb-0">
                <div class="section__heading">
                    <h1 class="mb-0"><?php echo Labels::getLabel('Lbl_All_Shops', $siteLangId); ?>
                    </h1>
                </div>
            </div>
        </div>
    </section>
    <?php if($geoLocation) { ?>
    <section class="section"> 
        <div class="container">
            <div class="interactive-stores">
                <div class="interactive-stores__map">                   
                        <div class="map-loader is-loading">                        
                            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                <path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                    <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"></animateTransform>
                                </path>
                            </svg>
                        </div>   
                        <div class="canvas-map" id="shopMap--js">
                        </div>
                    
                </div> 
            <div id="listing"> </div>              
            </div> 
        </div>
    </section>
    <?php }else{ ?> 
    <section class="section">
        <div class="container">
            <div id="listing"> </div>
            <div id="loadMoreBtnDiv"></div>
        </div>
    </section>
    <?php } ?>
</div>
<?php echo $searchForm->getFormHtml();?>
