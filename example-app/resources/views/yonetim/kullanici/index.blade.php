@extends('yonetim.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')
<h1 class="page-header"> Kullanıcı Yönetimi</h1>

<h3 class="sub-header"> Kullanıcı Listesi</h3>
<div class="well">
    <div class="btn-group pull-right" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary">Print</button>
        <a href="{{ route('yonetim.kullanici.yeni') }}" class="btn btn-primary">Yeni</a>
    </div>
    <form action="{{ route('yonetim.kullanici') }}" method="post" class="form-inline">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ad,Email ara..." value="{{ old('aranan') }}">
            </div>
        <button type="submit" class="btn btn-primary">Ara</button>
        <a href="{{ route('yonetim.kullanici') }}" class="btn btn-primary">Temizle</a>
    </form>
</div>

@include('layouts.partials.alert_mesaj')
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Kullanıcı</th>
            <th>Email</th>
            <th>Aktif Mi?</th>
            <th>Yönetici Mi?</th>
            <th>Kayıt Tarihi</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if(count($list)==0)
            <tr><td colspan="7" class="text-center">Kullanıcı Bulunamadı.</td></tr>
        @endif
        @foreach($list as $entry)
        <tr>
            <td>{{ $entry->id }}</td>
            <td>{{ $entry->adsoyad }}</td>
            <td>{{ $entry->email }}</td>
            <td>
                @if($entry->aktif_mi)
                    <span class="label label-success">Aktif</span>
                @else
                    <span class="label label-danger">Pasif</span>
                @endif
            </td>
            <td>@if($entry->yonetici_mi)
                    <span class="label label-success">Yönetici</span>
                @else
                    <span class="label label-danger">Müşteri</span>
                @endif</td>
            <td>{{ $entry->olusturulma_tarihi }}</td>
            <td style="width: 100px">
                <a href="{{ route('yonetim.kullanici.duzenle',$entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                    <span class="fa fa-pencil"></span>
                </a>
                <a href="{{ route('yonetim.kullanici.sil',$entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Kullanıcıyı Silmek İstediğinize emin misiniz? Bu işlem geri alınamaz.')">
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
