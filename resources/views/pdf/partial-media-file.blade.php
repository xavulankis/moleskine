@switch($file['media_type'])
   {{--  @case('application/vnd.ms-excel')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-csv-solid.svg') }}"></td>
    @break

    @case('text/csv')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-csv-solid.svg') }}"></td>
    @break

    @case('text/plain')
        <td class="icons"><img class="icon_img" src="{{ public_path('icons/file-lines-solid.svg') }}"></td>
    @break --}}   

    @case('application/pdf')
        <td class="icons">
            <img class="icon_img" src="{{ public_path('icons/file-pdf-solid.svg') }}">
            <a href="{{ asset('storage/' . $file['path']) }}" title="Open PDF" target="_blank">
            {{$file['original_filename']}}
        </a>
                       
        </td>
    @break
  
    @case('image/jpeg')
        <td class="icons"><img class="photo" src="{{ public_path('storage/' . $file['path']) }}"></td>
    @break

    @case('image/png')
    <td class="icons"><img class="photo" src="{{ public_path('storage/' . $file['path']) }}"></td>
    @break

    @default
        <td class="icons">{{-- <img class="icon_img" src="{{ public_path('icons/circle-exclamation-solid.svg') }}"> --}}{{ $file['original_filename'] }}</td>
@endswitch
