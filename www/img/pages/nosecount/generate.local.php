<?php
/**
 * Example for using the Nosecounter class to generate a HTML output file.
 *
 * (c) 2016 by Fenrikur <nosecounter@fenrikur.de>
 */

require_once 'Nosecounter.php';

$nosecounter = new \nosecounter\Nosecounter();

echo $nosecounter->setApiUrl('https://reg.eurofurence.org/regsys/service/nosecounter-api')
    ->setApiToken('8wiPRQq7ZsYso4af8Rm8')
    ->setYear(2020)
    ->setRegistrationsInterval(1*60)
    ->setRegistrationsStart(new DateTime('2020-01-12 19:00:00', new DateTimeZone('UTC')))
    ->setRegistrationsEnd(new DateTime('2020-01-12 23:00:00', new DateTimeZone('UTC')))
    ->setStatusBarPrefix('&diam;&nbsp;')
    ->setStatusBarSuffix('&nbsp;&diam;')
    ->setStatusBarSeparator(' &diam;&nbsp;')
    ->setSvgGraphDefaultSettings(array(
        'back_colour' => 'rgba(255,255,255,0.19)',
        'back_round' => 10,
        'legend_back_colour' => 'rgba(255,255,255,0.3)',
        'back_stroke_colour' => 'rgba(255,255,255,0.5)',
        'axis_colour' => '#111',
        'axis_font' => 'sans-serif',
        'axis_overlap' => 1,
        'grid_colour' => 'rgba(255,255,255,0.5)',
        'label_colour' => 'rgba(55,55,55,0.7)',
        'legend_shadow_opacity' => 0.5,
        'legend_position' => 'outside right 10 0'
    ))
    ->generate('./view.php', './index.html');
