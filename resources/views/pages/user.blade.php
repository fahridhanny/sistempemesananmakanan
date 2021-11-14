@extends('index')

@section('content')
		<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">User</h1>
                        <a href="/laporan/dibayar" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan</a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User</h6>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between mb-2">
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahUser"><i class="fas fa-plus"></i> Tambah User</button>
                                </div>
                                <div class="col-4">
                                    <div class="form-inline my-2 my-lg-0">
                                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" id="search">
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Hak Akses</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $no => $data)
                                        <tr>
                                            <td>{{ $users->firstItem()+$no }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->hak_akses }}</td>
                                            <td>{{ $data->status }}</td>
                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUser-{{ $data->id }}"><i class="fas fa-edit"></i></button></td>
                                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusUser-{{ $data->id }}"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($users as $no => $data)
                <!-- Modal Hapus User-->
                <div class="modal fade" id="hapusUser-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Yakin ingin menghapus User bernama <strong>{{ $data->name }}</strong> ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="/hapus/user/{{ $data->id }}" class="btn btn-primary">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                @foreach($users as $no => $data)
                <!-- Modal Edit User-->
                <div class="modal fade" id="editUser-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="edit/user" method="POST">
                      <div class="modal-body">
                        @csrf
                            <div class="form-group">
                                <input type="text" value="{{ $data->name }}" class="form-control" placeholder="Nama" name="name">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{ $data->email }}" class="form-control" placeholder="Email" name="email">
                            </div>
                            <div class="form-group">
                                <select name="hak_akses" id="" class="form-control">
                                    <option value="">--- Pilih Hak Akses ---</option>
                                    <option value="kasir" @if ($data->hak_akses == "kasir") selected @endif>Kasir</option>
                                    <option value="pelayan" @if ($data->hak_akses == "pelayan") selected @endif>Pelayan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="status" id="" class="form-control">
                                    <option value="">--- Pilih Status ---</option>
                                    <option value="Belum Aktif" @if ($data->status == "Belum Aktif") selected @endif>Belum Aktif</option>
                                    <option value="Aktif" @if ($data->status == "Aktif") selected @endif>Aktif</option>
                                </select>
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

                <!-- Modal Tambah User-->
                <div class="modal fade" id="tambahUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="tambah/user" method="POST">
                      <div class="modal-body">
                        @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Nama" name="name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="email">
                            </div>
                            <div class="form-group">
                                <select name="hak_akses" id="" class="form-control">
                                    <option value="">--- Pilih Hak Akses ---</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="pelayan">Pelayan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="status" id="" class="form-control">
                                    <option value="">--- Pilih Status ---</option>
                                    <option value="Belum Aktif">Belum Aktif</option>
                                    <option value="Aktif">Aktif</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
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
                    url: "/searchUser",
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