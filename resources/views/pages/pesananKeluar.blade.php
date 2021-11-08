@extends('index')

@section('content')
		<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Pesanan Sudah Dibayar</h1>
                        <a href="/laporan/dibayar" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan</a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pesanan Sudah Dibayar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between mb-2">
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="form-inline my-2 my-lg-0">
                                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" id="search">
                                        <div id="search2"></div>
                                        <button class="btn btn-success my-2 my-sm-0" id="submit" onclick="search()">Search</button>
                                    </div>     
                                </div>   
                            </div>
                            <div class="table-responsive" id="table2">
                            <div class="table-responsive" id="table1">
                                <table class="table table-bordered mt-2" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Pesanan</th>
                                            <th>No Meja</th>
                                            <th>Atas Nama</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                            <th>Cetak</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pesanan as $no => $data)
                                        <tr>
                                            <td>{{ $pesanan->firstItem()+$no }}</td>
                                            <td>{{ $data->no_pesanan }}</td>
                                            <td>{{ $data->no_meja }}</td>
                                            <td>{{ $data->atas_nama }}</td>
                                            <td>Rp. {{ number_format($data->total_harga) }}</td>
                                            <td><span class="badge badge-pill badge-success">{{ $data->status }}</span></td>
                                            <td><a href="/cetak/pembayaran/{{ $data->id }}" class="btn btn-info"><i class="fas fa-print"></i></a></td>
                                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusPesanan-{{ $data->id }}"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $pesanan->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($pesanan as $no => $data)
                <!-- Modal Hapus Pesanan-->
                <div class="modal fade" id="hapusPesanan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Yakin ingin menghapus No. Pesanan <strong>{{ $data->no_pesanan }}</strong> ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="/hapus/pesanan/{{ $data->id }}" class="btn btn-primary">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                <script type="text/javascript">
                    function search(){
                        var query = $('#search').val();
                        $.ajax({
                            url: "/searchDibayar",
                            type: "GET",
                            data: {'search':query},
                            success:function(data){
                                $('#table1').hide();
                                $('#table2').html(data);
                            }
                        });
                    }
                </script>
@endsection