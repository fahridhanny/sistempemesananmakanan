@extends('index')

@section('content')
		<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Keranjang Pesanan</h1>
                    </div>
                    <hr>

                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Menu</th>
                          <th scope="col">Harga</th>
                          <th scope="col">Jumlah</th>
                          <th scope="col">Jumlah Harga</th>
                          <th scope="col">Hapus</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pesanan_detail as $no => $data)
                        <tr>
                          <th scope="row">{{ $no+=1 }}</th>
                          <td>{{ $data->nama_menu }}</td>
                          <td>Rp. {{ number_format($data->harga) }}</td>
                          <td>{{ $data->jumlah }}</td>
                          <td>Rp. {{ number_format($data->jumlah_harga) }}</td>
                          <td><a href="/pesanan/detail/hapus/{{ $data->id_pesanan }}/{{ $data->id_menu }}" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                    <form action="/pesan/{{ $pesanan->id }}" method="POST">
                      @csrf
                      <table>
                        <tbody>
                          <tr>
                            <td>No. Pesanan</td>
                            <td class="pl-3"><input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $pesanan->no_pesanan }}" name="no_pesanan" readonly></td>
                          </tr>
                          <tr>
                            <td>No. Meja</td>
                            <td class="pl-3"><input type="number" class="form-control @error('no_meja') is-invalid @enderror" id="exampleInputPassword1" name="no_meja">

                              @error('no_meja')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </td>
                          </tr>
                          <tr>
                            <td>Atas Nama</td>
                            <td class="pl-3"><input type="text" class="form-control @error('atas_nama') is-invalid @enderror" id="exampleInputPassword1" name="atas_nama">

                              @error('atas_nama')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </td>
                          </tr>
                          <tr>
                            <td>Total Harga :</td>
                            <td class="pl-3"><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                          </tr>
                          <tr>
                            <td class="pt-3"><button type="submit" class="btn btn-primary">Order</button></td>
                          </tr>
                        </tbody>  
                      </table>
                    </form>
                </div>
@endsection