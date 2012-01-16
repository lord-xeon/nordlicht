<section class="tab-inside">
	<div class="chart-section">
    	<h2 class="chart-title hidden">World Globe</h2>
       	<div class="collapse-chart"></div>
        <div class="auto-spin fade-it"></div>
        <div class="d3-chart-holder domain-map">
            <div id="domain-chart"></div>
            <div id="auto-rotate"></div>
            <aside id="domain-tip" class="info-box">
                <ul class="values">
                    <li class="country-value" data-tipValue="Country:"><img src="amo/css/images/flags/unknown.png" alt="flag icon" class="country-flag" /></li>
                    <li class="pages-value" data-tipValue="Pages:"></li>
                    <li class="hits-value" data-tipValue="Hits:"></li>
                    <li class="bandwidth-value" data-tipValue="Bandwidth:"></li>
                </ul>
            </aside>
            <div id="domain-controls">
                <aside id="current-cords" class="info-box">
                    <ul class="metrics">
                        <li class="current-lat"></li>
                        <li class="current-long"></li>
                    </ul>
                </aside>
                <div id="lat-control"></div>
                <div id="long-control"></div>
            </div>
		</div> <!-- closes d3-chart-holder div -->
    </div> <!-- closes chart-section div -->
    <div class="grid-holder">
        <table id="domain-grid">
            <tr>
                <td></td>
            </tr>
        </table>
        <div id="domain-pager"></div>
	</div> <!-- closes grid-holder div -->
</section>