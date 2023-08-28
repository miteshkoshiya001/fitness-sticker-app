@extends('layouts.admin.template')

@section('title', __('messages.sticker_collection'))
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-list-view.css') }}">
@endsection()
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ localized_route('dashboard') }}">{{ __('messages.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.sticker_collection') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">

        {{-- New Table --}}
        <section id="data-thumb-view" class="data-thumb-view-header">
            <div class="action-btns d-none">
                <div class="btn-dropdown mr-1 mb-1">
                    <div class="btn-group dropdown actions-dropodown">
                        <a href="{{ localized_route('sticker-collection.create') }}"
                            class="btn btn-outline-primary text-primary">{{ __('messages.add_sticker_collection') }}</a>
                    </div>
                </div>
            </div>
            <!-- dataTable starts -->
            <div class="table-responsive">
                <table class="table data-thumb-view" id="categories">
                    <thead>
                        <tr>
                            <th>{{ __('messages.sr_no') }}</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{__('messages.sticker-category')}}</th>
                            <th>{{ __('messages.is-premium') }}</th>
                            <th>{{ __('messages.is-default') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collections as $key => $collection)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td class="product-name"> {{ !empty($collection->name) ? $collection->name : 'N/A' }} </td>
                                <td>{{$collection->sticker_category_id}}</td>
                                <td>
                                    <div class="chip chip-{{ !empty($collection->is_premium) ? 'success' : 'danger' }}">
                                        <div class="chip-body">
                                            <div class="chip-text">
                                                {{ !empty($collection->is_premium) ? __('messages.yes') : __('messages.no') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="chip chip-{{ !empty($collection->is_default) ? 'success' : 'danger' }}">
                                        <div class="chip-body">
                                            <div class="chip-text">
                                                {{ !empty($collection->is_default) ? __('messages.yes') : __('messages.no') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="chip chip-{{ !empty($collection->status) ? 'success' : 'danger' }}">
                                        <div class="chip-body">
                                            <div class="chip-text">
                                                {{ !empty($collection->status) ? __('messages.active') : __('messages.inactive') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-action">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ localized_route('sticker-collection.edit', $collection->id) }}"
                                            class="btn btn-outline-primary waves-effect waves-light"><i
                                                class="feather icon-edit"></i></a>
                                        <button type="button"
                                            class="btn btn-outline-danger waves-effect waves-light action-delete"
                                            data-module="{{ get_class($collection) }}" data-id="{{ $collection->id }}"><i
                                                class="feather icon-trash"></i></button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- dataTable ends -->
        </section>
    </div>
@endsection
@section('page-js')
    <script>
        $(document).ready(function() {
            // START : init thumb view datatable
            var dataThumbView = $("#categories").DataTable({
                responsive: false,
                columnDefs: [],
                dom: '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
                oLanguage: {
                    sLengthMenu: "_MENU_",
                    sSearch: ""
                },
                aLengthMenu: [
                    [10, 15, 20],
                    [10, 15, 20]
                ],
                select: {
                    style: "multi"
                },
                order: [
                    [0, "desc"]
                ],
                bInfo: false,
                pageLength: 10,
                buttons: [],
                initComplete: function(settings, json) {
                    $(".dt-buttons .btn").removeClass("btn-secondary")
                }
            })

            dataThumbView.on('draw.dt', function() {
                setTimeout(function() {
                    if (navigator.userAgent.indexOf("Mac OS X") != -1) {
                        $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
                    }
                }, 50);
                initDelete();
            });
            var actionDropdown = $(".actions-dropodown")
            actionDropdown.insertBefore($(".top .actions .dt-buttons"))
            // END : init thumb view datatable
            initDelete();
        });
    </script>
@endsection