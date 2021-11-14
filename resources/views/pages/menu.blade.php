@extends('index')

@section('content')
		<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Menu</h1>
                        <a href="/laporan/dibayar" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan</a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Menu</h6>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between mb-2">
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahMenu"><i class="fas fa-plus"></i> Tambah Menu</button>
                                </div>
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
                                            <th>Nama Menu</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Gambar</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($menus as $no => $data)
                                        <tr>
                                            <td>{{ $menus->firstItem()+$no }}</td>
                                            <td>{{ $data->nama_menu }}</td>
                                            <td>Rp. {{ number_format($data->harga) }}</td>
                                            <td>{{ $data->stok }}</td>
                                            <td><img src="{{ url('assets/img/menu/'.$data->gambar) }}" alt="{{ $data->nama_menu }}" height="80" width="85"></td>
                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editMenu-{{ $data->id }}"><i class="fas fa-edit"></i></button></td>
                                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusMenu-{{ $data->id }}"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $menus->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($menus as $no => $data)
                <!-- Modal Hapus Menu-->
                <div class="modal fade" id="hapusMenu-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Yakin ingin menghapus menu <strong>{{ $data->nama_menu }}</strong> ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="/hapus/menu/{{ $data->id }}" class="btn btn-primary">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                @foreach($menus as $no => $data)
                <!-- Modal Edit Menu-->
                <div class="modal fade" id="editMenu-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="edit/menu" method="POST" enctype="multipart/form-data">
                      <div class="modal-body">
                        @csrf
                            <div class="form-group">
                                <select name="id_kategori" id="" class="form-control">
                                    <option value="">--- Pilih Kategori ---</option>
                                    @foreach ($kategori as $value)
                                        <option value="{{ $value->id }}" @if ($data->id_kategori == $value->id)   
                                        selected @endif>{{ $value->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" value="{{ $data->nama_menu }}" class="form-control" placeholder="Nama Menu" name="nama_menu">
                            </div>
                            <div class="form-group">
                                <input type="number" value="{{ $data->harga }}" class="form-control" placeholder="Harga" name="harga" min="0">
                            </div>
                            <div class="form-group">
                                <input type="number" value="{{ $data->stok }}" class="form-control" placeholder="Stok" name="stok" min="0">
                            </div>
                            <div class="form-group">
                                <img src="{{ url('assets/img/menu/'.$data->gambar) }}" alt="" width="150" height="110">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="gambar">
                            </div>
                            <input type="hidden" value="{{ $data->id }}" class="form-control" name="id">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Ubah</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach

                <div class="modal fade" id="tambahMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="tambah/menu" method="POST" enctype="multipart/form-data">
                      <div class="modal-body">
                        @csrf
                            <div class="form-group">
                                <select name="id_kategori" id="" class="form-control">
                                    <option value="">--- Pilih Kategori ---</option>
                                    @foreach ($kategori as $value)
                                        <option value="{{ $value->id }}">{{ $value->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Nama Menu" name="nama_menu">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Harga" name="harga" min="0">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Stok" name="stok" min="0">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="gambar">
                            </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
        <script type="text/javascript">
            function search(){
                var query = $('#search').val();
                $.ajax({
                    url: "/searchMenu",
                    type: "GET",
                    data: {'search':query},
                    success:function(data){
                        $('#table1').hide();
                        $('#table2').html(data);
                    }
                })
            }
        </script>
@endsection