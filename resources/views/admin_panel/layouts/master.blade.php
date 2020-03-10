<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>
            @section('title')
                | NCW Admin Pannel
            @show
        </title>
        @include('admin_panel.layouts.head')
  </head>
<body>
  <input type = "file" id = "cropFileInput" class = "hidden" accept="image/*" />  
  @include('admin_panel.layouts.header')
    <div class="wrapper">
      @yield('content')
    </div>
    @include('admin_panel.layouts.footer')    
    @include('admin_panel.layouts.footer-script')
      
    </body>
</html>