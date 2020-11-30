<?php 
include("core.php");
$core = new EFWebCore("core.config.json");

header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>

<html prefix="og: http://ogp.me/ns#" lang="en">
	<head>
		<title><?= $core->current->title ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="HandheldFriendly" content="true" /> 
		<meta name="mobile-web-app-capable" content="yes" />
		<meta name="description" content="<?= $core->current->description ?>" />
		<meta name="keywords" content="<?= $core->current->keywords ?>" />		
		<meta name="robots" content="<?= $core->current->robots ?>" />
		<meta name="author" content="web@eurofurence.org" />
		<meta name="rating" content="general" />
		<meta name="theme-color" content="<?= $core->current->themeColor ?>" />

		<base href="<?= $core->base; ?>" />

		<link rel="apple-touch-icon" sizes="57x57" href="img/icon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="img/icon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="img/icon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/icon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="img/icon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/icon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="img/icon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/icon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="img/icon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="img/icon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:site" content="@eurofurence" />
		<meta name="twitter:creator" content="@eurofurence" />
		<meta name="twitter:title" content="<?= $core->current->title ?>" />
		<meta name="twitter:description" content="<?= $core->current->description ?>" />
		<meta name="twitter:image" content="<?= $core->current->ogpImage ?>" />

		<meta property="og:image" content="<?= $core->current->ogpImage ?>" />
		<meta property="og:image:width" content="<?= $core->current->ogpImageWidth ?>" />
		<meta property="og:image:height" content="<?= $core->current->ogpImageHeight ?>" />
		<meta property="og:title" content="<?= $core->current->title ?>" />
		<meta property="og:description" content="<?= $core->current->description ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?= $core->get_full_url() ?>" />
		<meta property="og:site_name" content="Eurofurence <?= $core->current->number ?> - <?= $core->current->theme ?>" />

		<link rel="canonical" href="<?= $core->get_full_url() ?>" />

		<?php 
		if (isset($core->current->previous)) 
			echo '<link rel="prev" href="https://www.eurofurence.org/EF' . $core->current->number . '/' . $core->current->previous . '" />' . "\n";
		
		if (isset($core->current->next)) 
			echo '<link rel="next" href="https://www.eurofurence.org/EF' . $core->current->number . '/' . $core->current->next . '" />' . "\n";
		?>

		<?php 
		$bcdata = $core->get_breadcrumb_data();
		$pos = 2;
		?>

		<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "BreadcrumbList",
			"itemListElement": 
			[
				{
					"@type": "ListItem",
					"position": 1,
					"item": 
					{
						"@id": "https://www.eurofurence.org",
						"name": "Eurofurence <?= $core->current->number ?>" 
					}
				}
			<?php foreach ($bcdata as $key => $bc) { ?>
				,{
					"@type": "ListItem",
					"position": <?= $pos++ ?>,
					"item":
					{
						"@id": "<?= $bc->url ?>",
						"name": "<?= $bc->name ?>"
					}
				}
			<?php } // end of foreach loop ?>
			]
		}
		</script>

		<script type='application/ld+json'> 
		{
			"@context": "http://www.schema.org",
			"@type": "Event",
			"name": "Eurofurence <?= $core->current->number ?>",
			"url": "https://www.eurofurence.org",
			"description": "The <?= $core->current->ordinal ?> edition of Europe's largest furry convention, themed '<?= $core->current->theme ?>'",
			"startDate": "<?= $core->current->start ?>",
			"endDate": "<?= $core->current->end ?>",
			"image": "<?= $core->base . $core->current->ogpImage ?>",
			"location": {
			"@type": "Place",
			"name": "Estrel Hotel",
			"sameAs": "http://www.estrel.com",
			"address": {
				"@type": "PostalAddress",
				"streetAddress": "Sonnenallee 225",
				"addressLocality": "Berlin",
				"postalCode": "12057",
				"addressCountry": "Germany"
		}
		}}
		</script>

		<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "Organization",
			"name": "Eurofurence",
			"url": "https://www.eurofurence.org",
			"logo": "<?= $core->base ?>apple_favicon.png",
			"sameAs": [
				"https://twitter.com/eurofurence",
				"https://www.facebook.com/Eurofurence",
				"https://vimeo.com/eurofurence"
			]
		}
		</script>

		<link rel="stylesheet" href="css/main.css" />
	</head>

	<body>
		<nav>
			<?= $core->get_menu() ?>
		</nav>
		<main>
			<header>
				<div id="news">loading latest announcements ...</div>
			</header>
			<div id="content">
				<?= $core->get_content() ?>
			</div>
		</main>

		<script src="js/newsagent.js"></script>
		<script>
			window.onload = async () => 
			{
				const items = await NewsAgent.fetch();
				console.log(items);

				// prepare news div
				news.innerText = items.length === 0? "error loading announcements :(" : "";

				// fill news div
				for (let i = 0; i < items.length; i++)
				{
					const item = items[i];
					news.innerHTML += `<article><a href="${item.link}" target="_blank"><cite>${item.subject}</cite><time>${item.time}</time></a></article>`;
				}
			}			
		</script>
	</body>
</html>

<?php $core->end(); ?>