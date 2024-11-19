@extends('layouts.app')
@section('title', __('messages.title'))
@section('content')
<div>
    <head>
        <title>Product Details</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-LtrjvnR4Twt/qOuYxQvLDzS7fvKpZ+Z/47j6zjuGbXrdI15EZXIebhndOWJ3aOC6" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container mt-4">
            <div id="productDetails" class="text-center">
                <!-- Detalles del producto se insertarán aquí -->
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                // Obtener el ID desde la URL actual
                const productId = window.location.pathname.split('/').pop();

                // Hacer la petición AJAX
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: `http://34.16.118.156/public/api/games/${productId}`,
                    success: function(product) {
                        const productHTML = `
                            <div class="card mx-auto" style="width: 24rem;">
                                <img src="${product.image}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">Price: $${product.price}</p>
                                </div>
                            </div>`;
                        $('#productDetails').html(productHTML);
                    },
                    error: function(error) {
                        $('#productDetails').html('<p class="text-danger">Failed to load product details.</p>');
                    }
                });
            });
        </script>
    </body>
</div>
@endsection
