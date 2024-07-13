		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home">
							<use xlink:href="#stroked-home"></use>
						</svg></a></li>
				<li class="active">Report Bulanan</li>
			</ol>
		</div>

		<br>

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>REPORT</strong> <em>Bulanan</em>
					</div>
					<div class="panel-body">
						<table data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc">
							<thead>

								<tr>
									<th>Ticket ID</th>
									<th>Request Date</th>
									<th>Process Date</th>
									<th>Solved Date</th>
									<th>Problem Summary</th>
									<th>Created By</th>
									<th>Solved By</th>
									<th>Status</th>
									<th>Progress</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($rows as $row) : ?>
									<tr>
										<td><?php echo $row->id_ticket; ?></td>
										<td><?php echo $row->request_date; ?></td>
										<td><?php echo $row->tanggal_proses; ?></td>
										<td><?php echo $row->tanggal_solved; ?></td>
										<td><?php echo $row->problem_summary; ?></td>
										<td><?php echo $row->dibuat_oleh; ?></td>
										<td><?php echo $row->by_teknisi; ?></td>
										<td>
											<?php
											switch ($row->status) {
												case '1':
													echo "Open/Request";
													break;

												case '2':
													echo "Approval Internal";
													break;

												case '3':
													echo "Menunggu Approval Teknisi";
													break;

												case '4':
													echo "Proses Teknisi";
													break;

												case '5':
													echo "Pending Teknisi";
													break;

												case '6':
													echo "Solved";
													break;
												default:
													echo "Rejected";
													break;
											}
											?>
										</td>
										<td>
											<div class="progress">
												<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $row->progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row->progress; ?>%">
													<span><?php echo $row->progress; ?> % Complete (Progress)</span>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<script>
			$(function() {
				$('#hover, #striped, #condensed').click(function() {
					var classes = 'table';

					if ($('#hover').prop('checked')) {
						classes += ' table-hover';
					}
					if ($('#condensed').prop('checked')) {
						classes += ' table-condensed';
					}
					$('#table-style').bootstrapTable('destroy')
						.bootstrapTable({
							classes: classes,
							striped: $('#striped').prop('checked')
						});
				});
			});

			function rowStyle(row, index) {
				var classes = ['active', 'success', 'info', 'warning', 'danger'];

				if (index % 2 === 0 && index / 2 < classes.length) {
					return {
						classes: classes[index / 2]
					};
				}
				return {};
			}
		</script>