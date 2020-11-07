<?php 
include("core.php");
$core = new EFWebCore("core.config.json");

header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title><?= $core->current->title ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="<?= $core->current->description ?>" />
		<meta name="keywords" content="<?= $core->current->keywords ?>" />		
		<meta name="robots" content="<?= $core->current->robots ?>" />
		<meta name="author" content="draconigen@gmail.com" />
		<meta name="rating" content="general" />

		<base href="<?= $core->get_base(); ?>" />

		<link rel="stylesheet" href="css/main.css" />
	</head>

	<body>
		<?= $core->get_menu(); ?>
		<main>
			<?php $core->load_content(); ?>
		</main>
	</body>
</html>

<?php $core->end(); ?>