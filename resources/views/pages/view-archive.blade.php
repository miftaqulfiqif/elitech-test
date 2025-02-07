<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Contents Archive</title>

    <style>
        body {
            --tw-bg-opacity: 1;
            background-color: rgb(15 23 42 / var(--tw-bg-opacity, 1));
        }

        table * {
            color: white;
        }

        h1 {
            display: flex;
            justify-content: center;
            margin: 20px;
            color: white;
        }

        div {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 20px
        }

            {
            display: flex;
            flex-direction: row;
        }
    </style>
</head>

<body>
    <h1>Contents Archive</h1>
    <div class="">
        <button id="export_xlsx" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Download .xlsx
        </button>
        <button id="export_pdf" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Download .pdf
        </button>

    </div>

    {{-- Start Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih filter tanggal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="export_form" action="{{ route('export.xlsx') }}" method="GET">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="col-md-8">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success mt-4">Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}

    <table class="table">
        <thead>
            <tr>
                <th scope="col">No. </th>
                <th scope="col">Thumbnail</th>
                <th scope="col">Content Posted</th>
                <th scope="col">Caption</th>
                <th scope="col">Date Post</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($contentArchive as $index => $content)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><img src="{{ asset('storage/' . $content->content->file_path) }}" width="50"></td>
                    <td>{{ $content->content->file_path }}</td>
                    <td>{{ $content->content->caption }}</td>
                    <td>{{ $content->content->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('export.xlsx') }}", // Ganti dengan route Laravel Anda
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Data berhasil disimpan!');
                        $('#exampleModal').modal('hide');
                        $('#dataForm')[0].reset(); // Reset form setelah submit
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });

        $('#export_xlsx, #export_pdf').click(function(e) {
            e.preventDefault();
            $('#export_form').attr('action', $(this).attr('id') === 'export_xlsx' ? "{{ route('export.xlsx') }}" :
                "{{ route('export.pdf') }}");
        });
    </script>

</body>

</html>
