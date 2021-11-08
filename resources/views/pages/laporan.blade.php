<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row justify-content-between mt-3">
          <div class="col">
          	{{ date('d-m-Y'); }}
          </div>
          <div class="col">
          	<h3>Laporan Sudah Dibayar</h3>
          </div>
          <div class="col">
          </div>
	    </div>
		<div class="row justify-content-md-center">
	      <div class="col mt-4">
			<table class="table">
		      <thead>
			    <tr>
				  <th>No. Pesanan</th>
				  <th>No. Meja</th>
				  <th>Atas Nama</th>
				  <th>Total Harga</th>
				  <th>Status</th>
			    </tr>
		      </thead>
		      <tbody>
			    @foreach($pesanan as $no => $data)
			    <tr>
				  <td>{{ $data->no_pesanan }}</td>
				  <td>{{ $data->no_meja }}</td>
				  <td>{{ $data->atas_nama }}</td>
				  <td>{{ $data->total_harga }}</td>
				  <td>{{ $data->status }}</td>
			    </tr>
			    @endforeach
		      </tbody>
	        </table>
	      </div>
		</div>
		<div class="row justify-content-start mt-4">
			<div class="col">
				<strong>Nama :</strong> {{ auth()->user()->name }}
			</div>
		</div>
		<div class="row justify-content-start mt-4">
			<div class="col">
				<strong>Bagian :</strong> {{ auth()->user()->hak_akses }}
			</div>
		</div>
	</div>
</body>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>
<script>
 	window.addEventListener("load",window.print());
</script>
</html>