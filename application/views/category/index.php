<div id="body" class="body">
	<div class="bg-second pt-3 pb-3">
		<div class="container">
			<div class="section-head section--white--head justify-content-center mb-0">
				<div class="section__heading">
					<h2 class="mb-0"><?php echo Labels::getLabel('LBL_Shop_By_Categories', $siteLangId); ?></h2>
				</div>
			</div>
		</div>
	</div>
	<section class="section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12">
					<ul class="list-collections">
						<?php foreach ($categoriesArr as $category) { ?>
							<li class="list-collections__item">
								<a href="<?php echo UrlHelper::generateUrl('category', 'view', array($category['prodcat_id'])); ?>">
									<div class="aspect-ratio" style="padding-bottom: 45%">
										<div class="list-collections__image" style="background-image: url(<?php echo UrlHelper::generateFullFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId)); ?>);">
										</div>
									</div>
									<h6 class="list-collections__heading"><?php echo $category['prodcat_name']; ?></h6>
								</a>
							</li>
						<?php } ?>
						<?php /* $this->includeTemplate('category/categories-list.php',array('categoriesArr'=>$categoriesArr),false); */ ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container">

			<div class="categories-pg">
				<div class="card-category">
					<div class="card-category-head">
						<img data-aspect-ratio="1:1" src="http://localhost/yokart/images/products/product-16.jpg" alt="">
					</div>
					<div class="card-category-body">
						<h6 class="title">Electronics</h6>
						<ul>
							<li> <a href="/yokart/televisions">Televisions</a>
							</li>
							<li> <a href="/yokart/washing-machines">Washing Machines</a>
							</li>
							<li> <a href="/yokart/mobiles">Mobiles</a>
							</li>
							<li> <a href="/yokart/gaming-consoles">Gaming Consoles</a>
							</li>
							<li> <a href="/yokart/washing-machines">Washing Machines</a>
							</li>
							<li> <a href="/yokart/laptops">Laptops</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="card-category">
					<div class="card-category-head">
						<img data-aspect-ratio="1:1" src="/yokart/category/banner/117/1/MEDIUM/1" alt="">
					</div>
					<div class="card-category-body">
						<h6 class="title">Mobiles</h6>
						<ul>
							<li> <a href="/yokart/mobiles-phones">Phones</a>
							</li>
							<li> <a href="/yokart/mobiles-mobile-cases">Mobile Cases</a>
							</li>
							<li> <a href="/yokart/mobiles-headphones">Headphones</a>
							</li>
							<li> <a href="/yokart/mobiles-screengaurds">Screengaurds</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="card-category">
					<div class="card-category-head">
						<img data-aspect-ratio="1:1" src="/yokart/category/banner/122/1/MEDIUM/1" alt="">
					</div>
					<div class="card-category-body">
						<h6 class="title">Laptops</h6>
						<ul>
							<li> <a href="/yokart/laptops-antivirus">Antivirus</a>
							</li>
							<li> <a href="/yokart/laptops-laptop-bags">Laptop Bags</a>
							</li>
							<li> <a href="/yokart/laptops-business-laptops">Business Laptops</a>
							</li>
							<li> <a href="/yokart/laptops-antivirus">Antivirus</a>
							</li>
							<li> <a href="/yokart/laptops-laptop-bags">Laptop Bags</a>
							</li>
							<li> <a href="/yokart/laptops-business-laptops">Business Laptops</a>
							</li>
							<li> <a href="/yokart/laptops-antivirus">Antivirus</a>
							</li>
							<li> <a href="/yokart/laptops-laptop-bags">Laptop Bags</a>
							</li>
							<li> <a href="/yokart/laptops-business-laptops">Business Laptops</a>
							</li>
							 
							<li> <a href="/yokart/laptops-laptop-bags">Laptop Bags</a>
							</li>
							<li> <a href="/yokart/laptops-business-laptops">Business Laptops</a>
							</li>
							<li> <a href="/yokart/laptops-antivirus">Antivirus</a>
							</li>
							<li> <a href="/yokart/laptops-laptop-bags">Laptop Bags</a>
							</li>
							<li> <a href="/yokart/laptops-business-laptops">Business Laptops</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="card-category">
					<div class="card-category-head">
						<img data-aspect-ratio="1:1" src="http://localhost/yokart/images/products/product-16.jpg" alt="">
					</div>
					<div class="card-category-body">
						<h6 class="title">Electronics</h6>
						<ul>
							<li> <a href="/yokart/televisions">Televisions</a>
							</li>
							<li> <a href="/yokart/washing-machines">Washing Machines</a>
							</li>
							<li> <a href="/yokart/mobiles">Mobiles</a>
							</li>
							<li> <a href="/yokart/gaming-consoles">Gaming Consoles</a>
							</li>
							<li> <a href="/yokart/laptops">Laptops</a>
							</li>
						</ul>
					</div>

				</div>






			</div>




		</div>
	</section>
</div>