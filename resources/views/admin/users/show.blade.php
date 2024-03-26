@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Existing User Question</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ url('admin/users') }}">Existing User Question</a></div>
        </div>
    </div>

    <form method="POST" action="{{ route('users.existingUserUpdate', $user->id) }}" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        @csrf

        <div class="section-body">
            <h2 class="section-title">Existing User Question</h2>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @include('admin.shared.flash')
                            <div class="col">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email"
                                           class="form-control" disabled
                                           value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label>Patient Name</label>
                                    <input type="text" name="first_name"
                                           class="form-control" disabled
                                           value="{{ $user->first_name }} {{ $user->last_name }}">
                                </div>
                                <div class="card-header">
                                    <h5 style="color: #0062FF;">Please answer the questions about the Patient</h5>
                                </div>
                                <div class="form-group" id="question_1">
                                    <label style="font-size: medium; color: #b91d19;">1. Has the aligners for this patient already been ordered from Invisalign?</label>
                                    <select name="answer_1" id="answer_1" class="form-control" onchange="select_answer_1()">
                                        <option value="">Select</option>
                                        <option value="yes">YES</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                                <div class="form-group" id="question_2" style="display: none;">
                                    <label style="font-size: medium; color: #b91d19;">2. Have you received the aligners?</label>
                                    <select name="answer_2" id="answer_2" class="form-control" onchange="select_answer_2()">
                                        <option value="">Select</option>
                                        <option value="yes">YES</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                                <div class="form-group" id="question_3" style="display: none;">
                                    <label style="font-size: medium; color: #b91d19;">3. When was the first appointment with aligner?</label>
                                    <input type="text" name="first_date" id="first_date" placeholder="First Date" autocomplete="off"
                                           class="form-control datepicker">
                                </div>
                                <div class="form-group" id="question_4" style="display: none;">
                                    <label style="font-size: medium; color: #b91d19;"">4. What is the estimated treatment time?</label>
                                    <select name="answer_4" id="answer_4" class="form-control" onchange="select_answer_3()">
                                        <option value="">Select</option>
                                        <option value="9">9 Months</option>
                                        <option value="12">12 Months</option>
                                        <option value="15">15 Months</option>
                                        <option value="18">18 Months</option>
                                        <option value="21">21 Months</option>
                                        <option value="24">24 Months</option>
                                        <option value="27">27 Months</option>
                                        <option value="30">30 Months</option>
                                        <option value="33">33 Months</option>
                                        <option value="36">36 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" id="submit_btn" style="display: none">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>

</section>

<script type="text/javascript">

    function select_answer_1() {
        answer_1 = $('#answer_1 option:selected').val();

        if (answer_1 == 'yes') {
            $("#question_2").fadeIn(600);
            $("#submit_btn").fadeOut();
        } else if (answer_1 == 'no') {
            $("#submit_btn").fadeIn(600);
            $("#question_2").fadeOut();
            $("#question_3").fadeOut();
            $("#question_4").fadeOut();
        }
    }

    function select_answer_2() {
        answer_2 = $('#answer_2 option:selected').val();

        if (answer_2 == 'yes') {
            $("#question_2").fadeIn(600);
            $("#question_3").fadeIn(600);
            $("#question_4").fadeIn(600);
            $("#submit_btn").fadeOut();
        } else if (answer_2 == 'no') {
            $("#submit_btn").fadeIn(600);
            $("#question_3").fadeOut();
            $("#question_4").fadeOut();
        }
    }

    function select_answer_3() {
        $("#submit_btn").fadeIn(600);
    }

</script>
@endsection
