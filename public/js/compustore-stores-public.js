(function ($) {
    'use strict';
    $(document).ready(function () {
        let map_list_item = $('.compu_main_map_list li');

        ////////////////// Initial Map load ///////////////////////////////////
        let markerArray = [];
        let markerIcon = L.icon({
            iconUrl: compu_map_data.plugin_img_dir + 'map_marker.png',
            iconSize: [25, 38]
        });
        map_list_item.each(function () {
            let pos = $(this).data('position');
            let loc = pos.split(',');
            markerArray.push(L.marker(loc, {icon: markerIcon}));
        })
        let map = L.map('compu_map').setView([51.1657, 10.4515], 13);
        let group = L.featureGroup(markerArray).addTo(map);
        map.fitBounds(group.getBounds(), {padding: [50, 50]});

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20,
        }).addTo(map);

        function onMapClick(e) {
            var marker = L.marker(e.latlng).addTo(mymap);
        }
        map.on('click', onMapClick);

        /////////////////////////////////////////////////////

        ////////////////// Load map clicking on location ///////////////////////////////////
        map_list_item.on('click', function () {

            drawMap($(this))
            //
            $(map_list_item).removeClass('show');
            $(this).addClass('show')
            if ($(window).width() < 700){
                $('html, body').animate({
                    scrollTop: $("#compu_map").offset().top
                }, 'slow');
            }
            return false;

        });

        // Dram map function
        function drawMap(selector) {
            let zoom = 12;
            let pos = selector.data('position');
            let loc = pos.split(',');
            map.setView(loc, zoom, {animation: true});

            // Custom market icon
            let markerIcon = L.icon({
                iconUrl: compu_map_data.plugin_img_dir + 'map_marker.png',
                iconSize: [25, 38]
            });
            let newMarker = new L.marker(loc, {icon: markerIcon}).addTo(map);
            //

            // Show address as popup while clicking on the location
            let map_popup_content = `<b>${selector.data('title')}</b><br><p>${selector.data('street')}</br>${selector.data('post-code')} ${selector.data('city')} ${selector.data('state')}</br><a href="tel:${selector.data('phone')}">${selector.data('phone')}</a></p>`;
            let popup = L.popup().setContent(map_popup_content);
            newMarker.bindPopup(popup).openPopup();
        }

        /////////////////////////////////////////////////////
        let compu_search_files = $('#compu_search');
        let compu_result_area = $('#compu_search_result_area');
        let compu_result_btn = $('#compu_search_btn');
        ;
        /* show content on click*/

        compu_search_files.keypress(function () {
            if ($(this).val().length > 1) {
                $.ajax({
                    url : compu_map_data.ajax_url,
                    type : "POST",
                    data :  {
                        'action': 'compu_stores_ajax_callback',
                        'compu_nonce': compu_map_data.compustore_nonce,
                        'compu_search_text': compu_search_files.val()
                    },
                    beforeSend: function(){
                        $("#comp_search_loader").show();
                    },
                    success : function(data){
                        compu_result_area.addClass('show_search')
                        compu_result_area.html(data)
                    },
                    complete:function(data){
                        $("#comp_search_loader").hide();
                    },
                });

            } else {

            }
        });
        compu_result_btn.on("click",function () {
            $.ajax({
                url : compu_map_data.ajax_url,
                type : "POST",
                data :  {
                    'action': 'compu_stores_ajax_callback',
                    'compu_nonce': compu_map_data.compustore_nonce,
                    'compu_search_text': compu_search_files.val()
                },
                beforeSend: function(){
                    $("#comp_search_loader").show();
                },
                success : function(data){
                    compu_result_area.addClass('show_search')
                    compu_result_area.html(data)
                },
                complete:function(data){
                    $("#comp_search_loader").hide();
                },
            });
        });
        $(document).on("click", '.compu_main_search_list li', function () {
            drawMap($(this))
            if ($(window).width() < 700){
                $('html, body').animate({
                    scrollTop: $("#compu_map").offset().top
                }, 'slow');
            }

            let search_id = $(this).data("id");
            $(document.body).animate({scrollTop: $("#cmi" + search_id).offset().top, duration: 400});

            let toGo = $(this).data("id");
            let toGoDiv = $("#cmi" + toGo);
            // $('.compu_main_map_list_wrap').animate({
            //     scrollTop: toGoDiv.position().top + $('.compu_main_map_list_wrap').scrollTop()
            // }, 'slow');
            $('.compu_main_map_list_wrap').scrollTop($('.compu_main_map_list_wrap').scrollTop() + toGoDiv.position().top);

            compu_search_files.val('');
            compu_result_area.html('');
            compu_result_area.removeClass('show_search');
            $(map_list_item).removeClass('show');
            toGoDiv.addClass('show')
console.log(toGoDiv.offset().top)
            return false;

        });

        // $(document).on('keypress',function(e) {
        //     if(e.which == 13) {
        //         $('.compu_main_search_list li')[0].click();
        //         return false;
        //
        //         drawMap($(this))
        //         let search_id = $(this).data("id");
        //         $(document.body).animate({scrollTop: $("#cmi" + search_id).offset().top, duration: 400});
        //
        //         let toGo = $(this).data("id");
        //         $('html,body').animate({
        //             scrollTop: $("#cmi" +toGo).offset().top
        //         }, 'slow');
        //         $(map_list_item).removeClass('show');
        //         $("#cmi" +toGo).addClass('show')
        //         return false;
        //     }
        // });

    })


})(jQuery);

