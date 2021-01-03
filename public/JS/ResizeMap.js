
let ResizeMap =
    {
        WidthDefault : 598,
        HeightDefault : 671,
        ImgActuel : document.querySelector('.FranceImg'),
        WImgActuel : 0,
        FirstLoadPage : true,
        init: function()
        {
            if(ResizeMap.FirstLoadPage)
            {
                ResizeMap.UpdateSizeMap();
                ResizeMap.FirstLoadPage = false;
                ResizeMap.WImgActuel = ResizeMap.ImgActuel.clientWidth;
            }

            let Coords = document.querySelectorAll('area');

            console.log(Coords[0].getAttribute('coords'));
            let Ratio = ResizeMap.WImgActuel / ResizeMap.WidthDefault;

            for(let i=0;i<Coords.length;i+=1)
            {
                let C = Coords[i].getAttribute('coords');
                let NewCoords  = ResizeMap.ResizeImg(C, Ratio);

                Coords[i].setAttribute("coords", NewCoords);
            }
        },
        ResizeImg : function (Coords, Ratio)
        {
            let CoordsArray = Coords.split(",");
            for(let i=0;i<CoordsArray.length;i+=1)
            {
                CoordsArray[i] = Math.round(Ratio * CoordsArray[i]);
            }

            return CoordsArray.join(",");
        },
        UpdateSizeMap : function()
        {
            $(window).resize(function()
            {
                clearTimeout(window.resizedFinished);
                window.resizedFinished = setTimeout(function()
                {
                    ResizeMap.init();
                }, 250);
            });
        }
    }


    ResizeMap.init();

