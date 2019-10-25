<section class="">
    <div class="member-login py-5 my-5">
            <div class="container">
                <h4 class="my-3 text-center">Reset Password</h4>
            <div class="row ">
                <div class=" col-md-8 m-auto">
                    <div class="teacher-profile login-sheet mb-5 pb-5">
                        <form method="POST" action="{{ url('/make/password/reset') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-row form-group{{ $errors->has('email') ? ' has-error' : '' }}" >
                            <div class="col-12">
                                <div class="input-group mb-2">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-12">
                                    <div class="input-group mb-2">
                                        <label for="password" class="col-md-4 control-label">Password</label>
                                        <input id="password" type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                        <div class="input-group mb-2">
                                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                        </form>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif


                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif


                    </div>
                </div>
            </div>
            </div>
        </div>
</section>