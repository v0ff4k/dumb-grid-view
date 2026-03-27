$(function () {

    // приватная функция (НЕ доступна из console)
    function Get() {
        $.ajax({
            url: 'get.php',
            method: 'POST',
            dataType: 'json',
            data: {
                arr: [1, 2, 3, 4] // произвольный массив
            },
            success: function (json) {

                if (!json.imgs) return;

                const grid = $("#content .grid");

                json.imgs.forEach(function (src) {
                    const item = `
                        <div class="item">
                            <div class="div">
                                <img src="${src}">
                            </div>
                        </div>
                    `;
                    grid.append(item);
                });
            }
        });
    }

    function updateSize() {
        const w = $('body').outerWidth();
        $('span.win_size').text(Math.round(w) + 'px');
    }

    updateSize();
    $(window).on('resize', updateSize);

    // наружу торчит только обработчик
    $('#pushMe').on('click', function () {
        Get();
    });

});
