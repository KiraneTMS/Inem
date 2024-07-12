@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-end">
        <div class="col-8 breadcrumbs">
            <p> <a href="/"><i class="fa fa-home"></i>home/</a> penghasilan</p>
            <h3>Lihat Penghasilan</h3>
        </div>
        
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3 small-box-brown small-box-in mb-4 mr-2">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <p>Total Penghasilan</p>
                    <h3>Rp{{ $total[0]->total }}</h3>
                </div>
                <div class="icon col-auto pt-5">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 small-box-orange small-box-in mb-4 mr-2">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <p>Penghasilan Shopee</p>
                    <h3>{{ $total_shopee[0]->total_shopee }}</h3>
                </div>
                <div class="icon col-auto pt-5">
                    <img src="backend/img/shopee.png" alt="" style="width: 50px">
                </div>
            </div>
        </div>
        <div class="col-lg-3 small-box-green small-box-in mb-4 mr-2">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <p>Penghasilan Tokopedia</p>
                    <h3>{{ $total_tokopedia[0]->total_tokopedia }}</h3>
                </div>
                <div class="icon col-auto pt-5">
                    <img src="backend/img/tokopedia.png" alt="" style="width: 50px">
                </div>
            </div>
        </div>
        
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>E-Commerce</th>
                            <th>Pendapatan</th>
                            <th>Pengeluaran</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->ecommerce }}</td>
                            <td>{{ $transaksi->pendapatan}}</td>
                            <td>{{ $transaksi->pengeluaran}}</td>
                            <td>{{ $transaksi->pendapatan - $transaksi->pengeluaran}}</td>
                            
                        </tr>
                        
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">{{ __('Data Empty') }}</td>
                        </tr>
                        @endforelse
                        <tr>
                            <td colspan="3">total</td>
                            <td>{{ $total[0]->total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection