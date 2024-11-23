<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title>mahbubEdu - Log in </title>

	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('backend') }}/src/css/vendors_css.css">

	<!-- Style-->
	<link rel="stylesheet" href="{{ asset('backend') }}/src/css/style.css">
	<link rel="stylesheet" href="{{ asset('backend') }}/src/css/skin_color.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url({{ asset('backend/main') }}/images/auth-bg/bg-16.jpg)">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary fw-600">Let's Get Started</h2>
								<p class="mb-0 text-fade">Sign in to continue to mahbubedu.</p>
							</div>
							<div class="p-40">
								<form method="POST" action="{{ route('login') }}">
                                    @csrf
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent">
                                                <i class="fa-solid text-fade fa-user-tie"></i>
                                                {{-- <i class="text-fade ti-user"></i> --}}
                                            </span>
											<input type="text" id="email" class="form-control ps-15 bg-transparent @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text  bg-transparent">
                                                <i class="fa-solid text-fade fa-lock"></i>
                                                {{-- <i class="text-fade ti-lock"></i> --}}
                                            </span>
											<input id="password" type="password" class="form-control ps-15 bg-transparent @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
									</div>
									  <div class="row">
										<div class="col-6">
										  <div class="checkbox">
											<input type="checkbox" id="basic_checkbox_1" >
											<label for="basic_checkbox_1">Remember Me</label>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-6">
										 <div class="fog-pwd text-end">
                                            @if (Route::has('password.request'))
											    <a href="{{ route('password.request') }}" class="text-primary fw-500 hover-primary"><i class="ion ion-locked"></i>{{ __('Forgot Your Password?') }}</a><br>
                                            @endif
                                        </div>

										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="submit" class="btn btn-primary w-p100 mt-10">SIGN IN</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>
								<div class="text-center">
									<p class="mt-15 mb-0 text-fade">Don't have an account? <a href="#" class="text-primary ms-5">Sign Up</a></p>
								</div>

								<div class="text-center">
								  <p class="mt-20 text-fade">- Sign With -</p>
								  <p class="gap-items-2 mb-0">
									  <a class="waves-effect waves-circle btn btn-social-icon btn-circle btn-facebook-light" href="#">
                                        <i class="fa-brands fa-facebook"></i>
                                        {{-- <i class="fa fa-facebook"></i> --}}
                                    </a>
									  <a class="waves-effect waves-circle btn btn-social-icon btn-circle btn-twitter-light" href="#">
                                        <i class="fa-brands fa-twitter"></i>
                                        {{-- <i class="fa fa-twitter"></i> --}}
                                    </a>
									  <a class="waves-effect waves-circle btn btn-social-icon btn-circle btn-instagram-light" href="#">
                                        <i class="fa-brands fa-instagram"></i>
                                        {{-- <i class="fa fa-instagram"></i> --}}
                                    </a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
	<script src="{{ asset('backend') }}/src/js/vendors.min.js"></script>
	<script src="{{ asset('backend') }}/src/js/pages/chat-popup.js"></script>
    <script src="{{ asset('backend/main') }}/assets/icons/feather-icons/feather.min.js"></script>

</body>
</html>
