@extends('layouts.app')
@section('title', __('messages.title'))
@section('content')
<div>
    <head>
        <title>External API</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-LtrjvnR4Twt/qOuYxQvLDzS7fvKpZ+Z/47j6zjuGbXrdI15EZXIebhndOWJ3aOC6" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container mt-4">
            <div class="row" id="infoProducts">
                <!-- Los productos se insertarán aquí -->
            </div>
        </div>

        <script type="text/javascript">
            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'http://34.16.118.156/public/api/games',
                success: function(data) {
                    let htmlContent = '';
                    data.forEach(product => {
                        htmlContent += `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="${product.image}" class="card-img-top" alt="${product.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">Price: $${product.price}</p>
                                    </div>
                                </div>
                            </div>`;
                    });
                    $('#infoProducts').html(htmlContent);
                },
                error: function(error) {
                    $('#infoProducts').html('<p class="text-danger">Failed to load products.</p>');
                }
            });
        </script>
    </body>
</div>
@endsection
