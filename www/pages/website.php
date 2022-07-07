<section class="just">
	<h1>Featured Artist: Caraid</h1>
	<div class="artistabout">
		<div class="artleft_web">
			<a href="img/pages/website/caraid_01.jpg" data-lightbox="website" data-title="&quot;Breathe&quot;" rel="lightbox"><img class="as_prev" src="img/pages/website/caraid_01_s.jpg" alt="'Breathe' - artwork by Caraid" /></a>
		</div>
		<div class="artright_web">
			Caraid is an artist from the Netherlands. Growing up, she decided to put her imaginative skills and affinity for drawing to good use in what was first a dedicated hobby and later became her career. While at work as a game artist she started dabbling in furry art in her spare time and joined the fandom under her current name in 2015. Despite being a relatively new face she quickly found herself in the company of some of the kindest, most generous and most interesting people she'd ever met and decided that she was here to stay.
			<br/>
			<ul>
				<li><a href="http://www.furaffinity.net/user/caraid/" title="Visit Caraid's gallery on FurAffinity" target="_blank">Caraid's gallery on FurAffinity</a></li>
				<li><a href="https://twitter.com/CaraidArt" title="Follow Caraid on Twitter" target="_blank">Caraid on Twitter</a></li>
			</ul>
			<div>
				<a href="img/pages/website/caraid_02.jpg" data-lightbox="website" data-title="&quot;Comfortable&quot;" rel="lightbox"><img class="as_prev" src="img/pages/website/caraid_02_s.jpg" alt="'Comfortable' - artwork by Caraid" /></a>
			</div>
		</div>	
	</div>
</section>
<hr/>
<section>
	<h2>Special Thanks</h2>
</section>
<section class="three_columns">
	<div class="ef-website-team boxshadowed bordered retain">
		<a href="https://jcdump.com/" target="_blank">
			<img class="ef-avatar" src="img/pages/website/avatar_jc.jpg" alt="Avatar of JC" />
			<h3>J.C.</h3>
			<span>Artwork (turtle) on main page</span>
		</a>
	</div>
</section>
<hr/>
<section>
	<h2>Third Party Attributions</h2>
	<ul>
		<li><a href="https://getuikit.com" target="_blank">UIkit by YOOtheme GmbH, getuikit.com</a> (<a href="https://github.com/uikit/uikit/blob/develop/LICENSE.md" target="_blank">license</a>)</li>
	</ul>
</section>
<hr/>
<section>
	<h2>Website Team</h2>
	<p>Please direct any comments, ideas or critique about our website to the following folks:</p>
</section>
<section class="three_columns">
<?php
	$members = [
		// ['Name', 'Title', 'Image', 'Link'],
		['Streifi', 'Director, Design, Code &amp; SEO', 'streifi.png', 'https://www.twitter.com/StreifiGreif'],
		['draconigen', 'Director &amp; Code', 'draconigen.png', 'https://www.twitter.com/realDraconigen'],
		['Fenmar', 'Archive &amp; JavaScript', 'fenmar.png', 'https://fenmar.de/'],
		['Fenrikur', 'Nosecounter', 'fenrikur.png', 'https://twitter.com/Fenrikur/'],
		['Vinaru', 'Banner Exchange', 'vinaru.png', 'https://twitter.com/Vinaru'],
		['Sithy', 'Writer', 'sithy.png', 'https://twitter.com/MxSithy'],
	];

	foreach ($members as $m) { ?>
		<div class="ef-website-team boxshadowed bordered retain">
			<a href="<?= $m[3] ?>" target="_blank">
				<img class="ef-avatar" src="img/pages/website/<?= $m[2] ?>" alt="" />
				<h3><?= $m[0] ?></h3>
				<span><?= $m[1] ?></span>
			</a>
		</div>
	<?php }
?>
</section>
<hr/>
<section>
	<h2>Tech Support &amp; Bug Report</h2>
	
	<p>Layout broken? Pages display weird content? You don't like the colors? We're grateful for every bug report (and feedback) you file in.<br/>
	If you would like to include a screenshot, please upload it to any host and include a link in your report. After all, a picture says more than thousand words.<br/>
	When doing so, please ensure that you include every detail about the circumstances, under which the bug occurred.</p>	
	<p><a href="https://help.eurofurence.org/contact/web/bugreport" target="_blank">Contact the Website Team</a></p>
</section>