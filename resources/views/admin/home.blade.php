@extends('layouts.adminlayout')

@section('title')
{{ $title }}
@endsection
@section('content_header')
<h1>
    Dashboard
</h1>
@endsection
<?php
print_r($user_data);
?>
@section('content')
<script>
    $(function () {
        //INITIALIZE SPARKLINE CHARTS
        $(".sparkline").each(function () {
            var $this = $(this);
            $this.sparkline('html', $this.data());
        });
        
        $(".datepicker").datepicker({
            showInputs: false
        });

    });

</script>

@endsection