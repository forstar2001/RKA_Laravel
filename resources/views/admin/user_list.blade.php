@extends('layouts.adminlayout')



@section('content_header')


<h1>
    <?php
        echo 'User List';
    ?>
</h1>
@endsection
@section('content')

<?php if (count($user_list) > 0) { ?>
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
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th> 
                                                
                            <th>Date Of Birth</th>  
                            <th>Gender</th>   
                            <th width="80">Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if (count($user_list) > 0) {
                            
                            foreach ($user_list as $each_data) {
                                ?>
                                <tr>
                                    <td><?php echo $each_data->first_name . ' ' . $each_data->last_name ?></td>
                                    <td>
                                        <?php
                                        echo $each_data->date_of_birth;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $each_data->gender;
                                        ?>
                                    </td>
                                   
                                    <td class="text-center">
                                       hello

                                    </td>
                                </tr>                    
                                <?php
                            }
                        } else {
                            ?>
                            <tr><td colspan="4">No record found.</td></tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@endsection
