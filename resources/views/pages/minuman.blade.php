@extends('index')

@section('content')
		<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Minuman</h1>
                    </div>
                    <hr>

                    <div class="row">
                        @foreach($minuman as $no => $data)
                        <div class="col-3 mb-4">
                            <div class="card">
                            <form action="/keranjang/pesanan/{{ $data->id }}" method="POST">
                              @csrf
                              <img class="card-img-top" src="{{ url('assets/img/menu/'.$data->gambar) }}" alt="{{ $data->nama_menu }}" style="height: 185px;">
                              <div class="card-body">
                                <h5 class="card-title">{{ $data->nama_menu }}</h5>
                                <p class="card-text"><strong>Rp. {{ number_format($data->harga) }}</strong></p>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Jumlah" name="jumlah">
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Pesan</button>
                                    </div>
                                    <div class="col">
                                      @if($data->stok <= 0)
                                        <span class="badge badge-danger p-2">Sudah Habis</span>
                                      @else
                                        <span class="badge badge-success p-2">Porsi: {{ $data->stok }}</span>
                                      @endif
                                    </div>
                                </div>
                              </div>
                            </form>
                            </div>  
                        </div>
                        @endforeach
                    </div>
                </div>
@endsection