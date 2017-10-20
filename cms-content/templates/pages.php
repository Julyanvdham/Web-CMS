<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 22:13
	 */

	use System\Database;
	use System\Page;

	$offset = 0;

	if (isset($_GET['o']))
		$offset = intval($_GET['o']);

	$maxperpage = 5;

	$query = Database::Query("SELECT * FROM pages ORDER BY last_modified DESC");
	if (!$query)
		return "";

	$rows = Database::FetchAll($query, MYSQLI_ASSOC);
	$pages = array();
	foreach ($rows as $row)
		array_push($pages, Page::GetFromSlug($row['slug']));

	$page_blocks = ceil(count($pages) / $maxperpage);

	if ($offset > $page_blocks)
		$offset = 0;

	$page_display = array_slice($pages, $offset * $maxperpage, $maxperpage);

	foreach ($page_display as $page)
		echo $page->toHTML();

	if ($page_blocks > 1):
		?>
		<nav aria-label="Navigation" class="mt-3">
			<ul class="pagination justify-content-center">
				<li class="page-item <?php echo $offset > 0 ? "" : "disabled"; ?>">
					<a class="page-link" href="<?php echo sprintf(PAGES_URL, ($offset > 0 ? $offset - 1 : 0)); ?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
						<span class="sr-only">Previous</span>
					</a>
				</li>
				<?php for ($index = 0; $index < $page_blocks; $index++): ?>
					<li class="page-item <?php echo $index == $offset ? "active" : ""; ?>"><a class="page-link" href="<?php echo sprintf(PAGES_URL, $index); ?>"><?php echo $index + 1; ?></a></li>
				<?php endfor; ?>
				<li class="page-item <?php echo $offset < $page_blocks - 1 ? "" : "disabled"; ?>">
					<a class="page-link" href="<?php echo sprintf(PAGES_URL, ($offset < $page_blocks - 1 ? $offset + 1 : $page_blocks - 1)); ?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
						<span class="sr-only">Next</span>
					</a>
				</li>
			</ul>
		</nav>
	<?php endif; ?>
