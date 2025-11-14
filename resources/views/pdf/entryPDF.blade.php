<!DOCTYPE html>
<html>

<head>
    <title>Entry Information - ID({{ $id }})</title>
    <!-- CSS, DomPDF requires using the absolute local path to the CSS file -->
    <link href="{{ public_path('css/pdfTable.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">

        <table>

            {{-- <thead> --}}
            <tr>
                <td class="tdHeader" colspan="2">Entry Information</td>
            </tr>
            {{-- </thead> --}}

            <tbody>
                <tr>
                    <td class="tdInfo">Id</td>
                    <td>{{ $id }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">User</td>
                    <td>{{ $user_name }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Date</td>
                    <td>{{ $date }}</td>
                </tr>                
                <tr>
                    <td class="tdInfo">Title</td>
                    <td>{{ $title }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Value</td>
                    <td>{{ $value }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Description</td>
                    <td>{{ $description }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Url</td>
                    <td>{{ $url }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Place</td>
                    <td>{{ $place }}</td>
                </tr>
                <tr>
                    <td class="tdInfo">Autor</td>
                    <td>{{ $autor }}</td>
                </tr>    
                <tr>
                    <td class="tdInfo">Category</td>
                    <td><span class="badge_category">{{ $category_name }}</span></td>
                </tr>
                <tr>
                    <td class="tdInfo">Tags</td>
                    <td>
                        @foreach ($tags as $tag)
                            <span class="badge_tag">{{ $tag['name'] }}</span>
                        @endforeach
                    </td>
                </tr> 
                @if (isset($info))
                    <tr>
                        <td class="tdInfo">Info</td>
                        <td>{!! $info !!}</td>
                    </tr>
                @else
                    <tr>
                        <td class="tdInfo">Info</td>
                        <td>-</td>
                    </tr>
                @endif

            </tbody>

        </table>

        @if (isset($files))

            <div class="page_break">
            </div>

            <div class="page_break">

                <table>
                    <tr>
                        <td class="tdInfo">Files</td>
                    </tr>
                    @foreach ($files as $file)
                        <tr>
                            @include('pdf.partial-media-file', $file)
                        </tr>
                    @endforeach
                </table>

            </div>

        @endif


    </div>

</body>

</html>
