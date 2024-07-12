@extends('layouts.admin')

@section('content')
<div class="container-fluid">
<!-- Content Row -->
    <div class="row">
        @if (auth()->user()->level == 1)
        <!-- Earnings (Monthly) Card Example -->
        <div class="row">
                        <div class="col-6">
<div class="row">
    <div class="card">
        <h3>
            Hallo, Admin!
        </h3>
        <p>
            Selamat Datang di Inem, Software integrator e-commerce menggunakan Robotic Process Automation
        </p>
        <div class="small-box-brown small-box-in py-2">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <p>Total User</p>
                    <h3 class="">{{ $users }}</h3>
                </div>
                <div class="icon col-auto pt-5">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="small-box-green small-box-in py-2 mt-3">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <p>Total Admin</p>
                    <h3 class="">1</h3>
                </div>
                <div class="icon col-auto pt-5">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </div>
</div>
    
                        </div>
                            <div class="col-6">
                                <div class="card p-5">
                                    <img src="backend/img/ilustrasi-1.png" alt="" style="width: auto;" >
                                </div>
                                
                            </div>
        </div>
        @else
        <!-- Earnings (Monthly) Card Example -->
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="big-box">
                    <div class="row">
                        <div class="col-7">
                            <h5>Kelola E-Commerce mu dengan</h5>
                            <h3>Inem</h3>
                            <p>Integrator e-commerce menggunakan Robotic Process Automation</p>
                        </div>
                        <div class="col-5">
                            <img src="backend/img/ilustrasi-1.png" alt="" style="width: 160px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 mt-4">
                            <div class="small-box-green small-box-in py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <p>Total</p>
                                        <p>Produk</p>
                                        <h3 class="">{{ $products }}</h3>
                                    </div>
                                    <div class="icon col-auto pt-5">
                                        <i class="fas fa-box"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 mt-4">
                            <div class="small-box-orange small-box-in py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <p>Transaksi shopee</p>
                                        <h3 class="">{{ $transaksi_shopee[0]->transaksi_shopee}}</h3>
                                    </div>
                                    <div class="icon col-auto pt-5">
                                        <img src="backend/img/shopee.png" alt="" style="width: 50px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 mt-4">
                            <div class="small-box-brown small-box-in py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <p>Transaksi Tokopedia</p>
                                        <h3 class="">{{ $transaksi_tokopedia[0]->transaksi_tokopedia}}</h3>
                                    </div>
                                    <div class="icon col-auto pt-5">
                                        <img src="backend/img/tokopedia.png" alt="" style="width: 50px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-lg-6 col-md-3 mb-4">
                        <div class="small-box py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <p>Total Pendapatan</p>
                                        <h3 class="">Rp{{ $pendapatan[0]->pendapatan }}</h3>
                                    </div>
                                    <div class="icon col-auto pt-5">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 mb-4">
                        <div class="small-box py-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <p>Total Pengeluaran</p>
                                        <h3 style="color:#FF9933">Rp{{$pengeluaran[0]->pengeluaran}}</h3>
                                    </div>
                                    <div class="icon col-auto pt-5 icon-down">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col pl-4">
                <div class="row mb-4">
                    <div class="card">
                        <h4>Overview</h4>
                        <img src="backend/img/chart.png" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 card">
                        <h5>Pintasan</h5>
                        <hr>
                        <div class="row  align-items-center">
                            <div class="col-6">
                                <p>Impor Data Transaksi</p>
                            </div>
                            <div class="col text-right">
                                <button type="button" class="btn btn-add" data-toggle="modal" data-target="#import">
                                    Import Data
                                   </button>
                                   
                                   <!-- Modal -->
                                   <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="importTitle" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content">
                                         <div class="modal-header">
                                           <h5 class="modal-title" id="exampleModalLongTitle">Import Data Excel</h5>
                                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                           </button>
                                         </div>
                                         <div class="modal-body">
                                             <form action="{{ route('transaksis.import') }}" method="POST" enctype="multipart/form-data">
                                                 @csrf
                                                 <div class="form-group">
                                                     <label for="file">Pilih file Excel:</label>
                                                     <input type="file" name="file" id="file" accept=".xls,.xlsx">
                                                     @error('file')
                                                         <span class="text-danger">{{ $message }}</span>
                                                     @enderror
                                                     <button type="submit" class="btn btn-add">Impor</button>
                                                 </div>
                                                
                                             </form>
                                         </div>
                                         <div class="modal-footer">
                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                           
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p>Cetak Laporan</p>
                            </div>
                            <div class="col text-right">
                                <form action="{{ route('laporan.export') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="dari" id="exportDari"
                                        value="{{ isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-d') }}">
                                    <input type="hidden" name="ke" id="exportKe"
                                        value="{{ isset($_GET['ke']) ? $_GET['ke'] : date('Y-m-d') }}">
                                    <button class="btn btn-add" type="submit">Cetak PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col"></div>
                    <div class="col-3 small-box-green-1">
                        <h5 class="text-white">Pusat Bantuan</h5>
                        <div class="call">
                            <a href="https://wa.me/6285759869871"> <img src="backend/img/whatsapp.png" alt=""></a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>

</div>
@endsection
