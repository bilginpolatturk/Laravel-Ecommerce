@extends('layouts.master')
@section('title','Siparis Detay')
@section('content')
    <div class="container">
        <div class="bg-content">
            <a href="{{ route('siparisler') }}" class="btn btn-warning btn-xs">
                <i class="glyphicon glyphicon-arrow-left"></i> Siparişlere Dön
            </a>
            <h2>Sipariş (SP-{{ $siparis->id }})</h2>
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Tutar</th>
                    <th>Adet</th>
                    <th>Ara Toplam</th>
                    <th>Durum</th>
                </tr>

                @foreach($siparis->sepet->sepet_urunler as $sepet_urun)
                <tr>
                    <td style="width: 120px;">
                        <a href="{{ route('urun',$sepet_urun->urun->slug) }}">
                            <img src="{{ $sepet_urun->urun->detay->urun_resmi != null ?
                                asset('uploads/urunler/' . $sepet_urun->urun->detay->urun_resmi) :
                                  'http://via.placeholder.com/120x100?text=UrunResmi'}}" style="height: 120px;">
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('urun',$sepet_urun->urun->slug) }}">
                        {{ $sepet_urun->urun->urun_adi }}
                        </a>
                    </td>
                    <td>{{ $sepet_urun->tutar }}</td>
                    <td>{{ $sepet_urun->adet }}</td>
                    <td>{{ $sepet_urun->tutar * $sepet_urun->adet }}</td>
                    <td>
                        {{ $sepet_urun->durum }}
                    </td>
                </tr>
                @endforeach

                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar (KDV Hariç)</th>
                    <td colspan="2">{{ $siparis->siparis_tutari }}</td>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar (KDV Dahil)</th>
                    <td colspan="2">{{ number_format($siparis->siparis_tutari*((100+config('cart.tax'))/100),2) }}</td>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Sipariş Durumu</th>
                    <td colspan="2">{{ $siparis->durum }}</td>
                    <th></th>
                </tr>


            </table>
        </div>
    </div>
@endsection

