
let Vote =
    {
        BaseUrl : "http://localhost:8000/",
        init : function()
        {
            let ButtonsVote = document.querySelectorAll('.Voter');

            for(let i=0;i<ButtonsVote.length;i+=1)
                ButtonsVote[i].addEventListener('click', Vote.voteInit);
        },
        voteInit : function(Ev)
        {
            let ParentElm = Ev.currentTarget.parentNode;
            let Candidat = ParentElm.firstElementChild.getAttribute('class').split(' ');
            let ButtonVote = ParentElm.querySelector('.Voter');

            Vote.voter(Candidat[1], ButtonVote);
        },
        voter : function(Candidat, ButtonVote)
        {
            let Url = Vote.BaseUrl+'vote/'+Candidat;
            let FetchOptions =
                {
                    method : 'GET',
                    mode : 'cors',
                    cache : 'no-cache'
                };

            fetch(Url, FetchOptions)
                .then(function(response)
                    {
                        if(response.status == 201)
                            ButtonVote.textContent = 'Modifier votre vote';
                    }
                )
                .catch(error => alert("Erreur : " + error))
            ;

        },
        UpdateButton: function()
        {

        }
    }



    Vote.init();