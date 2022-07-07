<?php
/**
 * Simple HTML template for displaying the generated SVG.
 *
 * Copyright 2020 by Dominik "Fenrikur" Schöner <nosecounter@fenrikur.de>
 */

$baseUrl = "/EF26/pages/nosecount/";

function generateIntro($year, $statusData) {
	$checkedInCount = isset($statusData['Checked In']) ? $statusData['Checked In'] : 0;
	$paidCount = isset($statusData['Paid']) ? $statusData['Paid'] : 0;
	$partiallyPaidCount = isset($statusData['Partially Paid']) ? $statusData['Partially Paid'] : 0;
	$unconfirmedCount = isset($statusData['Unconfirmed']) ? $statusData['Unconfirmed'] : 0;
	$pendingCount = isset($statusData['New']) ? $statusData['New'] : 0;
	$acceptedCount = isset($statusData['Accepted']) ? $statusData['Accepted'] : 0;
	$interestedCount = $unconfirmedCount + $pendingCount + $acceptedCount;

	$checkedIn = $checkedInCount > 0 ? "Tharr be more to it than wearing a funny hat and knowing which end to hold a cutlass by, but nevertheless, <strong>$checkedInCount</strong> dauntless sailors have already joined us on our next plunder and <strong>checked-in</strong>." : "";

	$paid = $paidCount > 0 ? ("Although they still be strugglin' with rrrolling the r, <strong>$paidCount</strong> have already gone on account and <strong>paid</strong> their dues" . ($partiallyPaidCount > 0 ? ", while <strong>$partiallyPaidCount</strong> still owe us some treasure, having only <strong>partially paid</strong> up" : "") . ".") : "";

	$interested = "As for ye gawking lot, me matey up in the crow's nest just told me that by and large, <strong>$interestedCount</strong> of ye've been telling the parrot how easy 't is to become a pirate.";

	$unconfirmed = $unconfirmedCount > 0 ? "Yet <strong>$unconfirmedCount</strong> seem to be three sheets to the wind, their interest in us thereby remaining <strong>unconfirmed</strong>! " : "";

	$pending = $pendingCount > 0 ? "the crew and I are still busy rattling the bones on how long to keep <strong>$pendingCount</strong> of ye <strong>pending</strong>" : "";

	$accepted = $acceptedCount > 0 ? "<strong>$acceptedCount</strong> have already been <strong>accepted</strong>, with their permission to come aboard just waiting for their payments to be reaching our treasure chests" : "";

	$pendingOrAccepted = $pendingCount > 0 || $acceptedCount > 0 ? ("Meanwhile, $pending" . ($pendingCount > 0 && $acceptedCount > 0 ? ", while " : "") . "$accepted.") : "";

	return <<< EOINTRO
	<p>
		Avast ye, land-lubbers! Just here to gawk at the planks of our swashbuckling beauty laying at anchor over there, or might any of ye dare to actually get their noses wet? Granted, she may not look like much, but let me tell ye, me hearties and her, we've fought our fair share of battles and laid eyes on and plundered more treasure than any kings or queens ever called their own.
	</p>
	<p>
		$checkedIn
		$paid
	</p>
	<p>
		$interested
		$unconfirmed
		$pendingOrAccepted
	</p>
</section>
EOINTRO;
}

$intro = generateIntro($nosecounterData->year, $nosecounterData->statusCount);

$output = <<< EOF
<style type="text/css">
    @keyframes nosecounter-appear {
        from {opacity: 0; max-height: 0;}
        to {opacity: 100; max-height: 90ex;}
    }

    .nosecounter-diagram label {
        font-size: 140%;
        font-weight: bold;
    }

    .nosecounter-diagram input[type=checkbox] {
        display: none;
    }

    .nosecounter-diagram input[type=checkbox] ~ label::before {
        content: "+";
        padding-right: 1ex;
        color: #666;
    }

    .nosecounter-diagram input[type=checkbox]:checked ~ label::before {
        content: "–";
        padding-right: 1ex;
        color: #666;
    }

    .nosecounter-diagram input[type=checkbox] ~ div {
        display: none;
    }

    .nosecounter-diagram input[type=checkbox]:checked ~ div {
        display: block;
        animation-name: nosecounter-appear;
        animation-timing-function: ease-in-out;
        animation-duration: 2s;
    }

    .nosecounter-statusbar {
        font-weight: bold;
        border: 1px solid #666;
        background-color: #eee;
        padding: 1ex;
        margin: 1em 0;
        display: table;
    }
    
    .nosecounter-footer {
    	padding-top: 2ex;
    	font-size: 65%!important;
    }
</style>

<section class="nosecounter-header">
	<h1>Nosecounter {$nosecounterData->year}</h1>
	{$intro}

	<div class="nosecounter-statusbar">
		{$nosecounterData->statusbar}
	</div>
</section>

<section class="nosecounter-diagrams">
	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-regs" /><label for="nosecounter-regs">Registrations per {$nosecounterData->registrationsInterval}</label>
		<div><embed src="{$baseUrl}{$nosecounterData->registrations}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-status" /><label for="nosecounter-status">Attendance by Status</label>
		<div><embed src="{$baseUrl}{$nosecounterData->status}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-country" /><label for="nosecounter-country">Attendance by Country</label>
		<div><embed src="{$baseUrl}{$nosecounterData->country}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-country-cmp" /><label for="nosecounter-country-cmp">Attendance by Country (Comparison)</label>
		<div><embed src="{$baseUrl}{$nosecounterData->countryComparison}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-gender" /><label for="nosecounter-gender">Attendance by Gender</label>
		<div><embed src="{$baseUrl}{$nosecounterData->gender}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-gender-cmp" /><label for="nosecounter-gender-cmp">Attendance by Gender (Comparison)</label>
		<div><embed src="{$baseUrl}{$nosecounterData->genderComparison}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-sponsors" /><label for="nosecounter-sponsors">Sponsors</label>
		<div><embed src="{$baseUrl}{$nosecounterData->sponsors}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-sponsors-cmp" /><label for="nosecounter-sponsors-cmp">Sponsors (Comparison)</label>
		<div><embed src="{$baseUrl}{$nosecounterData->sponsorsComparison}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-age" /><label for="nosecounter-age">Age Distribution</label>
		<div><embed src="{$baseUrl}{$nosecounterData->age}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-age-cmp" /><label for="nosecounter-age-cmp">Age Distribution (Comparison)</label>
		<div><embed src="{$baseUrl}{$nosecounterData->ageComparison}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-demographics" /><label for="nosecounter-demographics">Demographics (Comparison)</label>
		<div><embed src="{$baseUrl}{$nosecounterData->demographics}" type="image/svg+xml" style="width: 100%" /></div>
	</div>

	<div class="nosecounter-diagram">
		<input type="checkbox" id="nosecounter-shirts" /><label for="nosecounter-shirts">T-Shirt Sizes (Comparison)</label>
		<div><embed src="{$baseUrl}{$nosecounterData->shirts}" type="image/svg+xml" style="width: 100%" /></div>
	</div>
</section>

<section class="nosecounter-footer">
    Code can be found on <a href="https://github.com/Fenrikur/Nosecounter" title="Fenrikur/Nosecounter @ GitHub" target="_blank">GitHub</a>
</section>
EOF;
