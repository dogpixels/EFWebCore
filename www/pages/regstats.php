<h1>Registration Statistics</h1>

<style>
	#ef-regstats a {
		color: #000;
		text-decoration: none;
	}
	#ef-regstats a:hover {
		text-decoration: underline;
	}
	#ef-regstats div[uk-grid] > div > div {
		position: relative;
	}
	#ef-regstats h3 {
		margin-bottom: 0;
	}
	#ef-regstats h2 {
		margin-top: 0;
		margin-bottom: 0;
	}
	div.ef-rs-barchart ~ button {
		position: absolute;
		top: 40px;
		right: 40px;
	}
	.ef-rs-piechart {
		width: 7rem;
		height: 7rem;
	}
	.ef-rs-barchart {
		height: 200px;
	}

	/* looks better without step-end, 
	but causes +15% cpu load in Firefox,
	last tested in version 123 */
	.ef-rs-reg-opening-indicator-animation {
		animation: blink 2.5s infinite step-end;
	}
	@keyframes blink {
		0%, 100% {opacity: 1}
		50% { opacity: 0}
	}

	.ef-rs-legend {
		padding-top: 10px;
	}
	.ef-rs-legend > div ~ div {
		margin-left: 30px;
	}
	.ef-rs-legend tr {
		cursor: pointer;
	}
	.ef-rs-legend td {
		padding: 0 1px;
	}
	.ef-rs-legend td:nth-of-type(2),
	.ef-rs-legend td:nth-of-type(5) {
		text-align: right;
		font-weight: bold;
		vertical-align: top;
	}
	.ef-rs-legend table div {
		position: relative;
		top: 2px;
		width: 20px;
		height: 1em;
		margin-right: 4px;
	}
	.ef-rs-legend table tr:has(> :last-child:nth-child(6)) > :nth-child(3) {
		border-right: 1em solid transparent;
	}
</style>

<section id="ef-regstats">
	<div class="uk-grid-small uk-grid-match uk-child-width-1-3@l uk-child-width-1-2@s uk-margin-bottom" uk-grid>
		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title">Total Registrations</h3>
				<h2 class="uk-heading-large" id="ef-rs-reg-total"></h2>
				<span id="ef-rs-reg-opening-indicator">&#9679;</span>
				<span id="ef-rs-reg-opening"></span>
			</div>
		</div>

		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title">Registration State</h3>
				<div class="ef-rs-legend uk-flex">
					<div class="ef-rs-piechart"><canvas id="ef-rs-reg-status"></canvas></div>
					<div id="ef-rs-reg-status-legend"></div>
				</div>
			</div>
		</div>

		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title">Ticket Types</h3>
				<div class="ef-rs-legend uk-flex">
					<div class="ef-rs-piechart"><canvas id="ef-rs-reg-types"></canvas></div>
					<div id="ef-rs-reg-types-legend"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="uk-grid-small uk-grid-match uk-child-width-1-4@l uk-child-width-1-2@s uk-margin-bottom" uk-grid>
		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title"><span id="ef-rs-reg-interests-animators"></span></h3>
				<span uk-icon="play-circle"></span>Animators
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title"><span id="ef-rs-reg-interests-artists"></span></h3>
				<span uk-icon="image"></span>Artists
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title"><span id="ef-rs-reg-interests-fursuiters"></span></h3>
				<span uk-icon="users"></span>Fursuiters
			</div>
		</div>
		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title"><span id="ef-rs-reg-interests-musicians"></span></h3>
				<span uk-icon="microphone"></span>Musicians
			</div>
		</div>

		<!-- <div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title"><span id="ef-rs-reg-interests-writers"></span></h3>
				<span uk-icon="quote-right"></span>Writers
			</div>
		</div> -->
	</div>

	<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-width-1-1">
		<h3 class="uk-card-title uk-margin-bottom">Age Distribution</h3>
		<div class="ef-rs-barchart"><canvas id="ef-rs-age"></canvas></div>
	</div>

	<div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-width-1-1">
		<h3 class="uk-card-title uk-margin-bottom">Origins by Country</h3>
		<div class="ef-rs-barchart"><canvas id="ef-rs-country"></canvas></div>
		<button class="uk-icon-button" onclick="nc.zoomCountry()" uk-icon="search" uk-tooltip="pos:left" title="Toggle Zoom"></button>
	</div>

	<div class="uk-grid-small uk-grid-match uk-child-width-1-3@l uk-child-width-1-2@s uk-margin-bottom" uk-grid>
		<div>
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title">Shirt Sizes</h3>
				<div class="ef-rs-legend uk-flex">
					<div class="ef-rs-piechart"><canvas id="ef-rs-reg-size"></canvas></div>
					<div id="ef-rs-reg-size-legend"></div>
				</div>
			</div>
		</div>
	</div>
</section>

<hr />

<section>
	<p class="uk-text-right">
		data timestamp: <span id="ef-rs-timestamp"></span><br />
		next update in: <span id="ef-rs-update">-</span> seconds<br />
		<a href="regstats#raw" uk-toggle>show raw data</a>
	</p>
			
</section>

<div id="raw" class="uk-modal-container" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">Raw Data</h2>
		<pre id="ef-rs-data-raw" class="uk-textarea uk-height-large"></pre>
		<p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
        </p>
	</div>
</div>

<script src="js/chart.js"></script>
<script src="js/regstats.min.js"></script>
