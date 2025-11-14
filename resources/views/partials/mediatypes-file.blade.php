{{-- 
Check the file media type, iconSize and imagesBig to determine which kind of icon show
In Workout Main small icons, in Workout Info and Upload big icons. 
--}}

@switch($file->media_type)
    @case('video/mp4')
        <a href="{{ asset('storage/' . $file->path) }}" title="Open Video" target="_blank">
            <i class="{{ $iconSize }} fa-solid fa-file-video"></i>
        </a>
    @break

    @case('text/plain')
        <i class="{{ $iconSize }} fa-regular fa-file-lines"></i>
    @break

    @case('application/pdf')
        <a href="{{ asset('storage/' . $file->path) }}" title="Open PDF" target="_blank">
            <i class="{{ $iconSize }} fa-regular fa-file-pdf"></i>
        </a>
    @break

    @case('application/vnd.oasis.opendocument.text')
        <i class="{{ $iconSize }} fa-regular fa-file-word"></i>
    @break

    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
        <i class="{{ $iconSize }} fa-regular fa-file-word"></i>
    @break

    @case('image/jpeg')
        <a href="{{ asset('storage/' . $file->path) }}" title="Open Image" target="_blank">
            @if ($imagesBig)
                <img src="{{ asset('storage/' . $file->path) }}" class="w-12 md:w-24 mx-auto">
            @else
                <i class="{{ $iconSize }} fa-regular fa-image"></i>
            @endif
        </a>
    @break

    @case('image/png')
    <a href="{{ asset('storage/' . $file->path) }}" title="Open Image" target="_blank">
        @if ($imagesBig)
            <img src="{{ asset('storage/' . $file->path) }}" class="w-12 md:w-24 mx-auto rounded-lg">
        @else
            <i class="{{ $iconSize }} fa-regular fa-image"></i>
        @endif
    </a>
    @break

    @default
        <i class="{{ $iconSize }} fa-solid fa-triangle-exclamation text-red-600 hover:text-red-400"
            title="Not a valid Format"></i>
@endswitch
