import $ from "jquery";

$(document).ready(function() {

    $.ajax({
        url : "../products",
        type: "GET",
        dataType: "json",
        success: function(data) {

            $.each(data, function(item, value) {
                $("#phones_list").append("<div class='flex-main-box col s12 m12 l6'><div class='flex-product-box'><img class='flex-image' src="+ data[item].image +" /><a class='flex-link' href='../bilemo/products/"+ data[item].id +"'><p class='flex-title'>"+ data[item].phone +" - "+ data[item].trademark +"</p></a><p class='flex-summary'>"+ data[item].summary +"</p><p class='flex-price'>"+ data[item].price +" €</p></div></div>");
            });

        },
        error: function (error) {
            console.log(error);
        }
    });

});
