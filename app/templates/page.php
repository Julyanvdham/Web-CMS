<div class="card page">
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
				<strong>Author:</strong> %%AUTHOR%%
				<br/>
				<strong>Created on:</strong> %%CREATIONDATE%%
				<br/>
				<strong>Last modified on:</strong> %%LASTMODIFIED%%
				<br/>
				<strong>Slug:</strong> %%SLUG%%
			</div>
		</small>
	</div>
</div>
<script>
    $(document).ready(function () {
        Page.setTitle("%%TITLE%%");
    });
</script>