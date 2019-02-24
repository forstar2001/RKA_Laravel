@extends('layouts.adminlayout')

@section('title')
{{ $title }}
@endsection

@section('content_header')

<h1>
    <?php
        echo 'User List';
    ?>
</h1>
@endsection

@section('content')

                    @if(Session::has("global"))
                    {!!Session::get("global")!!}
                    @endif

<?php if (count($user_data) > 0) { ?>
    <script>
        $(document).ready(function () {
            $('#example2').dataTable();
        });
    </script>
<?php } ?>
<br/>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th> 
                            <th>Profile</th>                       
                            <th>Athlete Type</th>   
                            <th width="80">Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($user_data) > 0) {
                            foreach ($user_data as $key => $each_data) {
                                ?>
                                <tr>
                                    <td><?php echo $each_data->first_name ?></td>
                                    <td>
                                        <?php
                                        echo $each_data->profile;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
										if(isset($each_data->athlete_type))
                                        echo $athlete_type_arr[$each_data->athlete_type];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $edit_url = 'Admin/EditUser/' . $each_data->id.'/1';
                                        $delete_url = 'Admin/DeleteUser/' . $each_data->id;
                                        ?>
                                        <a href="{{ URL::to($edit_url) }}" class="text-muted" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil fa-lg"></i></a> &nbsp; &nbsp; 
                                        <a href="{{ URL::to($delete_url) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this User?');" class="text-muted"><i class="fa fa-trash-o fa-lg"></i></a>

                                    </td>
                                </tr>                    
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="4">No record found.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@endsection

    <script type="text/javascript">
      $(function () {
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
