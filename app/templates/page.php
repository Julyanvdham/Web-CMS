<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 14-10-2017
	 * Time: 22:38
	 */

?>
<div class="card">
	<div class="card-header"><h4 class="card-title">%%TITLE%%</h4></div>
	<div class="card-body">
		<div class="card-text">
			%%CONTENT%%
		</div>
	</div>
	<div class="card-footer">
		<small class="text-muted">
			<a class="text-muted" data-toggle="collapse" href="#detailaccordion-%%SLUG%%" aria-expanded="true" aria-controls="detailaccordion-%%SLUG%%">
				Details...
			</a>
			<div id="detailaccordion-%%SLUG%%" class="collapse">
				Author: %%AUTHOR%%
				<br/>
				Created on: %%CREATIONDATE%%
				<br/>
				Last modified on: %%LASTMODIFIED%%
				<br/>
				Slug: %%SLUG%%
			</div>
		</small>
	</div>
</div>
<script>
    $(document).ready(function () {
        Page.setTitle("%%TITLE%%");
    });
</script>
