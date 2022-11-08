@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style type="text/css">
    .redcol
    {
        color:red;
    }
</style>
<div class="container-fluid mt-4  mt-4 px-3 pe-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="cadrd cardd_top_orenge">
                <div class="modal-title pl-4">
                    <h5 class="" id="exampleModalLabel">Dashboard</h5>
                    
                </div>
               <div class="card-body">
                   <div class="row px-3" style="">
                  
                            
                   
                   
                </div>
               </div>
                
            </div>
        </div>
       

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    $('#datatable').DataTable({
        order: [[0 , 'desc']],
    });
});
</script>
@endsection