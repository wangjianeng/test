@extends('layouts.layout')
@section('label', 'Setting Templates')
@section('content')
    <h1 class="page-title font-red-intense"> Templates
        <small></small>
    </h1>


    <div class="row"><div class="col-md-8">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Templates Form</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" action="{{ url('template') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label>Tags</label>
                            <div class="input-group ">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Tags (Important: Multiple keywords separated by semicolons.)" name="tag" id="tag" value="{{old('tag')}}" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}" required>
                            </div>
                        </div>
                        <div class="form-group" >
                                    @include('UEditor::head')

                                    <!-- ���ر༭�������� -->
                                    <script id="valuelink_amzmessage_container" name="content" type="text/plain">					<?php echo old('content'); ?></script>
                                    <!-- ʵ�����༭�� -->
                                    <script type="text/javascript">
                                        var ue = UE.getEditor('valuelink_amzmessage_container');
                                        ue.ready(function() {
                                            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//�˴�Ϊ֧��laravel5 csrf ,����ʵ������޸�,Ŀ�ľ������� _token ֵ.
                                        });
                                </script>
                                        <div style="clear:both;"></div>
                            </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <button type="submit" class="btn blue">Submit</button>
                                <button type="reset" class="btn grey-salsa btn-outline">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="portlet light bordered" id="blockui_sample_1_portlet_body">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bubble font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp sbold">How to use it?</span>
                </div>
            </div>
            <div class="portlet-body">
                Available labels
                <p><p>
                    {EMAIL_TITLE}
                <p>
                    {CUSTOMER_NAME}
                <p>
                    {CUSTOMER_EMAIL}
            </div>
        </div>

    </div>

    </div>


@endsection
