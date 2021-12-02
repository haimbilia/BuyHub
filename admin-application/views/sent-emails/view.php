<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="roundedbox">
	<div class="boxhead"><h4><?php echo Labels::getLabel('LBL_Sent_Email_Detail',$adminLangId); ?></h4></div>
	<div class="boxbody">
		<div class="contentheight">
			<ul class="descList">
				<li>
					<span class="captions"><?php echo Labels::getLabel('LBL_Template_Name',$adminLangId); ?></span>
					<span class="value captions"><?php echo $data['earch_tpl_name'];?></span>
				</li>
				<li>
					<span class="captions"><?php echo Labels::getLabel('LBL_Subject',$adminLangId); ?></span>
					<span class="value captions"><?php echo $data['earch_subject'];?></span>
				</li>
				<li>
					<span class="captions"><?php echo Labels::getLabel('LBL_Sent_On',$adminLangId); ?></span>
					<span class="value captions"><?php echo FatDate::format($data['earch_sent_on']);?></span>
				</li>
				<li>
					<span class="captions"><?php echo Labels::getLabel('LBL_Sent_To',$adminLangId); ?></span>
					<span class="value captions"><?php echo $data['earch_to_email'];?></span>
				</li>				
				<li>
					<span class="captions"><?php echo Labels::getLabel('LBL_Content',$adminLangId); ?></span>
					<span class="value captions ">					
                                            <div  class="email-temp"><?php echo CommonHelper::renderHtml($data['earch_body'],true);?></div>
                                        </span>
				</li>
				
			</ul>
		</div>
	</div>
</section>