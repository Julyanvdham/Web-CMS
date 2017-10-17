<table class="table table-responsive table-hover table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Slug</th>
			<th>Author</th>
			<th>Last modified</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php
			use \System\Database;

			$rows = Database::FetchAll(Database::Query("SELECT * FROM view_pages ORDER BY last_modified DESC"), MYSQLI_ASSOC);

			foreach ($rows as $row):
				?>
				<tr>
					<td scope="row"><?php echo $row['ID']; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['slug']; ?></td>
					<td><?php echo $row['username']; ?></td>
					<td><?php echo $row['last_modified']; ?></td>
				</tr>
			<?php endforeach; ?>
	</tbody>
</table>