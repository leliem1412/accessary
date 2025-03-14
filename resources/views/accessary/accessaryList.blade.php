@foreach ($accessaries as $accessary)
    <tr>
        <td></td>
        <td>{{ $accessary->name }}</td>
        <td>{{ number_format($accessary->price, 0, '', '.') }}</td>
        <td>{{ number_format($accessary->quantityImport, 0, '', '.') }}</td>
        <td>{{ number_format($accessary->quantityExport, 0, '', '.') }}</td>
        <td style="color: {{ $accessary->quantityStock < $accessary->quantityMin ? 'red' : '#000' }}">
            {{ number_format($accessary->quantityStock, 0, '', '.') }}</td>
        <td>
            {{ number_format($accessary->quantityMin, 0, '', '.') }}</td>
        <td>{{ $accessary->supplier->name }}</td>
        <td>{{ date_format($accessary->created_at, 'd/m/Y') }}</td>
        <td style="cursor: pointer;">
            <div class="btn-group">
                <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Tác vụ
                </div>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item editQuanityImport" href="#" data-id='{{ $accessary->id }}'>Nhập
                            kho</a></li>
                    <li><a class="dropdown-item editQuanityExport" href="#" data-id='{{ $accessary->id }}'>Xuất
                            kho</a></li>
                    <li><a class="dropdown-item edit" href="#" data-id='{{ $accessary->id }}'>Sửa</a></li>
                    <li><a class="dropdown-item delete" href="#" data-id='{{ $accessary->id }}'>Xoá</a></li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
