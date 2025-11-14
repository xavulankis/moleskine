@switch($file->getMimeType())
    @case('video/mp4')
        <i class="{{ $iconSize }} fa-solid fa-file-video"></i>
    @break

    @case('text/plain')
        <i class="{{ $iconSize }} fa-regular fa-file-lines"></i>
    @break

    @case('application/pdf')
        <i class="{{ $iconSize }} fa-regular fa-file-pdf"></i>
    @break

    @case('application/vnd.oasis.opendocument.text')
        <i class="{{ $iconSize }} fa-regular fa-file-word"></i>
    @break

    @case('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
        <i class="{{ $iconSize }} fa-regular fa-file-word"></i>
    @break

    @case('image/jpeg')
        <img class="w-12 md:w-24 mx-auto rounded-lg" src="{{ $file->temporaryURL() }}">
    @break

    @case('image/png')
        <img class="w-12 md:w-24 mx-auto rounded-lg" src="{{ $file->temporaryURL() }}">
    @break

    @default
        <i class="{{ $iconSize }} fa-solid fa-triangle-exclamation text-red-600 hover:text-red-400"
                title="Not a valid Format"></i>
@endswitch
