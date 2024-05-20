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

    <title>{{$city}}最新活動資訊 - {{$title}}</title>

    <meta property="og:title" content="{{$city}}最新活動資訊 - {{$title}}">
    <meta property="og:description" content="{{$city}}最新活動資訊 - {{$title}}">
    <meta property="og:image" content="https://twgather.techscomet.com/cc.jpg">
    <meta property="og:url" content="{{$url}}">
    <meta property="og:type" content="{{$city}}最新活動資訊">







    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4432211278992168"
     crossorigin="anonymous"></script>
  </head>
  <body>



  <script>
    $(document).ready(function() {
    // 获取 URL 中的 moth 参数值
    const urlParams = new URLSearchParams(window.location.search);
    const mothValue = urlParams.get('moth');

    if (mothValue !== null) {
        // 遍历 select 元素的选项
        $('#month option').each(function() {
            if ($(this).val() === mothValue) {
                // 设置与 moth 相同的选项为 selected
                $(this).prop('selected', true);
            }
        });
    }
        // 获取 URL 中的 moth 参数值
        const urlParams2 = new URLSearchParams(window.location.search);
    const mothValue2 = urlParams2.get('year');

    if (mothValue !== null) {
        // 遍历 select 元素的选项
        $('#year option').each(function() {
            if ($(this).val() === mothValue2) {
                // 设置与 moth 相同的选项为 selected
                $(this).prop('selected', true);
            }
        });
    }
    function getQueryParam(param) {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }
            const keyword = getQueryParam('keyword');
            $('#searchinput').val(keyword);


      $('#year').change(function() {
        var selectedValue = $(this).val();
        var select1Value = $('#month').val();
        var select2Value = $('#search').val();
        var url = $(location).attr('origin') + window.location.pathname+ "?year=" + selectedValue+ "&moth="+select1Value;
        var search = getQueryParam('keyword');
        if(search !==null && search !== ""){
          url = url+"&keyword="+search
        }

        window.location.href = url;
      });
      $('#month').change(function() {
        var selectedValue = $(this).val();
        var select1Value = $('#year').val();
        var select2Value = $('#search').val();
        var url =  $(location).attr('origin') + window.location.pathname + "?year=" + select1Value+ "&moth="+selectedValue;
        var search = getQueryParam('keyword');
        if(search !==null && search !== ""){
          url = url+"&keyword="+search
        }
        window.location.href = url;

      });

      $('.myButton').on('click', function() {
        var selectedValue = $('#month').val();
        var select1Value = $('#year').val();
        var select2Value = $('#search').val();
                var value = $(this).val();
                var url =  $(location).attr('origin') + window.location.pathname+ "?year=" + select1Value+ "&moth="+selectedValue+ "&page="+value;
                var search = getQueryParam('keyword');
                if(search !==null && search !== ""){
                  url = url+"&keyword="+search
                }


                window.location.href = url;
      });

      $('#search').on('click', function() {

                var value =$('#searchinput').val();


                window.location.href = $(location).attr('origin') + window.location.pathname + "?keyword=" + value;
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

    <div class="container-fluid">
      <div class="row mt-3">
        <div class="col">
<!-- 廣告欄位 -->
{!! $js->js1 !!}
        
<!-- 廣告欄位 -->
        </div>
      </div>
      <div class="row mt-3 mx-4">
        <div class="col">
<!-- 列表欄位 -->
            <!-- 搜尋欄位 -->
<div class="container">
  <div class="row">
    <div class="col">


      <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="year">
        <option selected value=null >請選擇年份</option>
        @foreach ($yearsArray as $yearsArrays)
        <option value="{{$yearsArrays}}">{{$yearsArrays}}</option>
        @endforeach
      </select>

    </div>
    <div class="col">

    <select class="form-select form-select-sm" aria-label=".form-select-sm example"  id="month">
      <option selected  value=null >請選擇月份</option>
      <option value=1>一月</option>
      <option value=2>二月</option>
      <option value=3>三月</option>
        <option value=4>四月</option>
      <option value=5>五月</option>
      <option value=6>六月</option>
        <option value=7>七月</option>
      <option value=8>八月</option>
      <option value=9>九月</option>
        <option value=10>十月</option>
      <option value=11>十一月</option>
      <option value=12>十二月</option>
    </select>


    </div>

  </div>
</div>
 <!-- 搜尋欄位 -->
  <!-- 表格欄位 -->
<table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">地區</th>
          <th scope="col">文章標題</th>
          <th scope="col">活動日期</th>
          <th scope="col">活動連結</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($apiDatas->posts->data as $apiData)
        <tr>
          <th scope="row">{{ $apiData->area->city }}</th>
          <td><a class="page-link" href="{{ url('/page/' . $apiData->id) }}" >{{ $apiData->title }}</a></td>
          <td>{{$apiData->event_date}}</td>
          <td><a href="{{$apiData->post_url}}" target="_blank"><button type="button" class="btn btn-outline-info">點我</button></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  <!-- 表格欄位 -->


  <!-- 分頁欄位 -->  
<div class="container">
  <div class="row">
    <div class="col">

    </div>
    <div class="col">
<nav aria-label="Page navigation example">







      <ul class="pagination">
            @php
                $currentPage = $apiDatas->currentPage;
                $totalPages = $apiDatas->totalPages;
                $startPage = max(1, $currentPage - 4);
                $endPage = min($totalPages, $currentPage + 5);

                // 调整endPage以保证最多显示10页
                if ($endPage - $startPage < 9) {
                    $endPage = min($totalPages, $startPage + 9);
                }
            @endphp


            
            <!-- Previous Page Link -->
            @if ($currentPage > 1)
            <li class="page-item">
      <Button class="page-link myButton" value="1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </Button>
    </li>
    <li class="page-item">
      <Button class="page-link myButton" value="{{ $currentPage > 1 ? $currentPage - 1 : 1 }}" aria-label="Previous">
        <span aria-hidden="true"> &lt; </span>
      </Button>
    </li>
            @endif


            

            @for ($i = $startPage; $i <= $endPage; $i++)
                @if ($i == $currentPage)
                    <li class="page-item active" aria-current="page">
                        <Button class="page-link myButton" value="{{ $i }}" >{{ $i }}</Button>
                    </li>
                @else
                    <li class="page-item">
                        <Button class="page-link myButton" value="{{ $i }}" >{{ $i }}</Button>
                    </li>
                @endif
            @endfor


            <!-- Next Page Link -->
            @if ($currentPage < $totalPages)
            <li class="page-item">
            <Button class="page-link myButton" value="{{ $currentPage+1 }}" aria-label="Next" >
              <span aria-hidden="true"> &gt; </span>
            </Button>
            </li>    
            <li class="page-item">
                    <Button class="page-link myButton" value="{{ $totalPages }}"  aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </Button>
                </li>
            @endif
        </ul>





  </ul>
</nav>

    </div>
    <div class="col">

    </div>
  </div>
</div>
        
  <!-- 分頁欄位 -->  
        
<!-- 列表欄位 -->        
        </div>
        <div class="row">
        <div class="col-md-auto">
          <!-- 廣告欄位 -->
          {!! $js->js3 !!}

        
        
        <!-- 廣告欄位 -->
        </div>
        </div>
      </div>
    </div>




  </div>

    </div>
    <!-- built files will be auto injected -->
  </body>
</html>
