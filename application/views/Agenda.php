<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Coat_of_arms_of_West_Java.svg/1200px-Coat_of_arms_of_West_Java.svg.png">
	<title>Agenda</title>

	<style>
		.container {
			margin-top: 0%;
		}

		hr {
			background-color: #015579;
			padding: 1px;
		}

		#time {
			float: right;
		}

		.sticky {
			position: -webkit-sticky;
			position: sticky;
			top: 0;
			z-index: 1;
			background-color: white;
		}

		#tabel {
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}
	</style>
</head>

<body onload="Time()">
	<div class="container">
		<div class="sticky">
			<div class="row">
				<div class="col-sm-6">
					<h3>Agenda Diskominfo</h3>
				</div>
				<div class="col-sm-6">
					<h3 id="time"></h3>
				</div>
			</div>
			<hr>
		</div>
		<div class="row">
			<div class="col">
				<table id="tabel" class="table table-bordered">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Waktu</th>
							<th>Acara</th>
							<th>Tempat</th>
							<th>Pelaksana</th>
						</tr>
					</thead>
					<tbody class='datas'>
						<?php foreach ($res as $bigRow) {
							echo ('<div class="container">
								<td class="bigrow" colspan="5"></td>
								<tr></tr>');
							if (empty($bigRow)) {
								echo '<td>';
								echo '<td> Tidak ada acara <td>';
								echo '</td>';
								echo '<tr>';
							} else {
								foreach ($bigRow as $data) {
									echo '<td>';
									echo "<td>" . $data["time_start"] . "-" . $data["time_ends"] . "<td>" . $data["isi_agenda"] . "<td>" . $data["judul_agenda"] . "<td>" . $data["penanggung_jawab"];
									echo '</td>';
									echo '<tr>';
								}
							}
							echo '</div>';
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		function Time() {
			var realtimeclock = new Date();

			var jam = realtimeclock.getHours();
			var menit = realtimeclock.getMinutes();
			var detik = realtimeclock.getSeconds();
			var tggl = realtimeclock.getDate();
			var bln = realtimeclock.getMonth() + 1;
			var thn = realtimeclock.getFullYear();
			var hari = realtimeclock.getDay();

			var ampm = (jam < 12) ? "AM" : "PM";

			jam = (jam > 12) ? jam - 12 : jam;

			jam = ("0" + jam).slice(-2);
			menit = ("0" + menit).slice(-2);
			detik = ("0" + detik).slice(-2);

			document.getElementById('time').innerHTML = tggl + "/" + bln + "/" + thn + " - " + jam + " : " + menit + " : " + detik + ' ' + ampm;
			var t = setTimeout(Time, 1000);
			var data = {};

			function setDate() {
				var iteration = 0;
				data = {};
				$.each($('.bigrow'), function() {
					// console.log($(this));
					$(this)[0].innerHTML = converterthn(tggl + iteration, bln, thn) + '-' + converterbln(tggl + iteration, bln, thn) + '-' + converter(tggl + iteration, bln, thn);;
					data['tanggal' + (iteration + 1)] = $(this)[0].innerHTML;
					iteration++;
				});
				// console.log('border');
			}

			function setDay() {
				var day = new Date().getDay();
				var iteration = 0;
				var countDate = 1;
				var hari = ""
				var temp = 0
				data = {};
				$.each($('.smallrow'), function() {
					// console.log($(this));
					switch (countDate) {
						case 0:
							hari = "Senin"
							break;
						case 1:
							hari = "Selasa"
							break;
						case 2:
							hari = "Rabu"
							break;
						case 3:
							hari = "Kamis"
							break;
						case 4:
							hari = "Jumat"
							break;
						case 5:
							hari = "Sabtu"
							break;
						case 6:
							hari = "Minggu"
							break;
						default:
							countDate = 1
							hari = "Senin"
							break;
					}
					$(this)[0].innerHTML = converterthn(tggl + iteration, bln, thn) + '-' + converterbln(tggl + iteration, bln, thn) + '-' + converter(tggl + iteration, bln, thn) + ', ' + hari;
					data['tanggal' + (iteration + 1)] = $(this)[0].innerHTML;
					countDate++;
					iteration++;

				});

			}
			setDay();

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/FullCalendar/loadRealtime",
				type: "POST",
				data: data,
				success: function(res) {
					$('.datas')[0].innerHTML = res;
					setDate();
					setDay();
				}
			});
		}

		function getHari(bln, thn) {
			var hari = 0
			if (bln == 2 && thn % 4 == 0) {
				hari = 29
			} else {
				hari = 28
			}

			switch (bln) {
				case 1:
					hari = 31
					break;
				case 3:
					hari = 31
					break;
				case 4:
					hari = 30
					break;
				case 5:
					hari = 31
					break;
				case 6:
					hari = 30
					break;
				case 7:
					hari = 31
					break;
				case 8:
					hari = 31
					break;
				case 9:
					hari = 30
					break;
				case 10:
					hari = 31
					break;
				case 11:
					hari = 30
					break;
				case 12:
					hari = 31
					break;
			}
			return hari
		}

		function converter(tgl, bln, thn) {
			var tglakhr = 0
			var blnakhir = 0
			var thnakhir = 0
			if (bln > 11 && bln == 12 && tgl > getHari(bln, thn)) {
				if (tgl > 9) {
					tglakhr = (tgl - getHari(bln, thn))
					thnakhir = (1 + thn)
					blnakhir = (bln + 1) - 12
				} else {
					tglakhr = '0' + (tgl - getHari(bln, thn))
					thnakhir = (1 + thn)
					blnakhir = (bln + 1) - 12
				}
			} else if (tgl > getHari(bln, thn)) {
				if (tgl > 9) {
					tglakhr = (tgl - getHari(bln, thn))
					blnakhir = bln + 1
					thnakhir = thn
				} else {
					tglakhr = '0' + (tgl - getHari(bln, thn))
					blnakhir = bln + 1
					thnakhir = thn
				}
			} else {
				if (tgl > 9) {
					tglakhr = tgl
					blnakhir = bln
					thnakhir = thn
				} else {
					tglakhr = '0' + tgl
					blnakhir = bln
					thnakhir = thn
				}
			}
			return tglakhr
		}

		function converterbln(tgl, bln, thn) {
			var tglakhr = 0
			var blnakhir = 0
			var thnakhir = 0
			if (bln > 11 && bln == 12 && tgl > getHari(bln, thn)) {
				if (bln > 9) {
					tglakhr = (tgl - getHari(bln, thn))
					thnakhir = (1 + thn)
					blnakhir = (bln + 1) - 12
				} else {
					tglakhr = (tgl - getHari(bln, thn))
					thnakhir = '0' + (1 + thn)
					blnakhir = (bln + 1) - 12
				}
			} else if (tgl > getHari(bln, thn)) {
				if (bln > 9) {
					tglakhr = (tgl - getHari(bln, thn))
					blnakhir = bln + 1
					thnakhir = thn
				} else {
					tglakhr = '0' + (tgl - getHari(bln, thn))
					blnakhir = bln + 1
					thnakhir = thn
				}
			} else {
				if (bln > 9) {
					tglakhr = tgl
					blnakhir = bln
					thnakhir = thn
				} else {
					tglakhr = tgl
					blnakhir = '0' + bln
					thnakhir = thn
				}
			}
			return blnakhir
		}

		function converterthn(tgl, bln, thn) {
			var tglakhr = 0
			var blnakhir = 0
			var thnakhir = 0

			if (bln > 11 && bln == 12 && tgl > getHari(bln, thn)) {
				tglakhr = (tgl - getHari(bln, thn))
				thnakhir = (1 + thn)
				blnakhir = (bln + 1) - 12
			} else if (tgl > getHari(bln, thn)) {
				tglakhr = (tgl - getHari(bln, thn))
				blnakhir = bln + 1
				thnakhir = thn
			} else {
				tglakhr = tgl
				blnakhir = bln
				thnakhir = thn
			}
			return thnakhir
		}

		function converthari(day) {
			var hari = ""
			switch (day) {
				case 1:
					hari = "Senin"
					break;
				case 2:
					hari = "Selasa"
					break;
				case 3:
					hari = "Rabu"
					break;
				case 4:
					hari = "Kamis"
					break;
				case 5:
					hari = "Jumat"
					break;
				case 6:
					hari = "Sabtu"
					break;
				case 7:
					hari = "Minggu"
					break;
			}
			return hari
		}
	</script>
</body>

</html>
