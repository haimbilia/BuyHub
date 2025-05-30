<div class="cg-main">
	<?php
	$catCount = 1;
	foreach ($categoriesArr as $category) { ?>
		<div class="cg-main-item anchor--js--link-<?php echo $catCount; ?>">
			<h6 class="big-title"> <a
					href="<?php echo UrlHelper::generateUrl('category', 'view', array($category['prodcat_id'])); ?>"><?php echo $category['prodcat_name']; ?></a>
			</h6>
			<?php if (!empty($category['children'])) { ?>
				<div class="cell__body">
					<ul>
						<?php foreach ($category['children'] as $subcat) { ?>
							<li><a href="<?php echo UrlHelper::generateUrl('category', 'view', array($subcat['prodcat_id'])); ?>">
									<?php echo $subcat['prodcat_name'] ?></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php
			} ?>
		</div>
		<?php $catCount++;
	} ?>
</div>