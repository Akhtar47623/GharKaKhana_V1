@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{$title }}</h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('roles.permission.store',$roleData->uuid), 'method'=>'POST', 'files'=>true, 'name' => 'roles', 'id' => 'frmPermission']) }}
                    {{csrf_field()}}
                     <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <?php
                                            foreach ($roleData->actionList as $action) {
                                                $name = $action;
                                                if ($action == 'browse') {
                                                    $name = 'List';
                                                } elseif ($action == 'read') {
                                                    $name = 'View';
                                                }
                                                echo "<th class='text-center'>" . ucfirst($name) . "</th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roleData->moduleList as $module)
                                        <tr>
                                            <td><strong>{{ucwords(str_replace('_',' ',$module))}}</strong></td>
                                            @foreach($roleData->actionList as $action)
                                            <td class="text-center">
                                                <?php
                                                $permissionName = $action . "_" . $module;
                                                if (in_array($permissionName, $roleData->permissionList)) {
                                                    $checked = '';
                                                    if (in_array($permissionName, $roleData->allowPermission)) {
                                                        $checked = 'checked';
                                                    }
                                                    echo "<input type='checkbox' name='permissions[]' $checked value='$permissionName'/>";
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                              <button type="submit" class="btn btn btn-primary " id="btnSubmit"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Submit">Submit</button>

                              <a href="{{ route('roles.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
                          </div>
                      </div>
                    {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection
@section('pagescript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{ asset('public/backend/js/pages/permission.js') }}"></script>
@stop