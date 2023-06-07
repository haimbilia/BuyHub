<?php if (!isset($defaultContent) || $defaultContent === false) { ?>

    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
        <td style="padding-top: 30px">
            <?php
            if (!isset($defaultContent) || $defaultContent === false) {
                echo FatApp::getConfig('CONF_EMAIL_TEMPLATE_FOOTER_HTML' . $langId, FatUtility::VAR_STRING, '');
            }
            ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 40px"></td>
    </tr>
    </tbody>
    </table>
    </body>

<?php  } else { ?>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
        <td style="padding-top: 30px">
            <table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed">
                <tr>
                    <td style="text-align: center">
                        <p style="
                                        font-family: 'Poppins', sans-serif;
                                        font-size: 14px;
                                        letter-spacing: -0.2px;
                                        display: block;
                                        box-sizing: border-box;
                                        font-weight: $font-weight-regular;
                                        color: #212529;
                                        line-height: 26px;
                                        margin: 0 0 20px 0;
                                    ">
                            Contact {website_name} at<br />
                            <a href="mailto:{CONTACT-EMAIL}" style="color: #f13925; text-decoration: none">
                                {CONTACT-EMAIL}
                            </a>
                            or call at
                            <a href="tel:{SITE-PHONE}" style="color: #f13925; text-decoration: none">
                                {SITE-PHONE}
                            </a>
                        </p>
                        <h5 style="font-size: 18px; font-weight: $font-weight-bold; text-transform: uppercase; letter-spacing: -0.2px; line-height: 24px; display: block; margin: 0 0 15px 0; color: #212529">
                            Get In Touch
                        </h5>
                        {social_media_icons}
                        <span style="display: block; width: 100%; font-size: 12px; padding: 10px 0; color: #212529">
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 40px"></td>
    </tr>
    </tbody>
    </table>
    </body>

    </html>
<?php } ?>