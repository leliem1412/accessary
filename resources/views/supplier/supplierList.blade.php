@foreach ($suppliers as $supplier)
    <tr>
        <td></td>
        <td>{{ $supplier->name }}</td>
        <td>{{ $supplier->description }}</td>
        <td>{{ date_format($supplier->created_at, 'd/m/Y H:i')}}</td>
        <td style="cursor: pointer;">
            <div class="btn-group">
                <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Tác vụ
                </div>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item edit" href="#" data-id='{{ $supplier->id }}'>Sửa</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id='{{ $supplier->id }}'>Xoá</a></li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
