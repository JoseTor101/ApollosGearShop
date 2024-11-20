// api.js - Handles external API requests for products

// Fetch products from the API and render them dynamically
$(document).ready(function () {
    const apiUrl = $('meta[name="api-url"]').attr('content'); // Fetch URL from meta tag

    $.ajax({
        type: "GET",
        dataType: "json",
        url: apiUrl,
        success: function (data) {
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
        error: function (error) {
            $('#infoProducts').html('<p class="text-danger">Failed to load products.</p>');
        }
    });
});
