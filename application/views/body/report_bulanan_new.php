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
					<label for="bulan">Filter Bulan:</label>
					<select id="bulan" class="form-control">
						<option value="">Pilih Bulan</option>
						<option value="1">Januari</option>
						<option value="2">Februari</option>
						<option value="3">Maret</option>
						<option value="4">April</option>
						<option value="5">Mei</option>
						<option value="6">Juni</option>
						<option value="7">Juli</option>
						<option value="8">Agustus</option>
						<option value="9">September</option>
						<option value="10">Oktober</option>
						<option value="11">November</option>
						<option value="12">Desember</option>
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
		function fetchReport(bulan) {
			$.ajax({
				url: "<?php echo base_url('dashboard_teknisi/fetch_report_bulanan'); ?>",
				method: "POST",
				data: {
					bulan: bulan
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

		function setDefaultMonth() {
			var currentMonth = new Date().getMonth() + 1; // Get current month (0-based, so add 1)
			$('#bulan').val(currentMonth).change();
		}

		$('#bulan').change(function() {
			var bulan = $(this).val();
			fetchReport(bulan);
		});

		setDefaultMonth();
	});
</script>