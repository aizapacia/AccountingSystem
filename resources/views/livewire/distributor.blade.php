<div>
    <div class="content mt-3">
        <div class="d-flex justify-content-end">
            <div style="max-width: 400px" class="d-flex justify-content-end">
                <input type="search" class="filter-input" wire:model="searchval">
                <select name="" id="" class="filter-input ms-1" wire:model="attribute">
                    <option value="users.id">ID</option>
                    <option value="first_name">Name</option>
                    <option value="email">Email</option>
                    <option value="phone">Phone</option>
                    <option value="state">Address</option>
                    <option value="vip_package">Vip Package</option>
                </select>
            </div>
        </div>

        <div class="overflow-auto container-table">
            <table>
                <thead>
                    <tr>
                        <th>Distributor ID</th>
                        <th>Distributor Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>VIP Package</th>
                        <th>Price per Local</th>
                        <th>Price per Outstation</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($dis))
                    @foreach($dis as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{$d->first_name . ' ' . $d->last_name}}</td>
                        <td>{{$d->email}}</td>
                        <td>{{$d->phone}}</td>
                        <td>{{$d->state }}</td>
                        <td>-</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="11">
                            <div class="nodata-table">
                                No data available <i class="bi bi-file-earmark-excel"></i>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- navigation -->
    <div>
        @if(!empty($dis))
        {{ $dis->links('pagination') }}
        @endif
    </div>


</div>