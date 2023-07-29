$(document).ready(function(){
    $("#s").on('input', function(){
        let userInput = $(this).val();
        let data = {userInput: userInput};

        $.ajax({
            url: "?mod=ajax&action=searchProcess",
            method: "POST",
            data: data,
            dataType: "json",
            success: function(data){

                console.log(data);

                let dataRender = '';
                data.data_search.forEach(element => {
                    let dataItem = `
                        <li class="clearfix">
                            <a href="${element.url}" title="" class="thumb-search fl-left">
                                <img src="admin/${element.thumbnail}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="${element.url}" title="" class="product-name-search">${element.name} (${parseInt(element.price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })})</a>
                                <a href="${element.url_buy_now}" title="Mua ngay" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                    `;

                    dataRender += dataItem;
                });

                console.log(dataRender);

                $(".list-search").html(dataRender);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });
})