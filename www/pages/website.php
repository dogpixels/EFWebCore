<section>
	<h1>
		Featured Artist: To be Announced
	</h1>
</section>

<hr />

<section id="ef-badger" class="uk-column-1-2@l">
	<div>
		<h2>Eurofurence Badger Addon</h2>
		<p>This brand-new browser addon will enhance your visit to the Eurofurence website by adding <span class="ef-new"></span> badges to pages that have been updated since you last viewed them!</p>
		<p>Available for <a href="https://addons.mozilla.org/firefox/addon/eurofurence-badger/" target="_blank">Mozilla Firefox</a> and <a href="https://chrome.google.com/" target="_blank">Google Chrome</a>.</p>
	</div>
	<div>
		<h2>Third Party Attributions</h2>
		<ul>
			<li><a href="https://getuikit.com" target="_blank">UIkit</a> by <a href="https://yootheme.com/" target="_blank">YOOtheme GmbH</a> (<a href="https://github.com/uikit/uikit/blob/develop/LICENSE.md" target="_blank">license</a>)</li>
		</ul>
	</div>
</section>

<hr />

<section>
	<h2>Website Team</h2>
	<p>Please direct any comments, ideas or critique about our website to the following folks:</p>

	<div class="ef-people uk-grid-match" uk-grid>
	<?php
		$members = [
			// ['Name', 'Title', 'Image', 'Link'],
			['draconigen', 'Director, Main Website, Help Center', 'draconigen.png', 'https://www.dogpixels.net/draconigen/'],
			['fafnyr', 'Vice Director &amp; System Administration', 'fafnyr.png', 'https://www.furaffinity.net/user/fafnyr/'],
			['Fenmar', 'Archive', 'fenmar.png', 'https://fenmar.de/'],
			['Fenrikur', 'Nosecounter', 'fenrikur.png', 'https://twitter.com/Fenrikur/'],
			['Fleeks', 'Logo Design', 'fleeks.png', 'https://fleeks.art/'],
			['Sebin', 'Feedback Management', 'sebin.png', 'https://twitter.com/SebinNyshkim'],
			['Sithy', 'Writing', 'sithy.png', 'https://twitter.com/MxSithy'],
			['Vinaru', 'Banner Exchange', 'vinaru.png', 'https://twitter.com/Vinaru'],
		];

		foreach ($members as $m) { ?>
			<a href="<?= $m[3] ?>" target="_blank" class="ef-hide-ext uk-width-medium">
				<div>
					<img src="img/pages/website/<?= $m[2] ?>" alt="<?= $m[2] ?>" />
					<h3><?= $m[0] ?></h3>
					<span><?= $m[1] ?></span>
				</div>
			</a>
		<?php } ?>
	</div>
</section>

<hr />

<section class="uk-margin-top">
	<h2>Tech Support &amp; Bug Report</h2>
	
	<p>Layout broken? Pages display weird content? You don't like the colors? We're grateful for every bug report (and feedback) you file in.<br/>
	If you would like to include a screenshot, please upload it to any host and include a link in your report. After all, a picture says more than thousand words.<br/>
	When doing so, please ensure that you include every detail about the circumstances, under which the bug occurred.</p>	
	<p><a href="https://help.eurofurence.org/contact/web/bugreport" target="_blank">Contact the Website Team</a></p>
</section>