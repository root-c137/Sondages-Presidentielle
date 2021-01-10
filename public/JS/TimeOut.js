
let TimeOut =
    {
        init : function()
        {
            setInterval(TimeOut.updateDate, 1000 );
        },
        getDate : function()
        {
            let Now = new Date();
            let Heure = Now.getHours();
            let Minutes = Now.getMinutes();
            let Secondes = Now.getSeconds();

            let Date_TxtResult = Heure+"h "+Minutes+"m "+Secondes+"s";

            return Now;
        },
        updateDate : function()
        {
            let TimeOutElm = document.querySelector('#TimeOut');
            let DateElections = new Date("2022-04-08 00:00:00");

            let Diff = TimeOut.CalculDateDiff(TimeOut.getDate(), DateElections);
            TimeOutElm.textContent = 'Prochaine élection dans : '+Diff.day+' jours '+Diff.hour+' heures et '+Diff.sec+' secondes';
        },
        CalculDateDiff : function(date1, date2)
        {
            var diff = {}                           // Initialisation du retour
            var tmp = date2 - date1;

            tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
            diff.sec = tmp % 60;                    // Extraction du nombre de secondes

            tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
            diff.min = tmp % 60;                    // Extraction du nombre de minutes

            tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
            diff.hour = tmp % 24;                   // Extraction du nombre d'heures

            tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
            diff.day = tmp;

            return diff;
        }
    }


    TimeOut.init();