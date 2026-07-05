<x-default-layout>

    @section('title')
    Dashboard
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
    @endsection


    <div class="d-flex justify-content-start mb-5">
        <!-- <a href="{{ route('user.add') }}" class="btn btn-primary btn-sm my-5 me-2">
            <i class="fa-solid fa-plus"></i>
        </a>
        <a href="javascript:void(0);" id="multiple-delete" class="btn btn-danger btn-sm my-5 me-2">
            <i class="fa-solid fa-trash"></i>
        </a> -->

        <!--begin::Action-->
        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-left btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            Actions
            <i class="ki-duotone ki-down fs-5 ms-1"></i>
        </a>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">



            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ route('user.add') }}" class="menu-link px-3 btn-sm"> <i class=" fa-solid fa-plus text-primary "></i>&nbsp; Add</a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="javascript:void(0);" class="menu-link px-3 btn-sm multiple-delete"> <i class="fa-solid fa-trash text-danger"></i>&nbsp; Delete</a>
            </div>
            <!--end::Menu item-->










        </div>
        <!--end::Menu-->

        <!--end::Action-->
    </div>


    <div class="table-responsive">

        <table class="table">
            <thead>
                <tr class="fw-bold fs-6 text-gray-800">
                    <th style=" width: 10px; "> <input class="form-check-input" name="selected" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" value="" id="flexCheckDefault"></th>
                    <th>@sortablelink('first_name','First Name')</th>
                    <th>@sortablelink('last_name','Last Name')</th>
                    <th>@sortablelink('email','Email')</th>
                    <th>@sortablelink('status','Status')</th>
                    <th>@sortablelink('user_name','User Name')</th>
                    <th>@sortablelink('user_type','User Type')</th>
                    <th>@sortablelink('created_at','Create At')</th>
                    <th>@sortablelink('updated_at','Updated At')</th>
                    <th>Action</th>
                </tr>

                <tr class="fw-bold fs-6 text-gray-800">
                    <th style=" width: 10px; "></th>
                    <input wire:model="search" type="text" placeholder="Search users..."/>
                    <!-- <th><input type="text" style="width:100px;"name="filter_first_name" id="filter_first_name"></th> -->
                  
                    
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)

                <tr>
                    <th style=" width: 10px; "> <input class="form-check-input selected" name="selected[]" type="checkbox" value="{{ $user->user_id }}" id="flexCheckDefault"></th>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td> <span class="badge <?php if ($user->status == 'active') {
                                                echo 'badge-success';
                                            } else {
                                                echo 'badge-danger';
                                            } ?>">{{ $user->status }}</span> </td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->user_type }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>



                    <!-- <td>
                        <a href="#" class="btn btn-primary btn-sm"> <i class="fa-solid fa-eye"></i></a>
                        <a href="javascript:void(0);" user-id="{{ $user->user_id }}" class="btn btn-danger btn-sm single-delete"> <i class="fa-solid fa-trash"></i></a>
                    </td> -->

                    <td>
                        <!--begin::Action-->
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-left btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">



                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('user.edit',['user_id'=>$user->user_id]) }}" user-id="{{ $user->user_id }}" class="menu-link px-3 btn-sm "> <i class=" fa-solid fa-eye text-primary "></i>&nbsp; Edit</a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:void(0);" user-id="{{ $user->user_id }}" class="menu-link px-3 btn-sm single-delete"> <i class="fa-solid fa-trash text-danger"></i>&nbsp; Delete</a>
                            </div>
                            <!--end::Menu item-->










                        </div>
                        <!--end::Menu-->

                        <!--end::Action-->
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>


        <!-- Pagination Links -->
        <div class="d-flex justify-content-left mt-5">
            {!! $users->appends(\Request::except('page'))->render() !!}
        </div>

    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        //  $(document).ready(function() { 
        //     $('.single-delete').on('click',function(event){
        //     event.preventDefault();
        //     alert('working');
        // });

        //  });
    </script>


    <script>
        $(document).ready(function() {


            $('.single-delete').on('click', function(event) {
                event.preventDefault();
                const user_id = $(this).attr('user-id');
                $('#delete-modal').modal('show');
              
                $('#confirm-delete').on('click', function(event) {
                    $('#delete-modal').modal('hide');
                    try {
                    $.ajax({
                        url: `/user/destroy`,
                        data: {
                            user_id: user_id
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload();
                        }

                    });
                } catch (error) {
                    console.error('Error:', error);
                }
                });

                
              

            });



            $('.multiple-delete').on('click', function(event) {

                event.preventDefault();

                var user_ids = [];
                $('.selected:checked').each(function() {
                    user_ids.push(this.value);
                });


                $('#delete-modal').modal('show');

                $('#confirm-delete').on('click', function(event) {
                    $('#delete-modal').modal('hide');
                        try {
                            $.ajax({
                                url: `/user/destroy`,
                                data: {
                                    user_ids: user_ids
                                },
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    location.reload();
                                }

                            });
                        } catch (error) {
                            console.error('Error:', error);
                        }
                });






            });



        });
    </script>
</x-default-layout>