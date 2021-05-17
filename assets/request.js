import $ from "jquery";

$(document).ready(function() {

    function filterInt(value) {
        if (/^(-|\+)?(\d+)$/.test(value)) {
            return Number(value);
        }
    }

    $.ajax({
        url : "../products",
        type: "GET",
        dataType: "json",
        success: function(data) {

            $.each(data, function(item) {
                $("#phones_list").append("<div class='flex-main-box col s12 m12 l6'><div class='flex-product-box'><img class='flex-image' src="+ data[filterInt(item)].image +" /><a class='flex-link' href='../bilemo/products/"+ data[filterInt(item)].id +"'><p class='flex-title'>"+ data[filterInt(item)].phone +" - "+ data[filterInt(item)].trademark +"</p></a><p class='flex-summary'>"+ data[filterInt(item)].summary +"</p><p class='flex-price'>"+ data[filterInt(item)].price +" €</p></div></div>");
            });

        }
    });

});
