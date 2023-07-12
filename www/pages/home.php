<div id="home">
    <p>
        <?= $this->current->theme ?> <br />
        <?= $this->current->dates ?> <br />
        <?= $this->current->location ?>
    </p>
</div>

<div class="uk-column-1-2@l uk-margin-top landingpage-content-start">
    <a href="#content" id="scrolldown" uk-scroll="offset: 50"><h1>Scroll Down</h1></a>

    <h1><?= $this->current->title ?></h1>
</div>

<strong>Deployment Quick Start:</strong>
<ul>
    <li>update <em>partners.json</em> and run <a href="updatepartners.php">updatepartners.php</a> to update / load banners</li>
    <li>run <a href="?export">/?export</a> to deploy to <em><?= $this->config->staticOut->path ?></em></li>
</ul>

<?php debug($this->current) ?>