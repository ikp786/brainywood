
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://www.bootstrapdash.com/demo/login-template-free-2/assets/css/login.css">
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
              
    <div class="container">
      <div class="card login-card">
         
        <div class="row no-gutters">

          <div class="col-md-5">
            <img src="http://stageofproject.com/brainywood/assets/img/bnr-imge.svg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="http://stageofproject.com/brainywood/assets/img/web-logo.png" alt="logo" class="logo">
              </div>
              <p class="login-card-description">Sign into your account</p>
                <form class="form-horizontal"
                          role="form"
                          method="POST"
                          action="{{ url('login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control" required placeholder="Email address">
                  </div>
                  <div class="form-group mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input required type="password" name="password" id="password" class="form-control" placeholder="***********">
                  </div>
                  <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Login">
                </form>

                 @if (count($errors) > 0)
          <div class="alert alert-danger fade in alert-dismissible" style="width: 100%;
    text-align: center;
    margin: auto;
    opacity: 1 !important;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    @foreach ($errors->all() as $error)
    <strong>Error!</strong> {{ $error }}
      @endforeach
</div>
                      
                    @endif
            </div>
            
          </div>

        </div>

      </div>
      
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
