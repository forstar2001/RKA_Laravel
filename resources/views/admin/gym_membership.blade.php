@extends('layouts.adminlayout')

@section('title')
{{ $title }}
@endsection

@section('content_header')

<h1>
    <?php
        echo 'Gym Membership';
    ?>
</h1>
@endsection

@section('content')

@if(Session::has("global"))
{!!Session::get("global")!!}
@endif

<?php if (count($gym_membership) > 0) { ?>
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
                    <div class="button-panel pull-right">
                        <a href="{{ route('AddGymMembership') }}" class="btn btn-default bg-blue-custom pull-right"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div><!-- /.box-header -->
                
            <div class="box-body">
                
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Title</th> 
                            <th>Description</th> 
                            <th width="80">Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($gym_membership) > 0) {
                            foreach ($gym_membership as $key => $gym_membership_data) {
                                ?>
                                <tr>
                                    <td><?php echo $gym_membership_data->tag_title ?></td>
                                    <td><?php echo $gym_membership_data->tag_desc; ?> </td>
                                    <td class="text-center">
                                        <?php 
                                        $edit_url = 'Admin/EditGymMembership/' . $gym_membership_data->id;
                                        $delete_url = 'Admin/DeleteGymMembership/' . $gym_membership_data->id;
                                        ?>
                                        <a href="{{ URL::to($edit_url) }}" class="text-muted" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil fa-lg"></i></a> &nbsp; &nbsp; 
                                        <a href="{{ URL::to($delete_url) }}" data-toggle="tooltip" title="Delete" onclick="return confirm('Are You Sure ?');" class="text-muted"><i class="fa fa-trash-o fa-lg"></i></a>

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
