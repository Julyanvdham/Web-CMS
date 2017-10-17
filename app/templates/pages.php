<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 17-10-2017
	 * Time: 11:10
	 */

	use \System\Database;
	use \Page\Page;

	$max_per_page = 5;

	$offset = isset($_GET['o']) ? intval($_GET['o']) : 0;

	$rows = Database::FetchAll(Database::Query("SELECT * FROM PAGES ORDER BY last_modified DESC"), MYSQLI_ASSOC);

	$pageblocks = ceil(count($rows) / $max_per_page);

	if ($pageblocks > 1)
		$rows = array_slice($rows, $offset * 5, $max_per_page, true);

	foreach ($rows as $row) {
		$page = Page::GetFromSlug($row['slug']);
		echo $page->toHTML();
	}
	if ($pageblocks > 1):
		?>
		<nav aria-label="Navigation" class="mt-10">
			<ul class="pagination justify-content-center">
				<li class="page-item <?php if ($offset == 0) echo "disabled"; ?>">
					<a class="page-link" href="<?php echo sprintf(PAGES_URL, max(0, $offset - 1)); ?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
						<span class="sr-only">Previous</span>
					</a>
				</li>
				<?php for ($i = 0; $i < $pageblocks; $i++): ?>
					<li class="page-item <?php if ($offset == $i) echo "active"; ?>"><a class="page-link" href="<?php echo sprintf(PAGES_URL, $i); ?>"><?php echo $i + 1; ?></a></li>
				<?php endfor; ?>
				<li class="page-item <?php if ($offset + 1 == $pageblocks) echo "disabled"; ?>">
					<a class="page-link" href="<?php echo sprintf(PAGES_URL, min($pageblocks - 1, $offset + 1)); ?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
						<span class="sr-only">Next</span>
					</a>
				</li>
			</ul>
		</nav>
	<?php endif; ?>