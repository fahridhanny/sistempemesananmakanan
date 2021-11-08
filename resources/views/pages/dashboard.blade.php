@extends('index')

@section('content')
		<div class="container-fluid">        
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            @if(Auth()->user()->hak_akses == "pelayan")
                                Selamat Datang Pelayan!
                            @elseif(Auth()->user()->hak_akses == "kasir")
                                Selamat Datang Kasir!
                            @endif
                        </h1>
                    </div>
                </div>
@endsection