@extends('yonetim.layouts.master')
@section('title','Siparis Yönetimi')
@section('content')
    <h1 class="page-header"> Sipariş Yönetimi</h1>

    <h3 class="sub-header"> Sipariş Listesi</h3>
    <div class="well">

        <form action="{{ route('yonetim.siparis') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ad Soyad,Banka ara..." value="{{ old('aranan') }}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{ route('yonetim.siparis') }}" class="btn btn-primary">Temizle</a>
        </form>
    </div>

    @include('layouts.partials.alert_mesaj')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Kullanıcı</th>
                <th>Sipariş Kodu</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Sipariş Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="6" class="text-center">Kullanıcı Bulunamadı.</td></tr>
            @endif
            @foreach($list as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->sepet->kullanici->adsoyad }}</td>
                    <td>SP-{{ $entry->id }}</td>
                    <td>{{ $entry->siparis_tutari * ((100 + config('cart.tax')) / 100) }} TL</td>
                    <td>{{ $entry->durum }}</td>
                    <td>{{ $entry->olusturulma_tarihi }}</td>
                    <td style="width: 100px">
                        <a href="{{ route('yonetim.siparis.duzenle',$entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{ route('yonetim.siparis.sil',$entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Kullanıcıyı Silmek İstediğinize emin misiniz? Bu işlem geri alınamaz.')">
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $list->appends('aranan',old('aranan'))->links('pagination::bootstrap-4') }}
    </div>

@endsection
