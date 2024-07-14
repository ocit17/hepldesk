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
				<div class="form-group">
					<label for="bulan_tahun">Filter Bulan dan Tahun:</label>
					<select id="bulan_tahun" class="form-control">
						<?php
						$currentYear = date('Y');
						for ($month = 1; $month <= 12; $month++) {
							$monthPadded = str_pad($month, 2, '0', STR_PAD_LEFT);
							echo '<option value="' . $monthPadded . '-' . $currentYear . '">' . $monthPadded . '-' . $currentYear . '</option>';
						}
						?>
					</select>
				</div>
				<table id="table" data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc">
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
					<tbody id="report-body">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		function fetchReport(bulan_tahun) {
			$.ajax({
				url: "<?php echo base_url('dashboard_teknisi/fetch_report_bulanan'); ?>",
				method: "POST",
				data: {
					bulan_tahun: bulan_tahun
				},
				dataType: "json",
				success: function(data) {
					var html = '';
					$.each(data, function(key, row) {
						html += '<tr>' +
							'<td>' + row.id_ticket + '</td>' +
							'<td>' + row.request_date + '</td>' +
							'<td>' + (row.tanggal_proses ? row.tanggal_proses : '') + '</td>' +
							'<td>' + (row.tanggal_solved ? row.tanggal_solved : '') + '</td>' +
							'<td>' + row.problem_summary + '</td>' +
							'<td>' + row.dibuat_oleh + '</td>' +
							'<td>' + row.by_teknisi + '</td>' +
							'<td>' + getStatus(row.status) + '</td>' +
							'<td><div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="' + row.progress + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + row.progress + '%"><span>' + row.progress + ' % Complete (Progress)</span></div></div></td>' +
							'</tr>';
					});
					$('#report-body').html(html);
				}
			});
		}

		function getStatus(status) {
			switch (status) {
				case '1':
					return "Open/Request";
				case '2':
					return "Approval Internal";
				case '3':
					return "Menunggu Approval Teknisi";
				case '4':
					return "Proses Teknisi";
				case '5':
					return "Pending Teknisi";
				case '6':
					return "Solved";
				default:
					return "Rejected";
			}
		}

		function setDefaultMonthYear() {
			var currentDate = new Date();
			var currentMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2); // Get current month and pad with 0 if needed
			var currentYear = currentDate.getFullYear();
			$('#bulan_tahun').val(currentMonth + '-' + currentYear).change();
		}

		$('#bulan_tahun').change(function() {
			var bulan_tahun = $(this).val();
			fetchReport(bulan_tahun);
		});

		setDefaultMonthYear();
	});
</script>