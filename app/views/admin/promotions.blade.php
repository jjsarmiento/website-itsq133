@extends('admin.layouts.master')

@section('master-head')
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>

<script>
    $(document).ready(function(){
        promotionsPage();

        $('.deleteLocation').click(function(){
            var name = $(this).attr('data-locname');
            $('.deleteLocationModal-body').empty().append('Are you sure you want to delete '+name+'?<br/> All associated articles, videos and images will be also deleted');
            $('.deleteBtnModal').attr('href', '/admin/deleteLocation/'+$(this).attr('data-locid'));
            $('#deleteLocationModal').modal().show();
        })
    })
</script>
@stop

@section('master-body')
<h1><i class="glyphicon glyphicon-flag"></i> Promotions</h1>
<hr/>

@if(Session::has('successMsg'))
    <div class="updatemsgDiv">
        <button type="button" class="close" aria-label="Close" onclick="$('.updatemsgDiv').fadeToggle()"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> {{ Session::get('successMsg') }}
    </div>
@endif

@if(Session::has('errorMsg'))
    <div class="updatemsgDiv" style="background-color: #FFC7BD; color: red; border-color: red;">
        <button type="button" class="close" aria-label="Close" onclick="$('.updatemsgDiv').fadeToggle()"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-warning"></i> {{ Session::get('errorMsg') }}
    </div>
@endif


<div class="panel panel-primary">
    <div class="panel-heading">
        Locations : Total of {{ $locationCount }}
        <div class="pull-right" style="margin-top: -0.5em; margin-right: -0.8em">
            <a class="btn btn-default" data-target="#addLocationModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Location</a>
        </div>
    </div>
    <div class="panel-body" style="padding-top: 0;">
        @foreach($locations as $location)
            <form action="/admin/editLocation" method="POST" id="form_{{ $location->id }}">
                <input type="hidden" value="{{ $location->id }}" name="locationId">
                <div class="panel-body" style="border: solid 0.08em #BDC3C7; border-bottom: none; margin-top: 1em;">
                    <h3 style="margin: 0; margin-bottom: 0.2em;">
                        <span id="origName_{{ $location->id }}">{{ $location->name }}</span>
                        <input name="locationName" class="form-control" type="text" value="{{ $location->name }}" id="name_{{ $location->id }}" style="display: none;"/>
                    </h3>
                    <div style="font-size: 0.8em; color: #95A5A6;">
                        <span id="origDesc_{{ $location->id }}">{{ $location->description }}</span>
                        <div id="desc_{{ $location->id }}" style="display: none;">
                            <textarea name="locationDescription" id="textareaDesc_{{ $location->id }}" class="form-control" >{{ $location->description }}</textarea>
                            <font color="red"><i class="fa fa-warning"></i><i> Description has 255 character limit</font></i>
                        </div>
                    </div>
                </div>
                <div class="panel-footer" style="border: solid 0.1em #BDC3C7">
                    <div class="btn-group btnSet1_{{ $location->id }}" role="group" aria-label="...">
                        <button type="button" class="btn btn-default" onclick="location.href='/admin/article/{{ $location->id }}'"><i class="glyphicon glyphicon-paperclip"></i> Articles</button>
                        <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-upload"></i> Upload Image</button>
                        <button type="button" class="btn btn-default editInfo" data-locid="{{ $location->id }}"><i class="glyphicon glyphicon-edit"></i> Edit Info</button>
                        <button type="button" class="btn btn-danger deleteLocation" data-locid="{{ $location->id }}" data-locname="{{ $location->name }}"><i class="glyphicon glyphicon-remove-circle"></i> Delete</button>
                    </div>
                    <div class="btn-group btnSet2_{{ $location->id }}" role="group" aria-label="..." style="display: none;">
                        <button type="button" class="btn btn-danger cancelEdit" data-locid="{{ $location->id }}" data-locname="{{ $location->name }}"><i class="glyphicon glyphicon-edit"></i> Cancel</button>
                        <button type="button" class="btn btn-success saveEdit" data-locid="{{ $location->id }}"><i class="glyphicon glyphicon-remove-circle"></i> Save</button>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
</div>

{{ Form::open(array('url' => '/admin/addLocation')) }}
<div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus" style="color: #27AE60"></i> Add Location for promotion</h4>
            </div>
            <div class="modal-body">
                {{ Form::text('locationName', Input::old('locationName'),array('class' => 'addLocationInput form-control margin-bottom-10', 'placeholder' => 'Enter location name here')) }}
                {{ Form::textarea('locationDescription', Input::old('locationDescription'),array('class' => 'addLocationInput form-control margin-bottom-10', 'placeholder' => 'Enter location description here')) }}
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" data-dismiss="modal" class="btn btn-danger cancel-modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

<div class="modal fade" id="deleteLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning" style="color: red"></i> Confirm deletion of location</h4>
            </div>
            <div class="modal-body deleteLocationModal-body">
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                    <a href="#" class="btn btn-danger deleteBtnModal">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop