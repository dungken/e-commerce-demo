$(document).ready(function () {
    $("#num-order[data-id]").change(function () {
    let id = $(this).attr("data-id");
    let num_order = $(this).val();

    let data = {
        id: id,
        num_order: num_order,
    };

    $.ajax({
        url: "?mod=ajax&action=updateProcess",
        method: "POST",
        data: data,
        dataType: "json",
        success: function (data) {
            $(`#sub_total[data-id='${id}']`).text(data.sub_total);
            $("#total").text(data.total);
            $(".price-total").html(data.total);
            
            let numCartElements = document.querySelectorAll('#number_cart');
            for (let i = 0; i < numCartElements.length; i++) {
                // console.log(numCartElements[i]);
                numCartElements[i].textContent = data.num_cart;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        },
        });
    });
});
