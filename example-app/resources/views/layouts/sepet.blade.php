@extends('layouts.master')
@section('title','Sepet')
@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Sepet</h2>
            @include('layouts.partials.alert_mesaj')
            @if(count(Cart::content())>0)
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Adet Fiyatı</th>
                    <th>Adet</th>
                    <th>Tutar</th>
                </tr>
                <tr>
                    <td colspan="5">Henüz sepette ürün yok</td>
                </tr>
                @foreach(Cart::content() as $urunCartItem)
                <tr>
                    <td style="width: 120px;">
                        <img src="http://lorempixel.com/120/100/food/2"></td>
                    <td><a href="{{ route('urun' , Str::slug($urunCartItem->options->slug)) }}">{{ $urunCartItem->name }}</a>
                        <form action="{{ route('sepet.kaldir',$urunCartItem->rowId) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="submit" class="btn btn-danger btn-xs" value="Sepetten Kaldır">

                        </form>

                    </td>
                    <td>{{ $urunCartItem->price }}</td>
                    <td>
                        <a href="#" class="btn btn-xs btn-default urun-adet-azalt" data-id="{{ $urunCartItem->rowId }}"
                         data-adet = "{{ $urunCartItem->qty-1 }}">-</a>
                        <span style="padding: 10px 20px">{{ $urunCartItem->qty }}</span>
                        <a href="#" class="btn btn-xs btn-default urun-adet-arttir"  data-id="{{ $urunCartItem->rowId }}"
                           data-adet = "{{ $urunCartItem->qty+1 }}" >+</a>

                    </td>
    <td>{{ $urunCartItem->rowId }}</td>
                    <td class="text-right">
                      {{ $urunCartItem->subtotal }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="4" class="text-right">Alt Toplam</th>
                    <td class="text-right">{{ Cart::subtotal() }}</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Kdv</th>
                    <td class="text-right">{{ Cart::tax() }}</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Genel Toplam</th>
                    <td class="text-right">{{ Cart::total() }}</td>
                </tr>
            </table>

                <form action="{{ route('sepet.bosalt') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="submit" class="btn btn-danger btn-xs" value="Sepeti Boşalt">
                </form>
                <a href="{{ route('odeme') }}" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
            @else
                <div class="text-center">
                    <img style="padding-left:25px"  src="https://bi-eticaret.com/images/sepet-bos.png" class="img-fluid" alt="Boş Sepet">
                    <button class="btn btn-theme"><a class="btn btn-theme" href="{{ route('anasayfa') }}">ALIŞVERİŞE BAŞLA</a></button>
                </div>
            @endif


        </div>
    </div>
@endsection

@section('footer')

    <script>
        $(function(){
            $('.urun-adet-arttir, .urun-adet-azalt').on('click', function (){
                var id = $(this).attr('data-id');
                var adet = $(this).attr('data-adet');
                $.ajax({
                    type: "PATCH",
                    url: "{{ url('sepet/guncelle') }}/"+ id,
                    data: { adet: adet},
                    success: function (){
                        window.location.href = "{{ route('sepet') }}";
                    }
                });


            });


        });
    </script>

@endsection

