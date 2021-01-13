-- --------EasyECom---------- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_id`, `plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES (NULL, 'EasyEcom', '12', 'EasyEcom', '0', '1');

INSERT INTO `tbl_plugins_lang` (`pluginlang_plugin_id`, `pluginlang_lang_id`, `plugin_name`, `plugin_description`)
  SELECT `plugin_id`, '1', 'EasyEcom',  '
                    <div class="cms">
                        <div class="text-center my-5">
                            <small class="mb-5"> FEATURES</small>
                            <h3> The Complete ERP Solution For Your Business Needs</h3>
                            <p> Now Sell, Manage, Reconcile all your online and offline businesses from a single
                                dashboard.</p>
                        </div>
                    </div>

                    <ul class="list-features">
                        <li>
                            <i class="icn fa fa-tv"></i>
                            <div class="detail cms">
                                <h5>Improve Process Fitness</h5>
                                <p>With more than 50 channels integrated in the panel, our
                                    omni-channel
                                    order processing tool helps you increase efficiency.</p>
                            </div>
                        </li>

                        <li>
                            <i class="icn  fa fa-wrench"></i>
                            <div class="detail cms">
                                <h5>Smarter Stock Allocation and Purchasing Decision</h5>
                                <p>Central inventory management system to optimise your overall inventory across
                                    channels.

                                </p>
                            </div>
                        </li>
                        <li>
                            <i class="icn fa fa-cubes"></i>
                            <div class="detail cms">
                                <h5>Automated Reconciliation Tool
                                </h5>
                                <p>Automated reconciliation tool helps you keep a track on returns and unsettled
                                    invoices.

                                </p>
                            </div>
                        </li>
                        <li>
                            <i class="icn fa fa-code"></i>
                            <div class="detail cms">
                                <h5>Add Efficiency & Quality Control With End to End WMS Solution
                                </h5>
                                <p>Our cloud based WMS helps your warehouse team manage multiple warehouses in a
                                    seamless manner.

                                </p>
                            </div>
                        </li>
                        <li>

                            <i class="icn far fa-file-alt"></i>
                            <div class="detail cms">
                                <h5>Eliminate Tedious Data Entry & Duplication
                                </h5>
                                <p> Effortless integration of your accounting ERP with EasyEcom reduces error
                                    and cost involved.

                                </p>
                            </div>
                        </li>
                        <li>
                            <i class="icn fa fa-download"></i>
                            <div class="detail cms">
                                <h5>Gain Competitive Advantage With Data Analysis
                                </h5>
                                <p>The in-built advanced data analytics generates reports such as Margin report,
                                    Sales Report, Inventory forecasting etc helps you grow your business.

                                </p>
                            </div>
                        </li>
                    </ul>'
  FROM `tbl_plugins` WHERE plugin_code = "EasyEcom";
-- --------EasyECom---------- --