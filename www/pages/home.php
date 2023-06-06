<h1><?= $this->current->title ?></h1>

<strong>Deployment Quick Start:</strong>
<ul>
    <li>update <em>partners.json</em> and run <a href="updatepartners.php">updatepartners.php</a> to update / load banners</li>
    <li>run <a href="?export">/?export</a> to deploy to <em><?= $this->config->staticOut->path ?></em></li>
</ul>

<?php debug($this->current) ?>