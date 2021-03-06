<div>
    <section class="section">
        <div class="section-header">
            <h1> {{  $title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Permissions</div>
            </div>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">All <span
                                            class="badge badge-white">{{ count($roles) }}
                                        </span></a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="#">Trash <span class="badge badge-primary">0</span></a>
                                </li> -->
                                <li class="nav-pill ml-auto">
                                    @can('roles.create')
                                    <a class="nav-link active" href="#" wire:click="open('add')" data-toggle="tooltip"
                                        title="Add New"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    @endcan
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="float-left">
                                <select class="form-control selectric">
                                    <option value=''>Action For Selected</option>
                                    @can('users.delete')
                                    <option value='delete' wire:click="confirm(null, true)">Delete</option>
                                    @endcan
                                </select>
                            </div>
                            <div class="float-right">
                                <form>
                                    <div class="input-group">
                                        <input wire:model="search" type="text" class="form-control"
                                            placeholder="Search">

                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>

                                        <th class="text-center pt-2">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    wire:click="multiple('all')" data-checkbox-role="dad"
                                                    class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Roles</th>
                                        <th>Guard</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        @if($role->name !== 'Super Admin' )
                                        <tr>
                                            <td class="text-center pt-2">
                                                @if($role->name !== 'Member')
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        wire:click="multiple" wire:model="selectedItems"
                                                        class="custom-control-input" value="{{ $role->id }}"
                                                        id="checkbox-{{ $role->id }}">
                                                    <label for="checkbox-{{ $role->id }}"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                                @endif
                                            </td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->guard_name }}</td>
                                            <td>{{ $role->created_at }}</td>
                                            <td>

                                                <div class="dropdown d-inline mr-2">
                                                    <button class="btn btn-primary " type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="top-start"
                                                        style="position: absolute; transform: translate3d(0px, -10px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        @can('roles.edit')
                                                        <a class="dropdown-item"
                                                            wire:click="open('update', {{ $role->id }})"
                                                            href="#">Edit</a>
                                                        <a class="dropdown-item"
                                                            wire:click="getPermissions({{ $role->id }})"
                                                            href="#">Setting
                                                            Permissions</a>
                                                        @endcan
                                                        @can('roles.delete')
                                                        @if($role->name !== 'Member')
                                                        <a class="dropdown-item" wire:click="confirm({{ $role->id }})"
                                                            href="#">Delete</a>
                                                        @endif
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $roles->links() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }} Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label for="name">Role's Name</label>
                            <input type="hidden" value="" wire:model="selectedItem">
                            <input wire:model="name" autofocus='' name="name" type="text" id=""
                                placeholder="Role's Name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }} </strong>
                            </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:keydown.enter="save" wire:click="save"
                        class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="permissionsModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Setting the Permissions for ') }} {{ $name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($actions as $key=>$act)
                    <div class="col-12 mb-3">
                        <h6>{{ ucwords($key) }}</h6>
                        @foreach($act as $k=>$a)
                        <div class="custom-control custom-checkbox">
                            <input wire:click="multiple" wire:model="selectedItems" type="checkbox"
                                value="{{$key}}.{{$k}}" class="custom-control-input" id="select{{$key}}.{{$k}}">
                            <label class="custom-control-label" for="select{{$key}}.{{$k}}">{{ $a }}</label>
                        </div>

                        @endforeach
                    </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" wire:click="updatePermission" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
