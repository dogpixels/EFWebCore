<?php
    /**
     * The data for this page lies on https://www.eurofurence.org/data/lfdb.json, which is to be pulled periodically
     * from the L.A.S.S.I.E. API (doc: https://wiki.furcom.org/bin/view/L.A.S.S.I.E./System%20Information/API%20V2.0/)
     * There should be a cron job running on the EF server that...
     *  * runs every 15 minutes during convention time, and
     *  * once a day throughout the rest of the year.
     * command: `curl -X POST -d "apikey={LFDB_API_KEY}" -d "request=lostandfounddb" https://api.lassie.online/v2.0 > /home/ef-web/sites/www.eurofurence.org/data/lfdb.json`
     * LFDB_API_KEY to be obtained from Dingo.
     */

    $db = json_decode(file_get_contents('https://www.eurofurence.org/data/lfdb.json'), true);
    $no_image_path = 'img/pages/lostandfound/no-photo.png';
?>

<h1>Lost and Found</h1>

<p>All Items found at the convention are stored and can be redeemed only at the Security FrontDesk at next Eurofurence in Hamburg.</p>

<div class="uk-grid-small uk-grid-match uk-child-width-1-2@l uk-child-width-1-4@xl uk-margin-bottom" uk-grid>
    <?php
    foreach ($db['data'] as $data)
    {
        foreach (['image', 'thumb'] as $imgtype) {
            if ($data[$imgtype])
            {
                $newpath = 'img/pages/lostandfound/' . $imgtype . '/' . basename($data[$imgtype]);

                if (!file_exists($newpath))
                {
                    if (file_put_contents($newpath, file_get_contents($data[$imgtype])))
                    {
                        $data[$imgtype] = $newpath;
                    }
                    else
                    {
                        $data[$imgtype] = $no_image_path;
                    }
                }
                else
                {
                    $data[$imgtype] = $newpath;
                }
            }
            else
            {
                $data[$imgtype] = $no_image_path;
            }
        }

        switch($data['status'])
        {
            case 'L': $data['status'] = "Lost Item"; break;
            case 'F': $data['status'] = "Found Item"; break;
            default: $data['status'] = "Unknown Status '".$data['status']."'"; break;
        }
    ?>

    <div>
        <div class="uk-card uk-card-default" uk-scrollspy="cls:uk-animation-fade">
            <div class="uk-card-media-top">
                <div uk-lightbox>
                    <a href="<?= $data['image'] ?>" class="ef-hide-ext"><img class="uk-height-max-medium" src="<?= $data['thumb'] ?>" alt="(no image)" /></a>
                </div>
            </div>
            <div class="uk-card-body">
                <div class="uk-card-badge uk-label">
                    <?= $data['status'] ?>
                </div>

                <h3 class="uk-card-title reset-font"> <?= $data['title'] ?></h3>
                <p>Item ID: <?= $data['id'] ?></p>

                <p><?= $data['description'] ?></p>
                <?= $data['lost_timestamp']? "<p>Lost: " . $data['lost_timestamp'] . "</p>" : "" ?>
                <?= $data['found_timestamp']? "<p>Found: " . $data['found_timestamp'] . "</p>" : "" ?>
                <?= $data['return_timestamp']? "<p>Return: " . $data['return_timestamp'] . "</p>" : "" ?>
            </div>
        </div>
    </div>
    <? } ?>

</div>