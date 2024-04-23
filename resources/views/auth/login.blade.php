@extends('layouts.app')

@section('content')
<style type="text/css">
    
   .auth.theme-one .auto-form-wrapper .form-group .input-group .form-control {
        border-right: 1px solid #cfd5db !important;
    }
    
    .auth.auth-bg-1 {
        background: linear-gradient(45deg, #0030E0, #0073F8AB, #1CB5E0D9, #00C9EBCC) !important;

    }

     @media only screen and (min-width : 992px){

     .max-width-mobile{
        max-width: 44%;
        flex: 0 0 44%;
     }
 
 }


    @media only screen and (min-width : 800px ) and (max-width : 991px){

     .max-width-mobile{
        max-width: 75%;
        flex: 0 0 75%;
     }
      
 }
 @media only screen and (min-width : 600px ) and (max-width : 799px){

     .max-width-mobile{
        max-width: 78%;
        flex: 0 0 78%;
     }
      
 }

 @media only screen and (max-width : 599px){

     .max-width-mobile{
        max-width: 100%;
        flex: 0 0 100%;
     }
     .auth.theme-one .auto-form-wrapper {
        padding: 26px!important;
     }
    
 }
  .w-100 {
  width: 100% !important;
margin: 0px!important;
}

</style>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto max-width-mobile">
                    <div class="auto-form-wrapper">
                        <div class="row">
                            <div style="text-align: center; margin-bottom: 45px;" class="col-md-12">
                                <img style="width: 100%;" src="{{ asset('/admin/logo-black-1.png') }}">
                            </div>
                            <!--<div class="col-md-12">
                                <div style="width: 100%:" class="alert alert-info alert-action alert-border no-fa text-center margin-bottom">
                        Login : <strong>demo@teknosolvo.com</strong><br>
                        Mot de passe : <strong>secret</strong>
                    </div>
                            </div>-->
                        </div><br>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label class="label">Adresse email</label>
                                <div class="input-group">
                                    <input placeholder="Adresse email.." id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <!--<div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-check-circle-outline"></i>
                                        </span>
                                    </div>-->
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="label">Mot de passe</label>
                                <div class="input-group">
                                     <input placeholder="" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <!--<div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="mdi mdi-check-circle-outline"></i>
                                        </span>
                                    </div>-->
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary submit-btn btn-block">Connexion</button>
                            </div>
                            <!--<div class="form-group d-flex justify-content-between">
                                <div class="form-check form-check-flat mt-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Keep me signed in </label>
                                </div>
                            </div> -->
                        </form>
                    </div> 
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
@endsection
