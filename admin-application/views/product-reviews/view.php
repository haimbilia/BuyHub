<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->developerTags['colClassPrefix'] = 'col-lg-';
$frm->developerTags['fld_default_col'] = 12;
?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_Product_Rating_Information', $adminLangId); ?></h4>
		<div class="section__toolbar">
			<a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>			
		</div>
	</div>
	<div class="sectionbody space">
		<div class="border-box border-box--space">

			<div class="repeatedrow">
				<div class="mb-3">
					<div class="listview">
						<dl class="list">
							<dt><?php echo Labels::getLabel('LBL_Product_Name', $adminLangId); ?></dt>
							<dd><?php echo $data['product_name']; ?></dd>
						</dl>
						<dl class="list">
							<dt><?php echo Labels::getLabel('LBL_Reviewed_By', $adminLangId); ?></dt>
							<dd><?php echo $data['reviewed_by']; ?></dd>
						</dl>
						<dl class="list">
							<dt><?php echo Labels::getLabel('LBL_Date', $adminLangId); ?></dt>
							<dd><?php echo FatDate::format($data['spreview_posted_on']); ?></dd>
						</dl>
						<?php foreach ($ratingData as $rating) { ?>
							<dl class="list">
								<dt>
									<?php echo $rating['ratingtype_name']; ?>
								</dt>
								<dd>

								<div class="rating">                                   
                                    <div class="rating-view" data-rating="<?php echo round($rating['sprating_rating']); ?>">
                                        <?php for ($i = 5; $i >= 1; $i--) { ?>
                                            <svg class="icon" width="24" height="24" viewBox="0 0 47.94 47.94">											
												<path d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757
													c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042
													c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685
													c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528
													c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956
													C22.602,0.567,25.338,0.567,26.285,2.486z" />     
                                            </svg>
                                        <?php } ?>
                                    </div>
                                </div>
								</dd>
							</dl>
						<?php } ?>
						<dl class="list">
							<dt><?php echo Labels::getLabel('LBL_Overall_Rating', $adminLangId); ?></dt>
							<dd>
							<div class="rating">                                   
                                    <div class="rating-view" data-rating="<?php echo round($avgRatingData['average_rating']); ?>">
                                        <?php for ($i = 5; $i >= 1; $i--) { ?>
                                            <svg class="icon" width="24" height="24" viewBox="0 0 47.94 47.94">											
												<path d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757
													c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042
													c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685
													c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528
													c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956
													C22.602,0.567,25.338,0.567,26.285,2.486z" />     
                                            </svg>
                                        <?php } ?>
                                    </div>
                                </div>
							</dd>
						</dl>
						<dl class="list">
							<dt><?php echo Labels::getLabel('LBL_Review_Title', $adminLangId); ?></dt>
							<dd><?php
								$findKeywordStr = implode('|', $abusiveWords);
								if ($findKeywordStr == '') {
									echo $data['spreview_title'];
								} else {
									echo preg_replace('/' . $findKeywordStr . '/i', '<span class="highlight">$0</span>', $data['spreview_title']);
								}
								?></dd>
						</dl>
						<dl class="list">
							<dt><?php echo Labels::getLabel('LBL_Review_Comments', $adminLangId); ?></dt>
							<?php if ($findKeywordStr == '') { ?>
								<dd><?php echo nl2br($data['spreview_description']); ?></dd>
							<?php } else { ?>
								<dd><?php echo preg_replace('/' . $findKeywordStr . '/i', '<span class="highlight">$0</span>', nl2br($data['spreview_description'])); ?></dd>
							<?php } ?>
						</dl>
						<div class="uploaded-media">
							<ul>
								<?php
								$images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_ORDER_FEEDBACK, $spreview_id);

								$i = 0;
								foreach ($images as $image) {
									$uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
									$imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($spreview_id, 0, 'MINITHUMB', $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
									$largeImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'review', array($spreview_id, 0, 'LARGE', $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

									if (5 > $i || 5 < $i) { ?>
										<li class="<?php echo 5 < $i ? 'd-none' : ''; ?>">
											<a class="uploaded-file" href="javascript:void(0)" onclick="previewImage(this);">
												<img src="<?php echo $imgUrl; ?>" data-altimg="<?php echo $largeImgUrl; ?>">
											</a>
										</li>
									<?php } else { ?>
										<li class="more-media" onclick="loadMoreImages(this);">
											<a class="uploaded-file" href="javascript:void(0)" data-count="<?php echo count($images); ?>+">
												<img src="<?php echo $imgUrl; ?>" data-altimg="<?php echo $largeImgUrl; ?>">
											</a>
										</li>
								<?php }
									$i++;
								} ?>
							</ul>
						</div>
					</div>
				</div>
				<?php /* if($data['spreview_status'] == SelProdReview::STATUS_PENDING){ */ ?>
				<div class="form_horizontal">
					<h3><?php echo Labels::getLabel('LBL_Change_Status', $adminLangId); ?></h3>
				</div>
				<div class="mt-3">
					<div class="listview">
						<?php
						$frm->setFormTagAttribute('class', 'web_form form_horizontal');
						$frm->setFormTagAttribute('onsubmit', 'updateStatus(this); return(false);');
						echo $frm->getFormHtml(); ?>
					</div>
				</div>
				<?php /* } */ ?>
			</div>
		</div>
	</div>
</section>