
<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">

  <title>ログイン</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <script src="https://kit.fontawesome.com/39ab84bfc8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:400,700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
</head>

<body>
<div id="app">
  <header class="l-header"> 

    <div class="p-header">
        <div class="p-header__logo">
          <a href class="p-topLink">
            <img src="./images/logo.png" style="width: 30px;" alt class="p-topLink__img" />
          </a>
        </div>
        <div class="p-header__search">
          <form action="" class="p-search">
            @csrf
            <input type="text" class="p-search__form">
            <button  type="submit" class="p-search__btn">検索</button>
          </form>
        </div>
        <div class="p-header__menu">
          <button class="p-menuBtn">メニュー</button>
          <div class="p-headerMenu">
            <ul class="p-headerMenu__list">        
              <li class="p-menuItem">マイページ</li>
              <li class="p-menuItem">トップページ</li>
              <li class="p-menuItem">ユーザー登録</li>
              <li class="p-menuItem">
                <form action method="POST">
                  @csrf
                  <button type="submit" class="p-logout c-btn">ログアウト</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      <div class="p-headerMenuTrigger js-toggle-sp-menu">
          <span class="p-headerMenuTrigger__border"></span>
          <span class="p-headerMenuTrigger__border"></span>
          <span class="p-headerMenuTrigger__border"></span>
      </div>
    </div>

    <div class="p-sort">
      <p class="p-categorySearch"><i class="far fa-list-alt"></i>カテゴリーから探す</p>
      <div class="p-category">
        <ul class="p-category__items">
          <li class="p-categoryItem">カテゴリー</li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">勉強</a></li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">ダイエット</a></li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">筋トレ</a></li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">英会話</a></li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">ギター</a></li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">ビジネス</a></li>
          <li class="p-categoryItem"><a href="#" class="p-categoryLink">弁護士</a></li>
        </ul>
      </div>

      <div class="p-favSort">
        <form method="post" action="#" class="p-sortForm">
          <select name="お気に入り" class="p-sortForm__select">
            <option value="1" class="p-selectItem">お気に入り多い順</option>
            <option value="2" class="p-selectItem">お気に入り少ない順</option>
          </select>
          <input type="submit" class="p-searchBtn" placeholder="検索">
        </form>
      </div>
    </div>

  </header>

  <main class="l-main">
<!--ーーーーーーーーーーーーーーーーーー STEP一覧画面表示 ーーーーーーーーーーーーーーーーーー--> 
    <div class="l-bg p-stepList"> 

  
    <div class="p-stepList__container">
    @for($i = 0; $i < 9; $i++)
      <div class="p-step">
        <img src="./images/rika.png" alt="" class="p-step__img">
        
        <div class="p-itemCover">
          <p class="p-itemCover__outline">
            気温や湿度を入力し、最も目覚めの良いアラームを自動で選択し…
          </p>
          <a href="#" class="p-itemCover__link">詳細を見る<i class="fas fa-search-plus p-itemCover__icon"></i></a>
        </div>
          
        <div class="p-step__wrap">
          <div class="p-faceicon">
            <img src="./images/icon.png" style="width: 50px;" alt="" class="p-faceicon__img">
           </div>
          <span class="p-stepTitle">サルでる分かる英語勉強法！</span>
          <span class="p-stepCategory c-category">英会話</span>
          <i class="fas fa-star p-stepFav c-star"></i><span class="p-stepTotal">48</span>
        </div>
      </div>
    @endfor

    </div>

<!--ーーーーーーーーーーーーーーーーーー ページネーション ーーーーーーーーーーーーーーーーーー-->
  <ul class="c-pagenation p-stepListPage">
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" ><</a>
    </li>
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" >1</a>
    </li>
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" >2</a>
    </li>
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" >3</a>
    </li>
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" >4</a>
    </li>
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" >5</a>
    </li>
    <li class="c-pagenation__item">
      <a class="c-pageLink" href="#" >></a>
    </li>
  </ul>

    </div>
  </main>


  <div class="l-footer">
      <ul class="p-footerMenu">
        <li class="p-footerMenu__list">特定商取引法</li>
        <li class="p-footerMenu__list">プライバシーポリシー</li>
        <li class="p-footerMenu__list">Step</li>
      </ul>
  </div>
</div>

</body>
</html>