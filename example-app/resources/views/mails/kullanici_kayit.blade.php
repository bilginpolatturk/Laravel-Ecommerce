<h1>{{ config('app.name') }}</h1>
<p>Merhaba {{ $kullanici->adsoyad }}, Kaydınız başarılı bir şekilde yapıldı.</p>
<p>Kaydınızı aktifleştirmek için <a href="{{ config('app.url') }}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari }}">tıklayınız.</a>veya aşağıdaki bağlantıyı tarayıcınızda açınız.</p>
<p>{{ config('app.url') }}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari }}</p>
