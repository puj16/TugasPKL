<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#tampil').on('click', function() {
                    var tahun = $('#search').val();
                    $.ajax({
                        url: '/home',
                        type: 'GET',
                        data: { search: tahun },
                        success: function(response) {
                            $('#table-container').html(response);
                            $('#search').val(tahun);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#download').click(function() {
                    var tahun = $('#search').val();
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("export-csv") }}',
                        data: {search: tahun},
                        success: function(response) {
                            // Unduh file CSV
                            var blob = new Blob([response], { type: 'text/csv' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'laporan_penjualan_' + tahun + '.csv';
                            link.click();
                        }
                    });
                });
            });
        </script>
    </body>
</html>