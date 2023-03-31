@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1 class="page-header"> Ürün Yönetimi</h1>

    <h3 class="sub-header"> Ürün Listesi</h3>
    <div class="well">
        <div class="btn-group pull-right" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary">Print</button>
            <a href="{{ route('yonetim.urun.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.urun') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ürün Adı,Açıklama ara..." value="{{ old('aranan') }}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{ route('yonetim.urun') }}" class="btn btn-primary">Temizle</a>
        </form>
    </div>

    @include('layouts.partials.alert_mesaj')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ürün</th>
                <th>Slug</th>
                <th>Ürün Adı</th>
                <th>Fiyatı</th>
                <th>Kayıt Tarihi</th>
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
                    <td><img src="{{ $entry->detay->urun_resmi != null ?
                                asset('uploads/urunler/' . $entry->detay->urun_resmi) :
                                  'http://via.placeholder.com/400x400?text=UrunResmi'}}" class="img-responsive" style="width: 150px; height: 150px;"></td>
                    <td>{{ $entry->slug }}</td>
                    <td>{{ $entry->urun_adi }}</td>
                    <td>{{ $entry->fiyati }}</td>
                    <td>{{ $entry->olusturulma_tarihi }}</td>
                    <td style="width: 100px">
                        <a href="{{ route('yonetim.urun.duzenle',$entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{ route('yonetim.urun.sil',$entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Kullanıcıyı Silmek İstediğinize emin misiniz? Bu işlem geri alınamaz.')">
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
