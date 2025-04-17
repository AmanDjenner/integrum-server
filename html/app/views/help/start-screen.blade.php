 <!DOCTYPE html>
 <html lang="pl">

<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
 </head>

 <body>
   <style>
    #welcome-screen {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 17.34px;
        color: #646363;
        font-weight: 400;
        text-align: center;
        background-position: bottom;
        padding: 0;
        z-index: 2;
        position: absolute;
    }
    .welcome-screen-bg {
        background: url(welcome-bg.jpg) no-repeat;
        width: 100%;
        position: absolute;
        top: 0;
        opacity: .3;
        height: 100%;
        background-position: bottom;
        z-index: 0;
    }
    body {margin:0}
    #welcome-screen h1 {
      font-size: 48px;
      color: #fecf65;
      font-weight: 300;
      padding: 0 0;
    }
    #welcome-screen p {
      margin-bottom: 30px;
    }
    #welcome-screen a {
      color: #fbba00;
      transition: .3s all ease-in-out;
    }
    #welcome-screen a:hover,
    #welcome-screen a:focus {
      color: #3b3b3b;
      text-decoration: none;
    }
    #welcome-screen .row {
      display: flex;
      max-width: 770px;
      margin: 0 auto;
    }
    #welcome-screen .col-sm-4 {
      float: left;
      display: block;
      width: 33.33333333%;
    }
    #welcome-screen .list-unstyled {
      list-style: none;
    }
    #welcome-screen ul {
      padding: 0;
    }
  </style>
     <div id="help-max-close-section" style="position: absolute; z-index: 50; right: 10px; display:none">
    <a href="#" id="help-maximize"onmouseover="document.images.maximize.src='b_maximize_yellow.png'" onmouseout="document.images.maximize.src='b_maximize_silver.png'"> 
     <img name="maximize" src="b_maximize_silver.png" border="0" alt="Powi&#281;ksz" title="Powi&#281;ksz"></a>&nbsp;
    <a href="#" id="help-close"onmouseover="document.images.close.src='b_close_yellow.png'" onmouseout="document.images.close.src='b_close_silver.png'"> 
     <img name="close" src="b_close_silver.png" border="0" alt="Zamknij" title="Zamknij"></a>&nbsp;
    </div>

  <div id="welcome-screen">
    <h1>{[Lang::get('welcome.title')]}</h1>
    <p>{[Lang::get('welcome.p1')]}</p>
    <p>{[Lang::get('welcome.p2')]}</p>
    <p>{[Lang::get('welcome.p3')]}</p>

    <div class="row">
      <div class="col-sm-4">
        <ul class="list-unstyled">
          <li><a href="wprowadzenie.html">{[Lang::get('welcome.t1')]}</a></li>
          <li><a href="pierwsze-kroki.html">{[Lang::get('welcome.t2')]}</a></li>
          <li><a href="pasek-menu.html">{[Lang::get('welcome.t3')]}</a></li>
          <li><a href="menu-regionow.html">{[Lang::get('welcome.t4')]}</a></li>
        </ul>
      </div>

      <div class="col-sm-4">
        <ul class="list-unstyled">
          <li><a href="ekran_uzytkownicy.html">{[Lang::get('welcome.t5')]}</a></li>
          <li><a href="ekran_centrale.html">{[Lang::get('welcome.t6')]}</a></li>
          <li><a href="ekran-zdarzenia.html">{[Lang::get('welcome.t7')]}</a></li>
          <li><a href="ekran-tablica-informacyjna.html">{[Lang::get('welcome.t8')]}</a></li>
        </ul>
      </div>

      <div class="col-sm-4">
        <ul class="list-unstyled">
          <li><a href="ekran-status.html">{[Lang::get('welcome.t9')]}</a></li>
          <li><a href="ekran-szablony-uzytkownikow.html">{[Lang::get('welcome.t10')]}</a></li>
          <li><a href="ekran-role-uzytkownikow.html">{[Lang::get('welcome.t11')]}</a></li>
          <li><a href="ekran-ustawienia-regionu.html">{[Lang::get('welcome.t12')]}</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="welcome-screen-bg">&nbsp;</div>

 </body>

 </html>
