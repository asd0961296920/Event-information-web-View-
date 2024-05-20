<!DOCTYPE html>
<html lang="zh-TW">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="icon" href="https://twgather.techscomet.com/favicon.ico">

    <title>{{$apiData->title}} - {{$title}}</title>

    <meta property="og:title" content="{{$apiData->title}} - {{$title}}">
    <meta property="og:description" content="{{$apiData->post_text}}">
    <meta property="og:image" content="{{$apiData->imager1}}">
    <meta property="og:url" content="{{$url}}">
    <meta property="og:type" content="{{$apiData->title}}">







    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4432211278992168"
     crossorigin="anonymous"></script>
  </head>
  <body>



  <script>
    $(document).ready(function() {

      $('#search').on('click', function() {

                var value =$('#searchinput').val();
                var currentUrl = window.location.href;
                var url = new URL(currentUrl);

                window.location.href = url.origin +"{{ env('HOME_URL') }}"+ "?keyword=" + value;
      });

    });
  </script>









    <div id="app">
    <div>

    <!-- 導航欄位 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ env('HOME_URL') }}">旅歷台灣</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

    @foreach ($islands as $island)
      <li class="nav-item">
      <a class="nav-link" href="{{ url('/city/' . $island->id) }}">{{ $island->city }}</a>
        </li>
    @endforeach


      </ul>
      <div class="d-flex">
        <input class="form-control me-2" id="searchinput" type="search" placeholder="請輸入關鍵字" aria-label="Search" id="search">
        <button class="btn btn-outline-success" type="button" id="search">查詢</button>
      </div>
    </div>
  </div>
</nav>
<!-- 導航欄位 -->







<div class="container">
    <div class="row">

    <div class="col">
<!-- 廣告欄位 -->

{!! $js->js3 !!}



    </div>
  </div>
  <div class="row">

    <div class="col-10">


        @if(isset($apiData))
      <h2>{{ $apiData->title }}</h2>

      @if(!is_null($apiData->imager1))
        <img src="{{ $apiData->imager1 }}" alt="{{ $apiData->title }}">
      @endif

      <div>{!! nl2br(e(preg_replace("/\n(\s*\n)+/", "\n", $apiData->post_text))) !!}</div>
    @endif

    </div>
        <div class="col">
<!-- 廣告欄位 -->
{!! $js->js2 !!}
    </div>
  </div>
</div>







  </div>

    </div>
    <!-- built files will be auto injected -->
  </body>
</html>
