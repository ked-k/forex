

<x-guest-layout>   

    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center">
                    <h3 class="">Update Password</h3>

                </div>
                <div class="d-grid">
                    <div class="text-center">
                        <img src="assets/images/icons/mms.png" width="160" alt="" />
                    </div>
                </div>
                <div class="login-separater text-center mb-4"> <span>New Password</span>
                    <hr/>
                </div>
                <div class="form-body">

                        <form class="row g-3" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="col-12">
                            <label for="inputEmailAddress" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" :value="old('email')" required autofocus placeholder="Email Address">
                        </div>
                        <div class="col-12">
                            <label for="inputChoosePassword" class="form-label">New Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0" id="password"  name="password" placeholder="New Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputChoosePassword" class="form-label">Confirm Password</label>
                            <div class="input-group" id="password_confirmation">
                                <input type="password" class="form-control border-end-0" id="password_confirmation"  name="password_confirmation"   required  placeholder="Confirm Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">	<a href="{{ route('login') }}">Or login</a>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
