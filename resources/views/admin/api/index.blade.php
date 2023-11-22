@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>API Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">API</div>
        </div>
    </div>

    <div class="section-body">


        <script type="text/javascript">

            window.onload = function () {

                $("#sdate").datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                $("#edate").datetimepicker({
                    format: 'YYYY-MM-DD'
                });

            };

            function login_btn() {
                hide_search_box();
                $('#login_box').show();
                $('#api_link').val('/api/login');
            }
            function login() {

                var email = $('#email').val();
                if ($.trim(email) == '') {
                    return;
                }
                var password = $('#password').val();
                if ($.trim(password) == '') {
                    return;
                }
                var data = {
                    email: email,
                    passwd: password
                };
                document.getElementById("input_json").innerHTML = JSON.stringify(data, undefined, 2);
                $.ajax({
                    url: 'https://reemarc.info/api/login',
                    data: data,
                    cache: false,
                    type: 'post',
                    dataType: 'json',
                    success: function(res) {
                        if ($.trim(res.msg) === '') {
                            var out_table = "";
                            $.each(res, function(key, value){
                                out_table += "<h3>" + key + "</h3>";
                                out_table += get_out_table(value);
                            });
                            $('#out_area_box').append(out_table);
                            document.getElementById("output_json").innerHTML = JSON.stringify(res, undefined, 2);
                        } else {
                            $('#out_area_box').append(out_table);
                        }
                    },
                    error: function(result, status, error) {
                        $('#out_area_box').append(result, status, error);
                    }
                });
            }

            function member_btn() {
                hide_search_box();
                $('#member_box').show();
                $('#api_link').val('/api/member');
            }
            function member() {
                // hide_search_box();
                // $('#member_box').show();
                // $('#api_link').val('/api/member');

                var data = {
                    // api_key: $('#api_key').val(),
                    // token: $('#token').val(),
                };
                document.getElementById("input_json").innerHTML = JSON.stringify(data, undefined, 2);
                $.ajax({
                    url: '/api/member',
                    data: data,
                    cache: false,
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        if ($.trim(res.msg) === '') {
                            var out_table = "";
                            $.each(res, function(key, value){
                                out_table += "<h3>" + key + "</h3>";
                                out_table += get_out_table(value);
                            });
                            // $('#out_area_box').append(out_table);
                            document.getElementById("output_json").innerHTML = JSON.stringify(res, undefined, 2);
                        } else {
                            myApp.showError(res.msg);
                        }
                    }
                });
            }

            function sign_up_btn(){
                hide_search_box();
                $('#sign_up_box').show();
                $('#api_link').val('/api/sign_up');
            }

            function sign_up(){

            }

            function forgot_password_btn(){

            }

            function forgot_password(){

            }


            function login_as() {
                hide_search_box();
                $('#login_as_box').show();

                $('#api_link').val('/api/v2/groomer/login_as');

                var groomer_id = $('#groomer_id').val();
                if ($.trim(groomer_id) == '') {
                    return;
                }

                var data = {
                    api_key: $('#api_key').val(),
                    token: $('#token').val(),
                    groomer_id: groomer_id
                };

                document.getElementById("input_json").innerHTML = JSON.stringify(data, undefined, 2);

                $.ajax({
                    url: '/api/v2/groomer/login_as',
                    data: data,
                    cache: false,
                    type: 'post',
                    dataType: 'json',
                    success: function(res) {
                        if ($.trim(res.msg) === '') {
                            var out_table = "";

                            $.each(res, function(key, value){
                                out_table += "<h3>" + key + "</h3>";
                                out_table += get_out_table(value);
                            });

                            $('#out_area_box').append(out_table);

                            document.getElementById("output_json").innerHTML = JSON.stringify(res, undefined, 2);
                        } else {
                            myApp.showError(res.msg);
                        }
                    }
                });
            }

            function logout() {
                hide_search_box();
                $('#logout_box').show();

                $('#api_link').val('/api/logout');


                var data = {
                    api_key: $('#api_key').val(),
                    token: $('#token').val()
                };

                document.getElementById("input_json").innerHTML = JSON.stringify(data, undefined, 2);

                $.ajax({
                    url: '/api/logout',
                    data: data,
                    cache: false,
                    type: 'post',
                    dataType: 'json',
                    success: function(res) {
                        if ($.trim(res.msg) === '') {
                            var out_table = "";

                            $.each(res, function(key, value){
                                out_table += "<h3>" + key + "</h3>";
                                out_table += get_out_table(value);
                            });

                            $('#out_area_box').append(out_table);

                            document.getElementById("output_json").innerHTML = JSON.stringify(res, undefined, 2);
                        } else {
                            myApp.showError(res.msg);
                        }
                    }
                });
            }

            function hide_search_box() {
                $('#output_json').empty();
                $('#out_area_box').empty();

                $('#login_box').hide();
                $('#member_box').hide();
                $('#sign_up_box').hide();

                $('#date_box').hide();
            }

            function get_out_table(data) {
                var keys = '';
                var values = '';

                vtype = $.type(data);

                if (vtype == 'object') {
                    $.each(data, function(k, v){
                        keys += '<th>' + k + '</th>';
                        values += '<td>' + v + '</td>';
                    });
                } else if (vtype == 'array') {
                    $.each(data, function(i, value) {

                        var vt = $.type(value);

                        values += '<tr>';
                        if (vt == 'object') {
                            $.each(value, function(k, v){
                                if (i == 0) {
                                    keys += '<th>' + k + '</th>';
                                }

                                var vt2 = $.type(v);

                                if (vt2 == 'object') {
                                    values += '<td>';
                                    $.each(v, function(k2, v2){
                                        values += k2 + ': ' + v2 + '<br>';
                                    });
                                    values += '</td>';
                                } else if (vt2 == 'string') {
                                    values += '<td>' + v + '</td>';
                                } else {
                                    values += '<td>' + JSON.stringify(v, undefined, 2) + '</td>';
                                }
                            });
                        } else {
                            values += '<td>(' + vt + ') ' + v + '</td>';
                        }

                        values += '</tr>';
                    });
                } else {
                    values += '<td>(' + vtype + ') ' + data + '</td>';
                }

                return "<table class=\"table table-striped display\"><thead>" + keys + "</thead><tbody>" + values +
                    "</tbody></table>";
            }

        </script>


        <div class="container-fluid">
            <div class="well filter" style="padding-bottom:5px;">

                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-1 control-label">API Key</label>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" id="api_key" value="{{ getenv('ANDROID_KEY') }}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-1 control-label">Email:</label>
                                <div class="col-md-11">
{{--                                    <input type="text" class="form-control" id="email" value="{{  }}" />--}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-1 control-label">Token:</label>
                                <div class="col-md-11">
{{--                                    <input type="text" class="form-control" id="token" value="{{ $token }}" />--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-info" onclick="login_btn()">Login</button>
                            <button class="btn btn-info" onclick="member_btn()">Member</button>
                            <hr>
                            <button class="btn btn-info" onclick="sign_up_btn()">Sign Up</button>
                            <button class="btn btn-info" onclick="forgot_password_btn()">Forgot Password</button>
                            <button class="btn btn-info" onclick="clinic_list_btn()">Clinic List</button>
                            <button class="btn btn-info" onclick="appointment_btn()">Appointment</button>
                            <button class="btn btn-info" onclick="payment_btn()">Payment</button>
                            <button class="btn btn-info" onclick="edit_user_btn()">Edit User</button>

{{--                            <hr>--}}
{{--                            <button class="btn btn-info" onclick="get_open_appointments()">Open Appointments</button>--}}
{{--                            <button class="btn btn-info" onclick="get_open_appointment_detail()">Open Appointment Detail</button>--}}
{{--                            <button class="btn btn-info" onclick="get_availability()">Get Availability(open/my)</button>--}}
{{--                            <button class="btn btn-info" onclick="set_availability()">Set Availability</button>--}}
{{--                            <button class="btn btn-info" onclick="get_upcoming()">Upcoming List</button>--}}
{{--                            <button class="btn btn-info" onclick="get_upcoming_detail()">Upcoming Detail</button>--}}
{{--                            <button class="btn btn-info" onclick="get_history()">History List</button>--}}
{{--                            <button class="btn btn-info" onclick="get_history_detail()">History Detail</button>--}}
{{--                            <hr>--}}
{{--                            <button class="btn btn-info" onclick="get_profile()">Get Profile</button>--}}
{{--                            <button class="btn btn-info" onclick="get_info()">Get Info</button>--}}
{{--                            <hr>--}}
{{--                            <button class="btn btn-info" onclick="get_groomer_categories()">Get Categories</button>--}}
{{--                            <button class="btn btn-info" onclick="get_groomer_products()">Get Groomer Products</button>--}}
{{--                            <button class="btn btn-info" onclick="add_product_cart()">Add Item to Cart</button>--}}
{{--                            <button class="btn btn-info" onclick="delete_product_cart()">Delete Item from Cart</button>--}}
{{--                            <button class="btn btn-info" onclick="get_product_cart()">Returns Cart Items</button>--}}
{{--                            <button class="btn btn-info" onclick="create_groomer_order()">Create Groomer Order</button>--}}
{{--                            <button class="btn btn-info" onclick="get_order_list()">Get Groomer Orders</button>--}}
{{--                            <button class="btn btn-info" onclick="get_order_detail()">Get Order Detail</button>--}}
{{--                            <hr>--}}
{{--                            <button class="btn btn-info" onclick="get_groomer_arrived()">Groomer Arrived</button>--}}
{{--                            <button class="btn btn-info" onclick="appt_complete()">Appt Complete</button>--}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-1 control-label">API Link</label>
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="api_link" value="" disabled/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container-fluid">
            <div class="well filter" style="padding-bottom:5px;">
                <div class="row" id="date_box" style="display:none;">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Date</label>
                            <div class="col-md-8">
                                <input type="text" style="width:100px; float:left;" class="form-control" id="sdate"
                                       value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"/>
                                <span class="control-label" style="margin-left:5px; float:left;"> ~ </span>
                                <input type="text" style="width:100px; margin-left: 5px; float:left;"
                                       class="form-control" id="edate" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"/>
                            </div>

                        </div>
                    </div>
                </div>



                <div id="login_box" style="display:none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Email</label>
                                <div class="col-md-11">
                                    <input type="text" style="margin-left: 5px; float:left;"
                                           class="form-control" id="email"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Password</label>
                                <div class="col-md-11">
                                    <input type="text" style="margin-left: 5px; float:left;"
                                           class="form-control" id="password"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                    <button class="btn btn-info" onclick="login()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="member_box" style="display:none;">
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-info" onclick="member()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sign_up_box" style="display:none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Email</label>
                                <div class="col-md-11">
                                    <input type="text" style="margin-left: 5px; float:left;"
                                           class="form-control" id="email"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Password</label>
                                <div class="col-md-11">
                                    <input type="text" style="margin-left: 5px; float:left;"
                                           class="form-control" id="password"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                    <button class="btn btn-info" onclick="sign_up()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="device_token_box" style="display:none;">
                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Device Token</label>
                                <div class="col-md-10">
                                    <input type="text" style="width:100px; margin-left: 5px; float:left;"
                                           class="form-control" id="device_token"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 16px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                    <button class="btn btn-info" onclick="update_device_token()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--get_earning_history_box--}}

            </div>
        </div>

        <div class="container-fluid">
            <form id="frm_search" class="form-horizontal">

                <div id="out_area_box">

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="text-align: left;margin:12px;border-bottom: 1px solid #ccc;">
                            <h3>REQUEST (JSON)</h3>
                        </div>
                        <pre id="input_json"></pre>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="text-align: left;margin:12px;border-bottom: 1px solid #ccc;">
                            <h3>RESPONSE (JSON)</h3>
                        </div>
                        <pre id="output_json"></pre>
                    </div>
                </div>
            </form>
        </div>



    </div>
</section>
@endsection
