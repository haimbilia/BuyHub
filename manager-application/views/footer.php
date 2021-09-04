            <p class="version text-white text-center mt-5"><strong>
                    <?php if (CommonHelper::demoUrl()) {
                        $replacements = array(
                            '{YEAR}' => '&copy; ' . date("Y"),
                            '{PRODUCT}' => '<a target="_blank" href="https://yo-kart.com">Yo!Kart</a>',
                            '{OWNER}' => '<a target="_blank" href="https://www.fatbit.com/">FATbit Technologies</a>',
                        );
                        echo CommonHelper::replaceStringData(Labels::getLabel('LBL_COPYRIGHT_TEXT', $adminLangId), $replacements);
                    } else {
                        echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $adminLangId, FatUtility::VAR_STRING, 'Copyright &copy; ' . date('Y') . ' <a href="https://www.fatbit.com/">FATbit.com'); ?>
                    <?php
                    }
                    echo " " . CONF_WEB_APP_VERSION;
                    ?></strong></p>
            </div>
            </div>
            </div>
            </div>
            <?php echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE, false, true, false); ?>
            </body>

            </html>