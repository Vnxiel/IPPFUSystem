@extends('systemAdmin.layout')

@section('title', 'Trash')

@section('content') 
    <hr class="mx-2">
    <div class="container-fluid px-3">
        <div class="col-md-12 m-2">
            <div class="row">
                <h5 class="p-0">Trash</h5>
                <hr>
            </div>
            <div class="row">
                <div class="table-container table-responsive">
                    <table id="trashList" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">Project Title</th>
                                <th style="width: 15%;">Location</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 10%;">Contract Amount</th>
                                <th style="width: 15%;">Contractor</th>
                                <th style="width: 12%;">Duration</th>
                                <th style="width: 8%;">Action</th>
                            </tr>   
                        </thead>
                        <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">Loading projects...</td>
                                    </tr>
                                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
